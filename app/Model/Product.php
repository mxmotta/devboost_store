<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Product extends Model
{
    use ClassName;
     
    protected $id;
    protected $name;
    protected $description;

    function __construct($data = [])
    {
        $this->set($data);
    }

}
