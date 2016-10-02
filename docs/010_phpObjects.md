# Native PHP objects

[Home](../README.md)

## Without structure

By default any property can be set to any PHP object.


### Anonymous

PHP 7 anonymous classes are used in the sample:

    $obj1 = new class {};
    $obj2 = new class {};
    $obj1->name = 'first';
    $obj2->code = 'OBJ2';
    $obj1->sub = $obj2;
    $this->assertEquals('first', $obj1->name);
    $this->assertEquals('OBJ2', $obj1->sub->code);


### Named class

Empty named class `test/Sample/PhpObject/Named.php`:

    class Named {}

Usage of the empty named class:

    $obj1 = new Sample\PhpObject\Named();
    $obj2 = new Sample\PhpObject\Named();
    $obj1->name = 'first';
    $obj2->code = 'OBJ2';
    $obj1->sub = $obj2;
    $this->assertEquals('first', $obj1->name);
    $this->assertEquals('OBJ2', $obj1->sub->code);
        
        
## With structure

You know nothing about data structure in the above cases. 


### Properties
Classic definition of the proprs (`test/Sample/PhpObject/Structured.php`):

    class Structured
    {
        /**
         * Object name.
         *
         * @var  string
         */
        public $name;
        /**
         * Object code.
         *
         * @var  string
         */
        public $code;
        /**
         * Inner object of the same type.
         *
         * @var  Structured
         */
        public $sub;
    }


### Annotations

Annotated properties are used in the following sample and you know about data structure a little more (`test/Sample/PhpObject/Annotated.php`):

    /**
     * Objects with structure (properties are annotated).
     *
     * @property string $name Object name.
     * @property string $code Object code.
     * @property Annotated $sub Inner object of the same type.
     *
     */
    class Annotated {}

Usage of the class with annotated props:

    $obj1 = new Sample\PhpObject\Annotated();
    $obj2 = new Sample\PhpObject\Annotated();
    $obj1->name = 'first';
    $obj2->code = 'OBJ2';
    $obj1->sub = $obj2;
    $this->assertEquals('first', $obj1->name);
    $this->assertEquals('OBJ2', $obj1->sub->code);


## Hybrid

We can use all 3 kinds of the properties (defined, annotated & undefined) in one object (`test/Sample/PhpObject/Hybrid.php`):


    /**
     * @property string $name Object name.
     */
    class Hybrid
    {
        /**
         * Object code.
         *
         * @var  string
         */
        public $code;
    }

Hybrid usage:
    
    $obj1 = new Sample\PhpObject\Hybrid();
    $obj2 = new Sample\PhpObject\Hybrid();
    $obj1->name = 'first';
    $obj2->code = 'OBJ2';
    $obj1->sub = $obj2;
    $this->assertEquals('first', $obj1->name);
    $this->assertEquals('OBJ2', $obj1->sub->code);
 
    
## Resume

You don't need any containers in this case, PHP object itself is the container.

[Home](../README.md)