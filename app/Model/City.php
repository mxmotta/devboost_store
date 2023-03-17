<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class City extends Model
{
    use ClassName;
    
    protected $id;
    protected $name;

    function __construct($data = [])
    {
        $this->set($data);
    }

}