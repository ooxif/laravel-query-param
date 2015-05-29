<?php

namespace Ooxif\LaravelQueryParam;

use Illuminate\Database\Eloquent\Builder;
use Ooxif\LaravelQueryParam\Param as P;

trait ModelTrait
{
    protected function castAttribute($key, $value)
    {
        return isset($this->casts[$key]) && $this->casts[$key] === 'binary'
            ? $this->castLob($value)
            : parent::castAttribute($key, $value);
    }
    
    protected function castLob($value)
    {
        if ($value === null) {
            return null;
        }
        
        return $value instanceof P\ParamLob ? $value : new P\ParamLob($value);
    }
    
    public function setAttribute($key, $value)
    {
        if (isset($this->casts[$key])
            && $this->casts[$key] === 'binary'
            && $value instanceof P\ParamLob) {
            $value = $value->value();
        }
        
        return parent::setAttribute($key, $value);
    }
    
    public function getDirty()
    {
        $dirty = parent::getDirty();
        
        if (empty($dirty)) {
            return $dirty;
        }
        
        foreach ($this->casts as $key => $value) {
            if ($value === 'binary' && isset($dirty[$key])) {
                $dirty[$key] = $this->castLob($dirty[$key]);
            }
        }
        
        return $dirty;
    }
    
    protected function getKeyForSaveQuery()
    {
        $ret = parent::getKeyForSaveQuery();
        
        $keyName = $this->getKeyName();
        
        return isset($this->casts[$keyName]) && $this->casts[$keyName] === 'binary'
            ? $this->castLob($ret)
            : $ret;
    }
    
    protected function performInsert(Builder $query, array $options = array())
    {
        $uncasts = array();

        foreach ($this->casts as $key => $value) {
            if ($value === 'binary' && isset($this->attributes[$key])) {
                $this->attributes[$key] = $this->castLob($this->attributes[$key]);
                $uncasts[] = $key;
            }
        }

        $ret = parent::performInsert($query, $options);
        
        foreach ($uncasts as $key) {
            if (isset($this->attributes[$key]) && $this->attributes[$key] instanceof P\ParamLob) {
                $this->attributes[$key] = $this->attributes[$key]->value();
            }
        }
        
        return $ret;
    }
}