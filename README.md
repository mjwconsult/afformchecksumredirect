# afformchecksumredirect

This extension provides a "hack" to allow redirecting a formbuilder form to a quickform using a checksum.

The redirect is currently hardcoded in `CRM_Afformchecksumredirect_Checksumredirect::mapRedirect()`.

In formbuilder you must configure the post-submit redirect as follows:

`civicrm/affredir?csr=0&token=[token]`

such that it contains:
 - csr: A number which tells the redirect which rule to use.
 - token: The JWT token provided by FormBuilder.


The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Installation

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Update / Usage

Redirect rules can be configured in Adminster->System Settings->afformchecksumredirect Settings.

The default is:

`0:contributionpage:2`

which means csr=0. Redirect type is "Contribution page". Contribution Page ID is 2.

You could configure additional rules (one per line) eg:

```
0:contributionpage:2
1:contributionpage:5
```

So if you specified csr=1 then the user would be redirected to contribution page 5.

Requires Contact ID / Membership ID from form submission.
