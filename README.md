![Alt text](/public/screenshots/screenshot.png)

# Mollie App
This is a comprehenisve dashboard for your Mollie statistics and CRUD management.

## Why?

I've noticed development on the Mollie dashboard has been quiet for a while. And I've always
lacked a few things in there, simple things as an subscription overview, or being able to edit the subscriptions/customers.
With the dashboard Mollie provides, the only thing you can 'really' do is view transactions and customers.

## How?

I've used Laravel, Fillament & Sushi to make this work.
I use Sushi to make the API calls work for Eloquent so Filament can work with that.

## Installation

First setup a database, and remember the credentials.

```
git clone https://github.com/Cannonb4ll/mollie-app.git
composer install
php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate
```

Now edit your `.env` file and set up the database credentials, including the App Name you want.
You will also want to fill in these 2 tokens:

```
MOLLIE_TOKEN=
MOLLIE_OAUTH_TOKEN=
```

The `MOLLIE_TOKEN` is a `live_` or `test_` token you can grab from their portal under "Developers".

Now run the following:

```
php artisan make:filament-user
```

And login with the credentials you've provided.

## Testing

```bash
./vendor/bin/pest
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Sponsor

We appreciate sponsors, we still maintain this repository, server, emails and domain. [You can do that here](https://github.com/sponsors/Cannonb4ll).
Each sponsor gets listed on in this readme.

## Credits

- [Cannonb4ll](https://github.com/cannonb4ll)
- [Filament Admin](https://filamentadmin.com/)
- 
## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
