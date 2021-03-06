# LDAP Lookup
=================
LDAP lookup is a simple LDAP entries lookup provider for use with in Laravel 5.1 +

## Installation

The tool requires you have [PHP](https://php.net) 5.5.9+ and [Composer](https://getcomposer.org).

To get the version of LDAP lookup that works with Laravel 5.1, add the following line to your `composer.json` file:
```
"maenbn/ldaplookup": "1.1.*"
```

Other wise for Laravel 5.2 add the following instead:

```
"maenbn/ldaplookup": "1.2.*"
```

Then run `composer install` or `composer update` to install.

You will also need to register the service provider by going into `config/app.php` and add the following to the `providers` key:
```
'Maenbn\LdapLookup\LdapLookupServiceProvider'
```
And you can also register the facade in the `aliases key in the same file like so:

```
'LdapLookup' => 'Maenbn\LdapLookup\Facades\LdapLookup'
```

## Configuration

A configuration for your LDAP server is required for the LdapLookup to work. First publish all vendor assets:

```bash
$ php artisan vendor:publish
```
which will create a `config/ldaplookup.php` file in your app where you can modify it to reflect your LDAP server `hostname`, `port`, `baseDn`, `bindRdn`, and `bindPassword`. You can also specify options in an array for your LDAP connection via the `options` key in the config file.

Add the following lines in your `.env` file:

```ini
LDAP_HOSTNAME=ldap.domain.com
LDAP_BASE_DN=dc=domain,dc=com
LDAP_BIND_RDN=cn=admin,dc=domain,dc=com
LDAP_BIND_PASSWORD=admin
LDAP_VERSION=3
```

## Usage

You can search for an indivdual user by carrying out the following:
```php
//Find the user with the test123 username
LdapLookup::getByUid('test123'); // will return an array
```
You can also run your own custom search by doing the following:
```php
LdapLookup::runSearch('mail=test*','first'); // will return first entry
LdapLookup::runSearch('mail=test*'); // will return all entries
```
