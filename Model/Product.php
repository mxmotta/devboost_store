<?php

class Product extends Model
{
    protected $id;
    protected $name;
    protected $description;
    protected $className = self::class;

    function __construct($data = [])
    {
        $this->set($data);
    }

}
