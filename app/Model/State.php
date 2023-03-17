<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class State extends Model
{
    use ClassName;

    protected $id;
    protected $name;
    protected $code;

    function __construct($data = [])
    {
        $this->set($data);
    }

}
