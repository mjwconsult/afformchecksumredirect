<?php

use Civi\API\Exception\UnauthorizedException;

class CRM_Afformchecksumredirect_Checksumredirect {

  public static function redirect() {

    $token = CRM_Utils_Request::retrieveValue('token', 'String', NULL, TRUE, 'GET');
    $contactID = CRM_Utils_Request::retrieveValue('contact_id', 'Positive', NULL, TRUE, 'GET');

    /** @var \Civi\Crypto\CryptoJwt $jwt */
    $jwt = \Civi::service('crypto.jwt');

    // Double-decode is needed to convert PHP objects to arrays
    $info = json_decode(json_encode($jwt->decode($token)), TRUE);

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
        CRM_Utils_System::redirect(CRM_Utils_System::url('civicrm/contribute/transact', ['id' => 2, 'cs' => $checksum, 'cid' => $contactID]));
        break;

    }

  }

}
