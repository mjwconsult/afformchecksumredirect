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
    switch ($afformSubmission['name']) {
      case 'afformIndividualMembershipApp':
        if (empty($afformSubmission['data']['Individual1'][0]['id'])) {
          throw new CRM_Core_Exception('invalid redirect');
        }
        $contactID = $afformSubmission['data']['Individual1'][0]['id'];
        $quickformSessionTimeout = (int) Civi::settings()->get('secure_cache_timeout_minutes');
        $quickformSessionTimeout = $quickformSessionTimeout / 60;

        $checksum = CRM_Contact_BAO_Contact_Utils::generateChecksum($contactID, NULL, $quickformSessionTimeout);
        $queryParams = [
          'id' => 2, // Contribution Page ID
          'cs' => $checksum, // Checksum
          'cid' => $contactID // Contact ID
        ];
        if (!empty($afformSubmission['data']['Membership1'][0]['id'])) {
          // Add the membership ID
          $queryParams['mid'] = $afformSubmission['data']['Membership1'][0]['id'];
        }
        CRM_Utils_System::redirect(CRM_Utils_System::url('civicrm/contribute/transact', $queryParams));
        break;
    }

  }

}
