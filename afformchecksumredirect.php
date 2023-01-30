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
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function afformchecksumredirect_civicrm_postInstall(): void {
  _afformchecksumredirect_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function afformchecksumredirect_civicrm_uninstall(): void {
  _afformchecksumredirect_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function afformchecksumredirect_civicrm_enable(): void {
  _afformchecksumredirect_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function afformchecksumredirect_civicrm_disable(): void {
  _afformchecksumredirect_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function afformchecksumredirect_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _afformchecksumredirect_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function afformchecksumredirect_civicrm_entityTypes(&$entityTypes): void {
  _afformchecksumredirect_civix_civicrm_entityTypes($entityTypes);
}
