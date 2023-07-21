<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class State extends Model
{
    use ClassName;
    
    protected $table = "states";

    public $id;
    public $name;
    public $code;

    function __construct($data = [])
    {
        $this->set($data);
    }

}
