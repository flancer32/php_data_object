<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Sample\TypeChecking;

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