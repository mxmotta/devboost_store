<?php

class Photo extends Model
{
    protected $id;
    protected $name;
    protected $path;
    protected $className = self::class;

    function __construct($data = [])
    {
        $this->set($data);
    }

}
