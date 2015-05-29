<?php

namespace Ooxif\LaravelQueryParam\Wrapper;

abstract class AbstractWrapper
{
    protected $o;

    public function __construct($o)
    {
        $this->o = $o;
    }
    
    public function __get($name)
    {
        return $this->o->{$name};
    }

    public function __isset($name)
    {
        return isset($this->o->{$name});
    }

    public function __set($name, $value)
    {
        $this->o->{$name} = $value;
    }

    public function __unset($name)
    {
        unset($this->o->{$name});
    }
    
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->o, $method), $arguments);
    }
}