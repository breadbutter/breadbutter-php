# Bread Butter PHP

The official BreadButter PHP library.

## Bread Butter API
---

- Prior to coding, some configuration is required at https://app.breadbutter.io/app/#/app-settings.

- For the full Developer Documentation please visit: https://breadbutter.io/api/

---
### Instantiating a new client

- `APP_ID` and `APP_SECRET` can be found in [App Settings](https://app.breadbutter.io/app/#/app-settings)
- `BREADBUTTER_API_ENDPOINT` should be set to `https://api.breadbutter.io`

Create a new instance of `BreadButterClient`.  
```php
<?php
use BreadButter\API\BreadButterClient as BreadButterClient;
$breadButterClient = new BreadButterClient(array(
    'app_id' => '{APP_ID}',
    'app_secret' => '{APP_SECRET}',
    'api_path' => '{BREADBUTTER_API_ENDPOINT}',
));
```
---
### Login QuickStart
The StartAuthentication function in the JS library begins the Bread Butter managed login process.
>Further documentation on starting the login process via our JavaScript client can be found at our GitHub page [here](https://github.com/BreadButter/BreadButter-js). 

The following example demonstrates what to do once the `callback Url` has been used by our system to redirect the user back to your page:
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
```
