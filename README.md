# php_data_object

[![codecov.io](https://codecov.io/github/flancer32/php_data_object/coverage.svg?branch=master)](https://codecov.io/github/flancer32/php_data_object?branch=master)

_"Smart data structures and dumb code works a lot better than the other way around."_ (c) Eric S. Raymond

_"Bad programmers worry about the code. Good programmers worry about data structures and their relationships."_ (c) Linus Torvalds



## Overview

This is yet another PHP implementation of the data container (like [DTO](https://en.wikipedia.org/wiki/Data_transfer_object) or [SDO](http://php.net/manual/en/book.sdo.php)). Some kind of the wrapper around associative array. The main goal of this implementation is to be an accessor for the raw data.



## Native PHP objects


### Structure
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

You can set/get value of the inner property in PHP style:

    $obj->sub->code = $code;
    $code = $obj->sub->code;
    
but you will have "_Undefined property_" error if `$obj->sub` property does not exist. 


### Type hinting



## Data Objects


### Structure


### Paths

With paths you will have property value if chain of properties exists or `null` otherwise:

    $code = $obj->get('sub/code');
    $code = $obj->get('/sub/code');    // equals to 'sub/code'
    $code = $obj->get('/subs/0/code'); // 'subs' is array
    $code = $obj->get('/sub/code/does/not/exist'); // 'null' is returned, no error is occured

Also you can set data property by path:

    $obj->set('order/customer/name', 'John Dow');
    

### Type hinting
    
    

## Installation

Add to your `composer.json`:

    "require": {
        "flancer32/php_data_object": "0.1.0"
    }



## Development

    $ composer install
    $ ./vendor/bin/phpunit -c ./test/unit/phpunit.dist.xml
