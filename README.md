# Pimcore 4 Google Login
Pimcore 4 plugin that allows to use Google credentials to log into Pimcore's admin panel
# Features
  - Log into Pimcore's admin panel using your Google account (and two-step verification!)
# Installation
```
composer require divante-ltd/pimcore-google-login
```
After installation, go to Extensions in your Pimcore admin panel, click on configure. Fill up all the fields using data from Google Developers Console (https://console.developers.google.com/apis/credentials/oauthclient).

For redirect_uri use "http://yourdomain/plugin/GoogleLogin/index/index"

Make sure to set the same authorised redirect URI in Developers Console. Also authorise your domain as JS source.
