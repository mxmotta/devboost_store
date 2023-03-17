<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Address extends Model
{
    use ClassName;
    
    protected $id;
    protected $street;
    protected $number;
    protected $district;

    function __construct($data = [])
    {
        $this->set($data);
    }
}
