<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class User extends Model
{
    use ClassName;
    
    protected $table = "users";

    public $id;
    public $name;
    public $login;
    public $password;
    
    function __construct($data = [])
    {
        $this->set($data);
    }

}
