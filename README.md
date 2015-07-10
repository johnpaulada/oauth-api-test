# OAuth2 Implementation Docs #

The fastest way to implementing OAuth2 in this project is to use a Symfony OAuth2 Bundle, since Symfony2 serves as the PHP framework for the API. The [FOSOAuthServerBundle](https://github.com/FriendsOfSymfony/FOSOAuthServerBundle) was selected for this purpose.

## Installing the FOSOAuthServerBundle ##

[Composer](https://getcomposer.org/) is needed for the initial steps so please make sure it is installed. If it isn't, please download it by following the instructions [here](https://getcomposer.org/download/).

If Composer is already installed, then the FOSOAuthServerBundle can now be installed. To install it we need to:

### Step 1: Require bundle ###
Add the said bundle on the require portion of `composer.json`:

```javascript
{
    "require": {
        // ...
        "friendsofsymfony/oauth-server-bundle": "dev-master"
    }
}
```
### Step 2: Install bundle ###
Run `composer install` and `composer update`.

### Step 3: Enable bundle ###
After that, enable the bundle in `app/AppKernel.php` by adding `new FOS\OAuthServerBundle\FOSOAuthServerBundle()` in the `registerBundles()` function:

```php
    <?php
        public function registerBundles()
        {
            $bundles = array(
                // ...
                new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
            );
        }
    ?>
```
### Step 4 ###