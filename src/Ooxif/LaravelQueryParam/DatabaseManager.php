<?php

namespace Ooxif\LaravelQueryParam;

use PDO;
use Illuminate\Database\DatabaseManager as BaseManager;
use Illuminate\Database\Connection;
use Ooxif\LaravelQueryParam\Wrapper\Pdo as PdoWrapper;

class DatabaseManager extends BaseManager
{
    protected $statementClass = 'Ooxif\LaravelQueryParam\Statement';
    
    /**
     * @param string $name
     * @return Connection
     */
    protected function makeConnection($name)
    {
        $connection = parent::makeConnection($name);
        
        if (!($connection instanceof Connection)) {
            return $connection;
        }
        
        $pdo = $connection->getPdo();
        $wrapper = null;
        if ($pdo instanceof PDO && ($wrapper = $this->attrOrWrap($pdo))) {
            $connection->setPdo($wrapper);
        }

        $readPdo = $connection->getReadPdo();
        if ($readPdo instanceof PDO) {
            if ($readPdo !== $pdo) {
                $wrapper = $this->attrOrWrap($readPdo);
            }
            if ($wrapper) {
                $connection->setReadPdo($wrapper);
            }
        }
        
        return $connection;
    }
    
    protected function attrOrWrap(PDO $pdo)
    {
        $attr = $pdo->getAttribute(PDO::ATTR_STATEMENT_CLASS);

        if (is_array($attr) && isset($attr[0]) && strtolower($attr[0]) === 'pdostatement') {
            $pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS, array($this->statementClass, array()));
            return null;
        }

        return new PdoWrapper($pdo);
    }
}