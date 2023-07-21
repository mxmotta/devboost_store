<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Address extends Model
{
    use ClassName;
    
    public $id;
    public $street;
    public $number;
    public $district;
    public $city_id;
    public $customer_id;
    
    protected $table = "addresses";

    function __construct($data = [])
    {
        $this->set($data);
    }
}
