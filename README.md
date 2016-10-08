# php_data_object

[![Build Status](https://travis-ci.org/flancer32/php_data_object.svg)](https://travis-ci.org/flancer32/php_data_object)
[![codecov.io](https://codecov.io/github/flancer32/php_data_object/coverage.svg?branch=master)](https://codecov.io/github/flancer32/php_data_object?branch=master)

_"Smart data structures and dumb code works a lot better than the other way around."_ (c) Eric S. Raymond

_"Bad programmers worry about the code. Good programmers worry about data structures and their relationships."_ (c) Linus Torvalds



## Overview
This is yet another PHP implementation of the data container (like [DTO](https://en.wikipedia.org/wiki/Data_transfer_object) / [SDO](http://php.net/manual/en/book.sdo.php)). Some kind of the wrapper around associative array. The main goal of this implementation is to be an accessor for the raw data.



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

[More...](./docs/010_PhpObjects.md)


### Paths
We can set/get value of the inner property in PHP style:

    $obj->sub->code = $code;
    $code = $obj->sub->code;
    
but we will have "_Undefined property_" error if `$obj->sub` property does not exist. 


### Type checking
We need to use accessors to control properties types.

This is `Customer` class with `string` property:

    /**
     * @property string $name Customer name.
     */
    class Customer
    {
        public function getName() : string
        {
            return $this->name;
        }
    
        public function setName(string $data)
        {
            $this->name = $data;
        }
    }

This is `Order` class with `Customer` property: 

    /**
     * @property Customer $customer
     */
    class Order
    {
        public function getCustomer() : Customer
        {
            return $this->customer;
        }
    
        public function setCustomer(Customer $data)
        {
            $this->customer = $data;
        }
    }
    
This is code without errors (all types are expected): 
    
    $customer = new Customer();
    $customer->setName('John Dow');
    $order = new Order();
    $order->setCustomer($customer);
    $this->assertTrue(is_string($order->getCustomer()->getName()));
    
This code will throw a `\TypeError` exception:
    
    $customer = new class {};
    $customer->name = 'John Dow';
    $order = new Order();
    $order->setCustomer($customer);
    

[More...](./docs/020_TypeChecking.md)


## Data Objects


### Structure


### Paths
With paths we will have property value if chain of properties exists or `null` otherwise:

    $code = $obj->get('sub/code');
    $code = $obj->get('/sub/code');    // equals to 'sub/code'
    $code = $obj->get('/subs/0/code'); // 'subs' is array
    $code = $obj->get('/sub/code/does/not/exist'); // 'null' is returned, no error is occured

Also we can set data property by path:

    $obj->set('order/customer/name', 'John Dow');
    

### Type hinting
    
    

## Installation
Add to `composer.json`:

    "require": {
        "flancer32/php_data_object": "0.1.0"
    }



## Development

    $ composer install
    $ ./vendor/bin/phpunit -c ./test/unit/phpunit.dist.xml
