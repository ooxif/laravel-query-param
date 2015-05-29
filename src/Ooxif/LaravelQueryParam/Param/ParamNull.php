<?php

namespace Ooxif\LaravelQueryParam\Param;

class ParamNull extends AbstractParam
{
    public function __construct()
    {
        parent::__construct(null);
    }
    
    public function getPdoDataType()
    {
        return \PDO::PARAM_NULL;
    }
}