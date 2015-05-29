<?php

namespace Ooxif\LaravelQueryParam;

use PDOStatement;

interface ParamInterface
{
    /**
     * @param PDOStatement $stmt
     * @param int|string $parameter
     * @return bool
     */
    public function bind(PDOStatement $stmt, $parameter);

    /**
     * @return mixed
     */
    public function value();
}