<?php

namespace Ooxif\LaravelQueryParam;

use PDO;
use PDOStatement;

class Statement extends PDOStatement
{
    protected function __construct()
    {
        // do nothing.
    }
    
    public function execute($params = null)
    {
        if (!is_array($params) || empty($params)) {
            return parent::execute();
        }

        foreach ($params as $parameter => $value) {
            if (is_numeric($parameter)) {
                ++$parameter;
            }
            if ($value instanceof ParamInterface) {
                $value->bind($this, $parameter);
            } else {
                $this->bindValue($parameter, $value, $value === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            }
        }

        return $this->execute();
    }
}