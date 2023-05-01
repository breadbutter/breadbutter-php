## The official PHP library for Bread & Butter
This library allows you to connect your application to the authentication process of Bread & Butter. A user will be redirected to your application when a user is authenticated. Once this authentication is retrieved by your application you can perform an action like creating a user in your system or creating a session for that users.

### Installation
```
composer require breadbutter/breadbutter-php
```
## API
>For more information on the full **DIY Quick Start Guide** visit https://app.breadbutter.io/api/

Once the user's authentication is processed on by Bread & Butter, the user is redirected to a callback interface defined in your Bread & Butter app. The example below is a simple interface that accepts the request from Bread & Butter and processes the authentication.

> After the the interface is created you will need to update the Callback URL with the URL to this interface in your app settings here: https://app.breadbutter.io/app/#/app-settings

### Processing an authentication request

*Create a new instance of `BreadButterClient`*

- `APP_ID` can be found in https://app.breadbutter.io/app/#/app-settings
- `APP_SECRET` is configured at https://app.breadbutter.io/app/#/app-settings

```php
<?php
use BreadButter\API\BreadButterClient;
$breadButterClient = new BreadButterClient(array(
    'app_id' => '{APP_ID}',
    'app_secret' => '{APP_SECRET}',
));
```
*Retrieve authentication from Bread & Butter server*

> You can find the detailed API response here: https://breadbutter.io/api/server-api/

```php
<?php
$authenticationToken = $_REQUEST['authentication_token'];
$loginData = $breadButterClient->getAuthentication($authenticationToken);

$body = $loginData['body'];
$authData = $body['auth_data'];

$email = $authData['email_address'];
$firstName = $authData['first_name'];
$lastName = $authData['last_name'];
$profileImage = $authData['profile_image_url'];
$destinationURL = $body['options']['destination_url'];
//Use information above to create user in your system, create a session, etc
```

*Redirect the user back to your website*

```php
<?php
header( "Location: $destinationURL" );
```
