# afformchecksumredirect

This extension provides a "hack" to allow redirecting a formbuilder form to a quickform using a checksum.

The redirect is currently hardcoded in `CRM_Afformchecksumredirect_Checksumredirect::mapRedirect()`.

In formbuilder you must configure the post-submit redirect as follows:

`civicrm/affredir?token=[token]&contact_id=[Individual1.0.id]`

such that it contains the new contact ID and the JWT token.


The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Installation

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Getting Started

