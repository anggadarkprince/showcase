## About Showcase.dev

Showcase.dev is **learning sandbox** about portfolio and CV maker, you can generate professional profile through simple web application.

## Installing Showcase.dev

#### Install Laravel
Make sure you have installed composer on your machine,

Run `composer install`

#### Install Dependencies
Make sure you have installed NodeJS and NPM,

Run `npm install`

#### Compile Assets
Run `gulp` or `gulp --production`

#### Setting Host File
Configure virtual host for:
* laravel.dev
* account.laravel.dev
* admin.laravel.dev

#### Environment File Config
1. Set session domain in .env to<br>

`SESSION_DOMAIN=.laravel.dev`

2. Setup Algolia search service with your api

3. Setup OAuth social api

4. Setup notification

5. Setting up your keys for NEXMO for SMS notification and Incoming WebHooks for Slack channel message

6. Setup Broadcasting Service: Setting up pusher keys and secret to use broadcast service.
## Contributing

Thank you for considering contributing to the Showcase App.

## Security Vulnerabilities

If you discover a security vulnerability within this app, please send an e-mail to Angga Ari at me@angga-ari.com. All security vulnerabilities will be promptly addressed.

## License

The Showcase App is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
