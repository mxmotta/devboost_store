<?php

class Contact extends Model
{
    protected $id;
    protected $type;
    protected $data;
    protected $className = self::class;

    function __construct($data = [])
    {
        $this->set($data);
    }
}
