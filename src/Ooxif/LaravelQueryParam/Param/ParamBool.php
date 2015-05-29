<?php

namespace Ooxif\LaravelQueryParam\Param;

class ParamBool extends AbstractParam
{
    /**
     * @param bool|null $value
     */
    public function __construct($value)
    {
        parent::__construct($value === null ? $value : (bool)$value);
    }
    
    public function getPdoDataType()
    {
        return \PDO::PARAM_BOOL;
    }
}