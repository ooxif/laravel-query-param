<?php

namespace Ooxif\LaravelQueryParam\Param;

use PDO;
use PDOStatement;
use Ooxif\LaravelQueryParam\ParamInterface;

abstract class AbstractParam implements ParamInterface
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    abstract public function getPdoDataType();

    /**
     * @param PDOStatement $stmt
     * @param int|string $parameter
     * @return bool
     */
    public function bind(PDOStatement $stmt, $parameter)
    {
        $value = $this->value();

        return $stmt->bindValue($parameter, $value, $value === null ? PDO::PARAM_NULL : $this->getPdoDataType());
    }
    
    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}