<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Product extends Model
{
    use ClassName;

    public $id;
    public $name;
    public $description;
    public $price;

    protected $table = "products";

    function __construct($data = [])
    {

        if(isset($data['price']) && !floatval($data['price'])){
            $data['price'] = str_replace('R$ ', '', $data['price']);
            $data['price'] = str_replace('.', '', $data['price']);
            $data['price'] = str_replace(',', '.', $data['price']);
        }

        $this->set($data);
    }
}
