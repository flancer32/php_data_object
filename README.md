# php_data_object

[![codecov.io](https://codecov.io/github/flancer32/php_data_object/coverage.svg?branch=master)](https://codecov.io/github/flancer32/php_data_object?branch=master)

_"Smart data structures and dumb code works a lot better than the other way around."_ (c) Eric S. Raymond

_"Bad programmers worry about the code. Good programmers worry about data structures and their relationships."_ (c) Linus Torvalds

## Overview

This is yet another PHP implementation of the data container (like [DTO](https://en.wikipedia.org/wiki/Data_transfer_object) or [SDO](http://php.net/manual/en/book.sdo.php)). Some kind of the wrapper around associative array. The main goal of this implementation is to be an accessor for the raw data.

## Native PHP objects

We can use any property of any PHP object:

    $obj1 = new class {};
    $obj2 = new class {};
    $obj1->name = 'first';
    $obj2->code = 'OBJ2';
    $obj1->sub = $obj2;
    $this->assertEquals('first', $obj1->name);
    $this->assertEquals('OBJ2', $obj1->sub->code);

[More...](./docs/010_phpObjects.md)


### Paths

You can get value of the inner property in PHP style:

    $code = $obj->sub->code;
    
but you will have "_Undefined property_" error if `$obj1->sub` property does not exist. WIth paths you will have property value if chain of properties exists or `null` otherwise:

    $code = $obj->get('sub/code');
    $code = $obj->get('/sub/code');    // equals to 'sub/code'
    $code = $obj->get('/subs/0/code'); // 'subs' is array
    $code = $obj->get('/sub/code/does/not/exist'); // 'null' is returned, no error is occured

Also you can set data property by path:

    $obj->set('order/customer/name', 'John Dow');
    

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
