<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Contact extends Model
{
    use ClassName;
    
    protected $id;
    protected $type;
    protected $data;

    function __construct($data = [])
    {
        $this->set($data);
    }
}
