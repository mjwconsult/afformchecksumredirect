<?php

require_once 'afformchecksumredirect.civix.php';
// phpcs:disable
use CRM_Afformchecksumredirect_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function afformchecksumredirect_civicrm_config(&$config): void {
  _afformchecksumredirect_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function afformchecksumredirect_civicrm_install(): void {
  _afformchecksumredirect_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function afformchecksumredirect_civicrm_enable(): void {
  _afformchecksumredirect_civix_civicrm_enable();
}
