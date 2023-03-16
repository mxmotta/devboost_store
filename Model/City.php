<?php

class City extends Model
{
    protected $id;
    protected $name;
    protected $className = self::class;

    function __construct($data = [])
    {
        $this->set($data);
    }

}
