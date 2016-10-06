<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Test\Sample\PhpObject;

/**
 * Object with structure (properties are defined directly).
 */
class Structured
{
    /**
     * Object code.
     *
     * @var  string
     */
    public $code;
    /**
     * Object name.
     *
     * @var  string
     */
    public $name;
    /**
     * Inner object of the same type.
     *
     * @var  Structured
     */
    public $sub;
}