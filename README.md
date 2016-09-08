# php_data_object

[![codecov.io](https://codecov.io/github/flancer32/php_data_object/coverage.svg?branch=master)](https://codecov.io/github/flancer32/php_data_object?branch=master)

_"Smart data structures and dumb code works a lot better than the other way around."_ (c) Eric S. Raymond

_"Bad programmers worry about the code. Good programmers worry about data structures and their relationships."_ (c) Linus Torvalds

## Overview

This is yet another PHP implementation of the data container (like [DTO](https://en.wikipedia.org/wiki/Data_transfer_object) or [SDO](http://php.net/manual/en/book.sdo.php)). Some kind of the wrapper around associative array. The main goal of this implementation is to be an accessor for the raw data.

## Usage


### Properties annotation

By default any property can be set to any PHP object.

    class PhpObject {}
    
    $obj1 = new PhpObject();
    $obj2 = new PhpObject();
    $obj1->name = 'first';
    $obj2->code = 'OBJ2';
    $obj1->sub = $obj2;
    $this->assertEquals('first', $obj1->name);
    $this->assertEquals('OBJ2', $obj1->sub->code);

But you know nothing about data structure in this case. Annotated properties are used in the following sample and you know about data structure a little more:

    /**
     * @property string $name
     * @property string $code
     * @property Annotated $sub
     */
    class AnnotatedPhpObject {}

    $obj1 = new AnnotatedPhpObject();
    $obj2 = new AnnotatedPhpObject();
    $obj2->code = 'OBJ2';
    $obj1->sub = $obj2;
    $this->assertEquals('OBJ2', $obj1->sub->code);

You don't need any containers in this case, PHP object itself is the container.

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
