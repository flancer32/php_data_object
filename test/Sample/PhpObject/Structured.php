<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Lib\Sample\PhpObject;

/**
 * Object with structure (properties are defined directly).
 */
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