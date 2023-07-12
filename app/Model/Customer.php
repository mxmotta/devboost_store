<?php

namespace App\Model;

use App\Model\Trait\ClassName;

class Customer extends Model
{

    use ClassName;

    public $id;
    public $name;
    public $birthdate;
    public $cpf;
    public $status;

    protected $table = "customers";

    protected $hiden = [];

    function __construct($data = [])
    {
        $this->set($data);
    }

    public function contact()
    {
        echo new Contact();
    }
}