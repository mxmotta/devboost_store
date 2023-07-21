<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Contact extends Model
{
    use ClassName;
    
    public $id;
    public $type;
    public $value;
    public $customer_id;
    
    protected $table = "contacts";

    function __construct($data = [])
    {
        $this->set($data);
    }
}
