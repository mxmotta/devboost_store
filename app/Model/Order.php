<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Order extends Model
{
    use ClassName;
    
    protected int $id;
    protected Customer $customer;
    protected array $products;
    protected bool $status;

    function __construct($data = [])
    {
        $this->set($data);
    }
}
