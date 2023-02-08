# GovCore Core
GovCore Core provides shared base functionality and APIs for the GovCore
distribution of Drupal 8. You probably won't have a reason to install it
unless another module requires this one.

### Components
GovCore Core's components are not enabled by default. You can install them
like any other Drupal modules.

#### GovCore Contact Form (`govcore_contact_form`)
Provides a standard-issue sitewide contact form which stores submissions using
the [Contact Storage](https://drupal.org/project/contact_storage) module.

#### GovCore Page (`govcore_page`)
Provides a simple "Basic page" content type, similar the one installed by
Drupal 8's standard profile. Also integrates with the
[Metatag](https://drupal.org/project/metatag) module, if available.

Please note: **this component is NOT compatible with the Standard Drupal 8
install profile!**

#### GovCore Roles (`govcore_roles`)
Provides a generic way to define responsibility-based user roles centered
around content types. For example, a "creator" role can be automatically
defined for each content type, with permissions applicable to that content
type.

#### GovCore Search (`govcore_search`)
Uses [Search API](https://drupal.org/project/search_api) to provide a standard,
turnkey site-wide search index of all your site's content.

### Installation
This component can only be installed using Composer. To add it to your Drupal
code base:

```
composer config repositories.drupal composer https://packages.drupal.org/8
composer require govcore/govcore_core
```

#### Updates
GovCore Core and its components use the normal Drupal database update system
as often as possible. However, there are occasionally certain updates which
touch configuration and may change the functionality of your site. These updates
are optional, and are performed by a special utility at the command line. This
utility is compatible with both
[Drupal Console](https://github.com/hechoendrupal/drupal-console) and
[Drush](https://drush.org) 9 or later.

To run updates using Drush 9:

`
drush update:govcore
`

With Drupal Console:

`
drupal update:govcore
`

#### Known Issues
None yet.
