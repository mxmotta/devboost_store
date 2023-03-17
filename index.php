<?php

require "vendor/autoload.php";

if(isset($_GET['page'])) {
    $page = $_GET['page'];

    switch($page) {
        case 'customer':
            require 'customer.php';
            break;
        case 'product':
            require 'product.php';
            break;
        case 'contact':
            require 'contact.php';
            break;
        
        default:
            echo "<h1>Erro 404, página não encontrada</h1>";
            break;
    }
}


