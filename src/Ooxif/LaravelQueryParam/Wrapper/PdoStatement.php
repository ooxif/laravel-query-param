<?php

namespace Ooxif\LaravelQueryParam\Wrapper;

use PDO;
use PDOStatement as BasePDOStatement;
use Ooxif\LaravelQueryParam\ParamInterface;

class PdoStatement extends AbstractWrapper
{
    public function __construct(BasePDOStatement $stmt)
    {
        parent::__construct($stmt);
    }

    public function execute($params = null)
    {
        /**
         * @var BasePDOStatement $stmt
         */
        $stmt = $this->o;
        
        if (!is_array($params) || empty($params)) {
            return $stmt->execute();
        }
        
        foreach ($params as $parameter => $value) {
            if (is_numeric($parameter)) {
                ++$parameter;
            }
            if ($value instanceof ParamInterface) {
                $value->bind($stmt, $parameter);
            } else {
                $stmt->bindValue($parameter, $value, $value === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            }
        }
        
        return $stmt->execute();
    }
}