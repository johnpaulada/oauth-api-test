# OAuth2 Implementation Docs #

The fastest way to implementing OAuth2 in this project is to use a Symfony OAuth2 Bundle, since Symfony2 serves as the PHP framework for the API. The [FOSOAuthServerBundle](https://github.com/FriendsOfSymfony/FOSOAuthServerBundle) was selected for this purpose.

## Installing the FOSOAuthServerBundle ##

[Composer](https://getcomposer.org/) is needed for the initial steps so please make sure it is installed. If it isn't, please download it by following the instructions [here](https://getcomposer.org/download/).

If Composer is already installed, then the FOSOAuthServerBundle can now be installed. To install the bundle we need to:

### Step 1: Require the bundle ###
Add the said bundle on the require portion of `composer.json`:

```javascript
{
    "require": {
        // ...
        "friendsofsymfony/oauth-server-bundle": "dev-master"
    }
}
```

### Step 2: Install the bundle ###
Run `composer install` and `composer update`.

### Step 3: Enable the bundle ###
After that, enable the bundle in `app/AppKernel.php` by adding `new FOS\OAuthServerBundle\FOSOAuthServerBundle()` in the `registerBundles()` function <span> * </span> *<sup>[See <a href="#doc-notes">doc notes</a>]</sup>* :

```php
    <?php
        public function registerBundles()
        {
            $bundles = array(
                // ...
                new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
            )
        }
    ?>
```

## Creating important entities ##

### Creating the User entity ###
Create a User entity in your application bundle's Entity folder. You can use this as a template and just add or remove fields and methods <span> * </span> *<sup>[See <a href="#doc-notes">doc notes</a>]</sup>* :
```php
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {tha
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }
}

?>
```

Aside from the User entity, a UserRepository class should also be created <span> * </span> *<sup>[See <a href="#doc-notes">doc notes</a>]</sup>* :

`src/AppBundle/Entity/UserRepository`:

```php
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
}

?>
```

### Creating the UserProvider entity ###
We also need to be able to return a user object after they are authenticated so we need a UserProvider. Create this class on your bundle's Provider folder, e.g. `src/AppBundle/Provider`. You can use this as a template and add or remove information as you please <span> * </span> *<sup>[See <a href="#doc-notes">doc notes</a>]</sup>* :

```php
<?php

namespace AppBundle\Provider;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\NoResultException;

class UserProvider implements UserProviderInterface
{
    protected $userRepository;

    public function __construct(ObjectRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername($username)
    {
        $q = $this->userRepository
            ->createQueryBuilder('u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery();

        try {
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active admin AppBundle:User object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->userRepository->find($user->getId());
    }

    public function supportsClass($class)
    {
        return $this->userRepository->getClassName() === $class
        || is_subclass_of($class, $this->userRepository->getClassName());
    }
}

?>
```

### Creating FOSOAuthServerBundle Entities ###
The bundle requires a bunch of entities to be created in order for it to function. These are the AccessToken, AuthCode, Client, and RefreshToken entities <span> * </span> *<sup>[See <a href="#doc-notes">doc notes</a>]</sup>*.

#### Creating the AccessToken entity ####
Create the class using the following code, add it to your project bundle's Entity folder and just change the namespace or make other changes you deem necessary:
```php
<?php

namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AccessToken extends BaseAccessToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $user;
}

?>
``` 
#### Creating the AuthToken entity ####
Create the class using the following code, add it to your project bundle's Entity folder and just change the namespace or make other changes you deem necessary:
```php
<?php

namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\AuthCode as BaseAuthCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AuthCode extends BaseAuthCode
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $user;
}

?>
```

#### Creating the Client entity ####
Create the class using the following code, add it to your project bundle's Entity folder and just change the namespace or make other changes you deem necessary:

```php
<?php

namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Client extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}

?>
```

#### Creating the RefreshToken entity ####
Create the class using the following code, add it to your project bundle's Entity folder and just change the namespace or make other changes you deem necessary:

```php
<?php

namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class RefreshToken extends BaseRefreshToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $user;
}

?>
```

## Configuration ##
A couple of files have to be edited in order to configure the application correctly.

### security.yml ###
Setup the `security.yml` file like this:
```yaml
security:
    encoders:
        AppBundle\Entity\User:
            algorithm: bcrypt

    providers:
        in_memory:
            memory: ~

        entity_provider:
            id: user_provider

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt|error)|css|images|js)/
            security: false

        oauth_token:
            pattern: ^/oauth/v2/token
            security: false

        oauth_authorize:
            pattern: ^/oauth/v2/auth
            form_login:
                check_path: oauth_login_check
                login_path: oauth_login

        api:
            pattern: ^/api
            fos_oauth: true
            stateless: true
            anonymous: false
```

### services.yml ###
Setup the `services.yml` files like this:

`src/AppBundle/Resources/config/services.yml`:

```yaml
services:
    user_provider:
        class: AppBundle\Provider\UserProvider
        arguments: [@user_repo]
```

`src/AppBundle/Resources/config/repo.services.yml`:

```yaml
services:
    user_repo:
        class: AppBundle\Entity\UserRepository
        factory_service: doctrine.orm.default_entity_manager
        factory_method: getRepository
        arguments:
            - AppBundle\Entity\User
```

Remember to add import these resources to `app/config/config.yml`:

```yaml
imports:
    - { resource: parameters.yml }
    - { resource: security.yml }
    - { resource: services.yml }
    # Other imports
    - { resource: "@AppBundle/Resources/config/repo.services.yml" }
    - { resource: "@AppBundle/Resources/config/services.yml" }
```

### routing.yml ###
Initial routing configuration should look like this:

`app/config/routing.yml`:

```yaml
app:
    resource: "@AppBundle/Controller/"
    type:     annotation

fos_oauth_server_token:
    resource: "@FOSOAuthServerBundle/Resources/config/routing/token.xml"

fos_oauth_server_authorize:
    resource: "@FOSOAuthServerBundle/Resources/config/routing/authorize.xml"
```

### config.yml ###
Add this to the end of `app/config/config.yml`:

```yaml
fos_oauth_server:
    db_driver:           orm
    client_class:        AppBundle\Entity\Client
    access_token_class:  AppBundle\Entity\AccessToken
    refresh_token_class: AppBundle\Entity\RefreshToken
    auth_code_class:     AppBundle\Entity\AuthCode
    service:
        user_provider:   user_provider
```

## Creating the Client ##
### Create the Command ###

`src/AppBundle/Command/CreateClientCommand.php`:

```php
<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:oauth-server:client:create')
            ->setDescription('Creates a new client')
            ->addOption(
                'redirect-uri',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Sets redirect uri for client. Use this option multiple times to set multiple redirect URIs.',
                null
            )
            ->addOption(
                'grant-type',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Sets allowed grant type for client. Use this option multiple times to set multiple grant types..',
                null
            )
            ->setHelp(
                <<<EOT
                    The <info>%command.name%</info>command creates a new client.
                    <info>php %command.full_name% [--redirect-uri=...] [--grant-type=...] name</info>

EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris($input->getOption('redirect-uri'));
        $client->setAllowedGrantTypes($input->getOption('grant-type'));
        $clientManager->updateClient($client);
        $output->writeln(
            sprintf(
                'Added a new client with public id: <info>%s</info>, secret: <info>%s</info>',
                $client->getPublicId(),
                $client->getSecret()
            )
        );
    }
}

?>
```

### Running the Command ###
To create a client, just run this command:

```sh
php app/console app:oauth-server:client:create --redirect-uri="http://localhost/" --grant-type="authorization_code" --grant-type="password" --grant-type="refresh_token" --grant-type="token" --grant-type="client_credentials"
```

The result will be something like this:

```
Added a new client with public id: 1_2wpe3v9xqaas888kcgkwgcos8sks8484so4o4w4okw8sg84ssg, secret: 587m3z1elsgsck888sgc4googs8kwg0woc4kc8ock0o8socosw
```

### Store client credentials ###
Add the id and secret to `parameters.yml`:

`app/config/parameters.yml`:

```yaml
# This file is auto-generated during the composer install
parameters:
    # ...
    oauth_client_id: 1_2wpe3v9xqaas888kcgkwgcos8sks8484so4o4w4okw8sg84ssg
    oauth_client_secret: 587m3z1elsgsck888sgc4googs8kwg0woc4kc8ock0o8socosw
```

## Create important routes ##
Use the following code <span> * </span> *<sup>[See <a href="#doc-notes">doc notes</a>]</sup>* to create `SecurityController.php` in `src/AppBundle/Controller` and replace `AppBundle` with whatever the name of your application bundle is:

```php
<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * @Route("/oauth/v2/auth/login", name="oauth_login")
     */
    public function oauthLoginAction()
    {

    }

    /**
     * @Route("/oauth/v2/auth/login-check", name="oauth_login_check")
     */
    public function oauthLoginCheckAction()
    {

    }

    /**
     * @Route("/request-token")
     *
     * @param Request $request
     * @return Response
     */
    public function requestTokenAction(Request $request)
    {
        $id     = $this->container->getParameter('oauth_client_id');
        $secret = $this->container->getParameter('oauth_client_secret');

        $username = $request->query->get('username');
        $password = $request->query->get('password');

        return $this->redirect($this->generateUrl('fos_oauth_server_token', [
            'client_id'     => $id,
            'client_secret' => $secret,
            'username'      => $username,
            'password'      => $password,
            'grant_type'    => 'password'
        ]));
    }

    /**
     * @Route("/refresh-token")
     *
     * @param Request $request
     * @return Response
     */
    public function refreshTokenAction(Request $request)
    {
        $id     = $this->container->getParameter('oauth_client_id');
        $secret = $this->container->getParameter('oauth_client_secret');

        $token  = $request->query->get('refresh_token');

        return $this->redirect($this->generateUrl('fos_oauth_server_token', [
            'client_id'     => $id,
            'client_secret' => $secret,
            'grant_type'    => 'refresh_token',
            'refresh_token' => $token
        ]));
    }

    // Other actions ...

?>
```

## Usage ##
### Getting an access token ###
In order to get an access token, a GET request must be sent to the `/oauth/v2/token` endpoint with the client id and secret, and the `grant_type` set to `client_credentials` as parameters. The url can look something like this:

```
http://example.com/oauth/v2/token?client_id=1_1vqhl5u2h9lw4ocwgo84w8c0k488sowgc8og4c8440sg0wosk&client_secret=35nicwwh5fy8gos08gkcs4408wowwogo0cw484k8k8oookwoc&grant_type=client_credentials
```

If successful, the response will be an object in JSON format with the following fields:

1. access_token
2. expires_in
3. token_type
4. scope
5. refresh_token

### Making requests to the API ###
To make requests, you need an access token (see previous section). If you already have one, you can make requests to the API using the access token as the parameter. The url can look like something like this:

```
http://example.com/api/user/1?access_token=Zjk1YzNlMmNmNzk2NjBkMGU2NjE1MmM0NDdjZWE3Y2U3Yzg4ZjBkYzZkN2I5ODQ0ODU4YTU2NzUwYTI3YmY3NQ
```

You can also send an Authorization header like so:
```
Authorization: Bearer Zjk1YzNlMmNmNzk2NjBkMGU2NjE1MmM0NDdjZWE3Y2U3Yzg4ZjBkYzZkN2I5ODQ0ODU4YTU2NzUwYTI3YmY3NQ
```

####For requests that **require login/authentication**####
You need to have an authentication token in order to make requests that require authentication. To get an authentication token, send a `GET` request to the `/auth-token` endpoint with the user's email and password as parameters. You also need to send the access token along with the request.

#####*Example*#####
```
GET    http://local.api.gocambio.com/app_dev.php/auth-token?email=john.ada&password=asd123&access_token=Y2I5MWY1NTBjNDk5MTBjNGJjMGU5NWVmZWIyYjRmZTNmMjA3Y2RjOGE0YmE2NmE2YjAwMDY0ZWE5OGJjYTliYQ
```

#####*Response*#####
```
{
    "token": "b5cd315c9790c952e7a119503606ca8c7f9a2d7db16ad7f5153b254175bd81da39b533f422b50416b61a7ef8f053cdc54a8e9689bd708841eb0896fcc8885382"
}
```

The token in the response is the authentication token, which can be used to make requests that require authentication. To use the token, it must be set as the value of a `GC-Authentication-Token` header, like so:

```
GC-Authentication-Token: b5cd315c9790c952e7a119503606ca8c7f9a2d7db16ad7f5153b254175bd81da39b533f422b50416b61a7ef8f053cdc54a8e9689bd708841eb0896fcc8885382
```

### Getting another token after expiry ###
If the current access token expires, the another can be procured by getting the refresh token that came with the access token and sending a GET request `/oauth/v2/token` endpoint with the client id and secret, refresh token and the `grant_type` set to `refresh_token` as the parameter. The url can look something like this:

```
http://example.com/oauth/v2/token?client_id=1_1vqhl5u2h9lw4ocwgo84w8c0k488sowgc8og4c8440sg0wosk&client_secret=35nicwwh5fy8gos08gkcs4408wowwogo0cw484k8k8oookwoc&grant_type=refresh_token&refresh_token=OGJiYmFjZDcyNDBkYWFhY2FkM2FjYzMzMDY5N2UxZTkyNDAzMmNmYTk2NzViMjY0NTFmZGNjNzY5ZmNiZmQ0NA
```

If successful, the response will be an object containing a new access_token and refresh_token -- similar to the response to a request for an access token (see **Getting an access token**).

## Doc Notes ##
<a name="doc-notes"></a> <span> * </span> *The `?>` at the last line of the code is not included.*