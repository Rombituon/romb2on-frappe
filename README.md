# frappe client connector for laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/romb2on/romb2on-frappe.svg?style=flat-square)](https://packagist.org/packages/romb2on/romb2on-frappe)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/romb2on/romb2on-frappe/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/romb2on/romb2on-frappe/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/romb2on/romb2on-frappe/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/romb2on/romb2on-frappe/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/romb2on/romb2on-frappe.svg?style=flat-square)](https://packagist.org/packages/romb2on/romb2on-frappe)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/romb2on-frappe.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/romb2on-frappe)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require romb2on/romb2on-frappe
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="romb2on-frappe-config"
```

This is the contents of the published config file:

```php
return [
    'frappe_url' => env('FRAPPE_URL', null),
    'frappe_api_key' => env('FRAPPE_API_KEY', null),
    'frappe_api_secret' => env('FRAPPE_API_SECRET', null),
    'frappe_username' => env('FRAPPE_USERNAME', null),
    'frappe_password' => env('FRAPPE_PASSWORD', null),
];
```

Optionally, you can publish the views using


## Usage



```php
//getUser
$frappe = new Romb2on\Frappe\Frappe();
$res=$frappe->getUser('jurin@example.com');

//update user
$res=$frappe->doctype()->update('User','jurin@example.com',[
    'first_name'=>'Jurin'
]);

//create data
$res=$frappe->doctype()->create('Error Log',[
    'method'=>'test error',
    'error'=>'hello world'
]);

//delete record
$res=$frappe->doctype()->delete('Error Log','234460');

//get all data
$res=$frappe->doctype()->getAll('User',[
    'filters'=>'[["user_type","=","System User"]]'
]);

//get single doctype
$res=$frappe->doctype()->getDoc('DocType','About Us Settings');

//using mount
$res=$frappe->doctype()
    ->mount('DocType')
    ->orderBy("name, creation asc")
    ->fields('["name","creation"]')
    ->paginate(1,10)
    ->get();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jurin Liyun](https://github.com/mrjurin)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
