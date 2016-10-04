<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Sample\TypeChecking;

/**
 * @property string $name Customer name.
 * @property string $email Customer email.
 * @property int $age Age of the customer.
 */
class Customer
{
    /** @var  string */
    public $name;

    public function getAge() : int
    {
        return $this->name;
    }

    public function getEmail() : string
    {
        return $this->name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setAge(int $data)
    {
        $this->name = $data;
    }

    public function setEmail(string $data)
    {
        $this->name = $data;
    }

    public function setName(string $data)
    {
        $this->name = $data;
    }
}