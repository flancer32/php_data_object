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


## Type checking


[Home](../README.md)