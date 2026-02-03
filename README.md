# FormBuilder Redirect

This extension allows you to redirect to other Forms or Contribution Pages in the same way as using secret links/checksums.

This means you can give the user a secret link to a form instead of them logging in. They can then submit that form and be redirected
to another Formbuilder form or a Contribution Page where they will still have the same access as the original secret link.

In FormBuilder you must configure the post-submit redirect as follows:

`civicrm/affredir?csr=0&token=[token]`

such that it contains:
- csr: A number which tells the redirect which rule to use.
- token: The JWT token provided by FormBuilder.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Installation

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Update / Usage

Redirect rules can be configured in Adminster->Customize Data and Screens->FormBuilder Checksum Redirect Settings.

The default is:

`0:contributionpage:2`

which means csr=0. Redirect type is "Contribution page". Contribution Page ID is 2.

You could configure additional rules (one per line) eg:

```
0:contributionpage:2
1:afform:afformMyDetails
```

So if you specified csr=1 then the user would be redirected to a Form with name `afformMyDetails`.
If you specified csr=0 then the user would be redirected to Contribution Page 2.

Requires Contact ID from form submission.
For Contribution pages you can optionally specify Membership ID as well.

## Support and Maintenance

This extension is supported and maintained with the help and support of the CiviCRM community by [MJW](https://www.mjwconsult.co.uk).

We offer paid [support and development](https://mjw.pt/support) as well as a [troubleshooting/investigation service](https://mjw.pt/investigation).