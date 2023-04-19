<?php require "vendor/autoload.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devboost Store</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://kit.fontawesome.com/cbdbd58c22.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="app" class="flex">
        <div id="sidebar" class="flex bg-dark-blue">
            <div id="logo-container" class="flex w-full">
                <img src="assets/images/logo.svg" alt="Devboost Store">
            </div>
            <nav>
                <ul id="main-menu">
                    <li><a href="/devboost_store"><i class="fa-solid fa-house"></i>Home</a></li>
                    <li><a href="/devboost_store/?page=orders"><i class="fa-solid fa-pen-to-square"></i>Pedidos</a></li>
                    <li><a href="/devboost_store/?page=customer"><i class="fa-solid fa-user-group"></i>Clientes</a></li>
                    <li><a href="/devboost_store/?page=product"><i class="fa-solid fa-boxes-stacked"></i>Produtos</a></li>
                </ul>
            </nav>
        </div>
        <div class="w-full">
            <div id="topbar" class="flex">
                <div id="user-menu"></div>
                <div id="title">
                    <span class="font-bold">Home</span>
                </div>
            </div>
            <div id="content" class="flex">
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];

                    switch ($page) {
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
                ?>
            </div>
        </div>
    </div>
</body>

</html>