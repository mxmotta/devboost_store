<?php

class Customer extends Model
{
    protected $id;
    protected $name;
    protected $birthdate;
    protected $cpf;
    protected $status;
    protected $className = self::class;

    function __construct($data = [])
    {
        $this->set($data);
    }
    
}
