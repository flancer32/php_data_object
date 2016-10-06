<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Test\Sample\TypeChecking;

/**
 * @property string $name Customer name.
 * @property string $email Customer email.
 * @property int $age Age of the customer.
 */
class Customer
{
    public function getAge() : int
    {
        return $this->age;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setAge(int $data)
    {
        $this->age = $data;
    }

    public function setEmail(string $data)
    {
        $this->email = $data;
    }

    public function setName(string $data)
    {
        $this->name = $data;
    }
}