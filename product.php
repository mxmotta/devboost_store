<?php

use App\Model\Product;

echo "<pre>";
$product = new Product([
    'name'        => "Xiomi Redmi Note 11",
    'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
]);

var_dump($product->get());

echo "</pre>";