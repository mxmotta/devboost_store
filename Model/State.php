<?php

class State extends Model
{
    protected $id;
    protected $name;
    protected $code;
    protected $className = self::class;

    function __construct($data = [])
    {
        $this->set($data);
    }

}
