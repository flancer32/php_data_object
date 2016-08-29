# php_data_object
Data object implementation for PHP

[![codecov.io](https://codecov.io/github/flancer32/php_data_object/coverage.svg?branch=master)](https://codecov.io/github/flancer32/php_data_object?branch=master)


## Installation

Add to your `composer.json`:

    "require": {
        "flancer32/php_data_object": "0.1.0"
    }


## Development

    $ composer install
    $ ./vendor/bin/phpunit -c ./test/phpunit.dist.xml


## Usage

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