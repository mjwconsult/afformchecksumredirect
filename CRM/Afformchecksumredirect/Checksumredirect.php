<?php

use Civi\API\Exception\UnauthorizedException;

class CRM_Afformchecksumredirect_Checksumredirect {

  public static function redirect() {
    $token = CRM_Utils_Request::retrieveValue('token', 'String', NULL, TRUE, 'GET');

    /** @var \Civi\Crypto\CryptoJwt $jwt */
    $jwt = \Civi::service('crypto.jwt');

    /*
     * Civi\Crypto\Exception\CryptoException: UnexpectedValueException:
     * Wrong number of segments in afformchecksumredirect/CRM/Afformchecksumredirect/Checksumredirect.php on line 14
     */
    try {
      // Double-decode is needed to convert PHP objects to arrays
      $info = json_decode(json_encode($jwt->decode($token)), TRUE);
    }
    catch (Exception $e) {
      \Civi::log()->error('Checksumredirect: ' . $e->getMessage() . '; Referrer: ' . $_SERVER['HTTP_REFERER']);
      throw new CRM_Core_Exception('invalid redirect');
    }

    if ($info['scope'] !== 'afformPostSubmit') {
      throw new CRM_Core_Exception('invalid redirect');
    }

    if ($info['exp'] < \CRM_Utils_Time::time()) {
      throw new CRM_Core_Exception('invalid redirect');
    }

    self::mapRedirect($info['civiAfformSubmission']);


  }

  /**
   * This function should be split into a hook/configuration or similar
   *
   * @return void
   */
  public static function mapRedirect($afformSubmission) {

    // Get redirect configuration
    $configs = preg_split("/\r\n|\n|\r/", \Civi::settings()->get('afformchecksumredirect_redirects'));
    foreach ($configs as $config) {
      list($index, $redirectType, $param1) = explode(':', $config);
      if (empty($redirectType)) {
        \Civi::log()->error('afformchecksumredirect_redirects is not configured correctly.');
        continue;
      }
      $redirectTypes[$index] = [
        'type' => $redirectType,
        'param1' => $param1,
      ];
    }

    $csr = CRM_Utils_Request::retrieveValue('csr', 'String', NULL, TRUE, 'GET');
    if (!is_numeric($csr)) {
      throw new CRM_Core_Exception('invalid redirect');
    }

    $csrRedirectType = $redirectTypes[$csr]['type'];
    switch ($csrRedirectType) {
      case 'contributionpage':
        if (empty($afformSubmission['data']['Individual1'][0]['id'])) {
          throw new CRM_Core_Exception('invalid redirect');
        }
        $contactID = $afformSubmission['data']['Individual1'][0]['id'];
        $quickformSessionTimeout = (int) Civi::settings()->get('secure_cache_timeout_minutes');
        $quickformSessionTimeout = $quickformSessionTimeout / 60;

        $checksum = CRM_Contact_BAO_Contact_Utils::generateChecksum($contactID, NULL, $quickformSessionTimeout);
        $queryParams = [
          'id' => $redirectTypes[$csr]['param1'], // Contribution Page ID
          'cs' => $checksum, // Checksum
          'cid' => $contactID, // Contact ID
          //'action' => 'preview',
        ];
        if (!empty($afformSubmission['data']['Membership1'][0]['id'])) {
          // Add the membership ID
          $queryParams['mid'] = $afformSubmission['data']['Membership1'][0]['id'];
        }
        CRM_Utils_System::redirect(CRM_Utils_System::url('civicrm/contribute/transact', $queryParams));
        break;

      case 'afform':
        $contactID = $afformSubmission['data']['Individual1'][0]['id'];
        $afform = (array) \Civi\Api4\Afform::get(FALSE)
          ->addWhere('server_route', 'IS NOT EMPTY')
          ->addWhere('name', '=', $redirectTypes[$csr]['param1'])
          ->addSelect('name', 'title', 'server_route', 'is_public')
          ->execute()
          ->indexBy('name')
          ->first();
        $url = \Civi\Afform\Tokens::createUrl($afform, $contactID);
        CRM_Utils_System::redirect($url);
        break;
    }
  }

}
