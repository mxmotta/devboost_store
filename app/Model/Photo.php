<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Photo extends Model
{
    use ClassName;
    
    public $id;
    public $name;
    public $path;
    public $product_id;

    protected $table = "photos";

    function __construct($data = [])
    {
        $this->set($data);
    }

}
