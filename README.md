[![CodeFactor](https://www.codefactor.io/repository/github/sergeevpasha/laravel-pecom/badge)](https://www.codefactor.io/repository/github/sergeevpasha/laravel-pecom)
[![Generic badge](https://img.shields.io/badge/PHP-^7.4.*-blue.svg)](https://www.php.net)
[![Generic badge](https://img.shields.io/badge/Laravel-^6.0-red.svg)](https://laravel.com)

# Laravel PECOM API Wrapper
Allows you to:
* Find a City by query string
* Find all Terminals in the City by City ID
* Calculate a delivery price
  
## Pre-requirements
You need to get Pecom API key and login.
Key can be obtained in your cabinet at https://kabinet.pecom.ru/profile

## Installation
<pre>composer require sergeevpasha/laravel-pecom</pre>

## Configuration
This package has a few configuration values:
<pre>
'key'        => env('PECOM_KEY', null),
'user'       => env('PECOM_USER', null),
'prefix'     => 'pecom',
'middleware' => ['web']
</pre>
If you only need to use PecomClient, you may completely skip this configuration. Otherwise you can use default options and just specify PECOM_KEY and PECOM_USER at .env file.
To make full use of predefined routes, you will need to publish config:
<pre>
php artisan vendor:publish --provider="SergeevPasha\Pecom\Providers\PecomServiceProvider" --tag="config"
</pre>
Now you can change routes prefix and middleware to whatever you need

### Use Case #1
After installing you may just import the client
<pre>use SergeevPasha\Pecom\Libraries\PecomClient;</pre>
Now you need to initialize it:
<pre>
$client = new PecomClient('user', 'key');
</pre>
Now we can use these methods:
<pre>
$client->findCity(string $query)
$client->getCityTerminals(int $cityId)
/* This one requires a Delivery Object, see next to see how to build it */
$client->getPrice(Delivery $delivery)
</pre>
## Delivery Object
To build a Delivery object you will need to pass an array to fromArray() method just like that:<br>
<pre>
Delivery::fromArray([
    'arrival_city_id'                 => '123', // Arrival City ID, can be found using findCity() method
    'derival_city_id'                 => '123456', // Derival City ID, can be found using findCity() method
    'arrival_open_car'                => '1', // Boolean. Removable Curtains for arrival car
    'derival_open_car'                => '1, // Boolean. Removable Curtains for derival car
    'arrival_distance_type'           => '2', // Distance Type, Moscow ONLY
                                                  0 - NONE,
                                                  1 - Require transportation by Sadovoe Koltso
                                                  2 - Require transporation by Moscow district railway
                                                  3 - Require transporation by Third Transport Ring
    'derival_distance_type'           => '0', // Same as arrival
    'one_day_delivery'                => '1', // Boolean, day by day delivery
    'is_shop'                         => '0', // Boolean, sender is a shop
    'pay_date'                        => '2020-10-10', // Payment date
    'arrival_address'                 => '1', // Boolean, if delivery is required (means you are not using terminal)
    'derival_address'                 => '1', // Boolean, if pickup is required
    /* Next fileds are not required */
    'require_insurance'               => '1', // Boolean, if you need to insure a cargo
    'insurance_price'                 => '100.50', // Total cargo cost to insure
    'arrival_service'                 => [
        'enabled'                     => '1', // Enable additional service on arrival        
        'arrival_service.floor'       => '10', // Floor to deliver
        'arrival_service.distance'    => '10', // Distance in Meters to deliver
        'arrival_service.elevator'    => '1', // Boolean, if there is an elevator
    ],
    'derival_service'                 => [    
        'enabled'     => '0', // Enable additional service on derival
        'floor'       => '10', // Pickup floor
        'distance'    => '10', // Pickup Distance in Meters
        'elevator'    => '1', // Boolean, if there is an elevator
    ]
    /* --- */
    'cargo'                           => [ // It's an array of arrays with cargo data
      [
          'width'                       => '1', // Width in Meters
          'height'                      => '1', // Height in Meters
          'weight'                      => '1', // Weight in KG
          'volume'                      => '1', // Weight in M<sup>3</sup>
          'max_size'                    => '1', // Max dimension size in Meters
          /* Next fileds are not required */
          'protective_package'          => '1', // Boolean, if you need a protective package
          'total_sealing_positions'     => '4', // Total sealing positions
          'oversized'                   => '1', // Boolean, if cargo is oversized
          /* --- */
      ]
    ]
])
</pre>

### Use Case #2
There are some predefined routes, that will be merged with your routes aswell. You may check it by using
<pre>php artisan routes:list</pre>
It actually exposing the same methods to the routes, so it should be pretty clear on how to use it.
For more information on how to use it, please check out `src/` folder
