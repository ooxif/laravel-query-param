<?php

use Ooxif\LaravelQueryParam\Param as P;

/**
 * @param bool $value
 * @return P\ParamBool
 */
function param_bool($value)
{
    return new P\ParamBool($value);
}

/**
 * @return P\ParamNull
 */
function param_null()
{
    return new P\ParamNull();
}

/**
 * @param int $value
 * @return P\ParamInt
 */
function param_int($value)
{
    return new P\ParamInt($value);
}

/**
 * @param string $value
 * @return P\ParamStr
 */
function param_str($value)
{
    return new P\ParamStr($value);
}

/**
 * @param string $value
 * @return P\ParamLob
 */
function param_lob($value)
{
    return new P\ParamLob($value);
}
