<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Order extends Model
{
    use ClassName;
    
    protected $id;
    protected $status;

    function __construct($data = [])
    {
        $this->set($data);
    }
}
