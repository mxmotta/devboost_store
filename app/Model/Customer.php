<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Customer extends Model
{

    use ClassName;

    protected $id;
    protected $name;
    protected $birthdate;
    protected $cpf;
    protected $status;

    protected $hiden = ['id'];

    function __construct($data = [])
    {
        $this->set($data);
    }

    public function contact()
    {
        echo new Contact();
    }
}
