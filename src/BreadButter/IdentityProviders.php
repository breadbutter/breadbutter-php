<?php

namespace BreadButter;

class IdentityProviders {
    const GOOGLE = 'google';
    const MICROSOFT = 'microsoft';
    const FACEBOOK = 'facebook';
    const LINKEDIN = 'linkedin';
    const SLACK = 'slack';
    const TWITTER = 'twitter';
    const GITHUB = 'github';
    const QUICKBOOKS = 'quickbooks';
	const ONELOGIN = 'onelogin';
    const OKTA = 'okta';
    const APPLE = 'apple';
    const BASECAMP = 'basecamp';
    const DROPBOX = 'dropbox';
    const FITBIT = 'fitbit';
    const PLANNINGCENTER = 'planningcenter';
    const TWITCH = 'twitch';

    private static $allowProviders = array('microsoft','google','facebook','linkedin','slack','twitter','github','quickbooks','onelogin','okta','apple','basecamp','dropbox','fitbit','planningcenter','twitch');

    public static function isProviderValid($name) {
        $pass = false;
        if (in_array($name, IdentityProviders::$allowProviders)) {
            $pass = true;
        }
        return $pass;
    }
}