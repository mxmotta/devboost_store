<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Photo extends Model
{
    use ClassName;
    
    protected $id;
    protected $name;
    protected $path;

    function __construct($data = [])
    {
        $this->set($data);
    }

}
