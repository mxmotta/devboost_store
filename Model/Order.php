<?php

class Order extends Model
{
    protected $id;
    protected $status;
    protected $className = self::class;

    function __construct($data = [])
    {
        $this->set($data);
    }
}
