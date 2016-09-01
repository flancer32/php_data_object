# php_data_object

[![codecov.io](https://codecov.io/github/flancer32/php_data_object/coverage.svg?branch=master)](https://codecov.io/github/flancer32/php_data_object?branch=master)

## Overview

This is yet another PHP implementation of the [DTO](https://en.wikipedia.org/wiki/Data_transfer_object). Some kind of the wrapper around associative array. The main goal of this implementation is to be an accessor for raw data.

## Usage


### Properties annotation

This is default behaviour for PHP objects:

    /**
     * Object with simple properties.
     *
     * @property int $id Object's ID.
     * @property string $name Object's name.
     */
    class DtoSimple extends \Flancer32\Lib\DataObject
    {
    }

    $obj = new DtoSimple();
    $obj->id = 32;
    $obj->name = 'simple object';
    echo $obj->id . ': ' . $obj->name; // 32: simple object

### Accessors annotation
    
### Access array data by path

    $DATA = [
        'order' => [
            'id' => 21,
            'items' => [
                ['id' => 32],
                ['id' => 56]
            ]
        ]
    ];
    $orderId = $obj->_get('order/id'); // 21
    $firstItemId = $obj->_get('order/items/0/id'); // 32
    $secondItemId = $obj->_get('order/items/1/id'); // 56



Get JSON decoded data by path:

    $json = '{"order":{"id":21,"items":[{"id":32},{"id":56}]}}';
    $data = json_decode($json, true);
    $obj = new DataObject($data);
    /* get data by path */
    $orderId = $obj->_get('order/id'); // 21
    $itemId = $obj->_get('order/items/1/id'); // 56
    /* get first level data by key */
    $order = $obj->getOrder();
    /* get arrays by path */
    foreach ($obj->_get('/order/items') as $item) {
        $id = $item['id']; // 32, 56
        /* convert array to data object */
        $itemObj = new DataObject($item);
        $id = $itemObj->getId(); // 32, 56
    }

## Installation

Add to your `composer.json`:

    "require": {
        "flancer32/php_data_object": "0.1.0"
    }


## Development

    $ composer install
    $ ./vendor/bin/phpunit -c ./test/phpunit.dist.xml
