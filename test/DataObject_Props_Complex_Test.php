<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib;

class DataObject_Props_Complex_Test
    extends \PHPUnit_Framework_TestCase
{

    public function test_props()
    {
        /** === Test Data === */
        /* customer */
        $CUST_ID = 21;
        $CUST_NAME = 'customer name';
        $CUST_EMAIL = 'customer email';
        $CUST = new Sample\Props\Simple\Customer();
        $CUST->id = $CUST_ID;
        $CUST->name = $CUST_NAME;
        $CUST->email = $CUST_EMAIL;
        /* account*/
        $ACC_ID = 32;
        $ACC_NUM = 'account number';
        $ACC_BALANCE = 64.32;
        $ACC = new Sample\Props\Simple\Account();
        $ACC->id = $ACC_ID;
        $ACC->number = $ACC_NUM;
        $ACC->balance = $ACC_BALANCE;
        /** === Test itself === */
        $obj = new Sample\Props\Complex;
        $obj->account = $ACC;
        $obj->customer = $CUST;
        $this->assertInstanceOf(Sample\Props\Simple\Account::class, $obj->account);
        $this->assertInstanceOf(Sample\Props\Simple\Customer::class, $obj->customer);
        $this->assertEquals($ACC_ID, $obj->account->id);
        $this->assertEquals($CUST_EMAIL, $obj->customer->email);
    }

    public function test_other()
    {
    $obj1 = new EmptyObject();
    $obj2 = new EmptyObject();
    $obj1->name = 'first';
    $obj2->code = 'OBJ2';
    $obj1->sub = $obj2;
    echo $obj1->name; // first
    echo $obj1->sub->code; // OBJ32
    }
}

class EmptyObject {}