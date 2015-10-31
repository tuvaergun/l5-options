# Persistent Options Manager for Laravel 5
 
This package makes it easy to store persistent key/value options in your Laravel 5 application. All options are stored in your database and cached in a json file to minimize database queries.

## Install it
To install this package include it in your `composer.json` and run `composer update`:

    "require": {
       "tuvaergun/l5-options": "dev-master"
    }
     
Add the Service Provider to the `provider` array in your `config/app.php`

    'Tuva\Options\OptionsServiceProvider'
    
Add an alias for the facade to your `config/app.php`

    'Options'  => 'Tuva\Options\Facades\Options',

Publish the config and migration files:

    $ php artisan vendor:publish --provider="Tuva\Options\OptionsServiceProvider"
    
Change `config/options.php` according to your needs. If you change `db_table`, don't forget to change the table's name
in the migration file as well.
    
Create the `options` table. 

    $ php artisan migrate
    


## Use it

Set a value

    Options::set('key', 'value');
    
Get a value

    $value = Options::get('key');
    
Forget a value

    Options::forget('key');

Forget all values

    Options::flush();
    
