<?php

namespace Ooxif\LaravelQueryParam\Param;

class ParamInt extends AbstractParam
{
    /**
     * @param int|null $value
     */
    public function __construct($value)
    {
        parent::__construct($value === null ? $value : (int)$value);
    }

    public function getPdoDataType()
    {
        return \PDO::PARAM_INT;
    }
}