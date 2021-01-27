# Bread Butter PHP

The official BreadButter PHP library.

## Bread Butter API
---

- Prior to coding, some configuration is required at https://app.breadbutter.io/app/#app-settings.

- For the full Developer Documentation please visit: https://app.breadbutter.io/api/

---
### Instantiating a new client

- `APP_ID` can be found in [App Settings](https://app.breadbutter.io/app/#/app-settings)
- `APP_SECRET` is configured at [App Secrets](https://app.breadbutter.io/app/#/app-secrets)
- `BreadButter_API_ENDPOINT` should be set to `https://api.breadbutter.io`

Create a new instance of `BreadButterClient`.  
```php
<?php
use BreadButter\API\BreadButterClient as BreadButterClient;
$breadButterClient = new BreadButterClient(array(
    'app_id' => '{APP_ID}',
    'app_secret' => '{APP_SECRET}',
    'api_path' => '{BreadButter_API_ENDPOINT}',
));
```
---
### Login QuickStart
The StartAuthentication function in the JS library begins the Bread Butter managed login process.
>Further documentation on starting the login process via our JavaScript client can be found at our GitHub page [here](https://github.com/BreadButter/BreadButter-js). 

The following example demonstrates what to do once the `callback Url` has been used by our system to redirect the user back to your page:
```php
<?php
$token = $_REQUEST['token'];
$loginData = $breadButterClient->getAuthentication($token);
if ($loginData['auth_success']) {
     //authentication and validation succeeded. proceed with post-auth workflows (ie, create a user session token for your system).
}
```
