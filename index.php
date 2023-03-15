<?php

include "Model/Model.php";
include "Model/Customer.php";
include "Model/Product.php";
include "Model/Contact.php";

$customer = new Customer([
    'name'      => "Marcelo",
    'birthdate' => "0000-00-00",
    'status'    => true
]);

echo "<pre>";
// var_dump($customer->get());
echo "<br />";
var_dump($customer->set([
    'name' => 'Marcelo Motta'
]));

$product = new Product([
    'name'        => "Xiomi Redmi Note 11",
    'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
]);

var_dump($product->get());
echo "<br />";

$contact = new Contact([
    'type' => "email",
    'data' => "marcelo.motta@gmail.com",
]);

var_dump($contact->get());
echo "<br />";


echo "</pre>";