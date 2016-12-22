# Type checking

[Home](../README.md)

## Property type hints
We cannot define property type [directly](https://wiki.php.net/rfc/property_type_hints):

    class Customer {
        public string $name;
    }

only annotations can be used for type hinting:

    class Customer {
        /**
         * Customer name.
         * @var string 
         */
        public $name;
    }

or:

    /**
     * @property string $name Customer name.
     */
    class Customer {}


## Accessors type declaration
But we can declare type for accessors (scalar types & return type are PHP7 features):

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

This is a more classic sample, where general type is used for declaration: 

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


## Properties type checking
We cannot check types for the properties, cause we cannot declare types for properties. Type hinting is for information only:
 
    /**
     * @property string $name Customer name.
     */
    class Customer {}
    
    $customer->name = 'John Dow';
    $this->assertTrue(is_string($customer->name));
    $customer->name = 21;
    $this->assertTrue(is_int($customer->name));


## Accessors type checking
But we can control properties types with accessors.


## Scalar types
Scalar types (`string`, `int`, `float`, `bool`) can be checked in two modes: coercive & strict.


### Coercive mode for scalar types
Coercive mode is default.

    /**
     * @property int $age Age of the customer.
     */
    class Customer
    {  
        public function setAge(int $data)
        {
            $this->age = $data;
        }
    }
    
String value will be cast to the integer:

    $customer->setAge('021.30');
    $this->assertTrue(is_int($customer->age));
    $this->assertEquals(21, $customer->age);


### Strict mode for scalar types
Add `declare` directive to the begin of the class file to use strict mode:

    declare(strict_types = 1);

`\TypeError` exception will be thrown if types are not equal:

    $customer->setAge('21');


## General types

We will have the same exception if we will use general (not scalar) types in accessors:

    /**
     * @property Customer $customer
     */
    class Order
    {
        public function setCustomer(Customer $data)
        {
            $this->customer = $data;
        }
    }

`\TypeError` will be thrown here:

    $customer = new class {};
    $customer->name = 'John Dow';
    $order = new Order();
    $order->setCustomer($customer);

[Home](../README.md)