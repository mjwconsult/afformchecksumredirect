<?php
/*
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC. All rights reserved.                        |
 |                                                                    |
 | This work is published under the GNU AGPLv3 license with some      |
 | permitted exceptions and without any warranty. For full license    |
 | and copyright information, see https://civicrm.org/licensing       |
 +--------------------------------------------------------------------+
 */

use CRM_Afformchecksumredirect_ExtensionUtil as E;

return [
  'afformchecksumredirect_redirects' => [
    'name' => 'afformchecksumredirect_redirects',
    'type' => 'String',
    'html_type' => 'textarea',
    'default' => '0:contributionpage:2',
    'is_domain' => 1,
    'is_contact' => 0,
    'title' => E::ts('List of redirect configurations'),
    'description' => E::ts('Specify one configuration per line eg. 0:contributionpage:2 (index:redirectType:param1). Currently the only supported redirectType is "contributionpage". "index" is used in the redirect handler to identify what should be done.'),
    'html_attributes' => [
      'cols' => 60,
      'rows' => 4,
    ],
    'settings_pages' => [
      'afformchecksumredirect' => [
        'weight' => 15,
      ]
    ],
  ]
];
