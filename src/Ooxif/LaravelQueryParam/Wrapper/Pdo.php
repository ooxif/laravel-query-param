<?php

namespace Ooxif\LaravelQueryParam\Wrapper;

use PDO as BasePDO;

class Pdo extends AbstractWrapper
{
    public function __construct(BasePDO $pdo)
    {
        parent::__construct($pdo);
    }
    
    public function prepare()
    {
        $arguments = func_get_args();

        return new PdoStatement(call_user_func_array(array($this->o, 'prepare'), $arguments));
    }
}