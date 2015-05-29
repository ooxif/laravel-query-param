<?php

namespace Ooxif\LaravelQueryParam\Param;

class ParamStr extends AbstractParam
{
    /**
     * @param int|null $value
     */
    public function __construct($value)
    {
        parent::__construct($value === null ? $value : (string)$value);
    }

    public function getPdoDataType()
    {
        return \PDO::PARAM_STR;
    }
}