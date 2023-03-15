<?php

class Model
{

    protected $className = self::class;

    public function get()
    {
        $attributes = get_class_vars($this->className);
        foreach ($attributes as $key => $attribute) {
            $attributes[$key] = $this->{$key};
        }

        if($attributes['id'] == null) {
            unset($attributes['id']);
        }

        unset($attributes['className']);
        return $attributes;
    }

    public function set(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
        return $this->get();
    }
}
