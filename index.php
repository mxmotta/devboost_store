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
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div id="app" class="flex">
        <div id="sidebar" class="flex bg-dark-blue">
            <div id="logo-container" class="flex w-full">
                <img src="assets/images/logo.svg" alt="Devboost Store">
            </div>
            <nav>
                <ul id="main-menu">
                    <li><a href="/"><i class="fa-solid fa-house"></i>Home</a></li>
                    <li><a href="/?page=order"><i class="fa-solid fa-pen-to-square"></i>Pedidos</a></li>
                    <li><a href="/?page=customer"><i class="fa-solid fa-user-group"></i>Clientes</a></li>
                    <li><a href="/?page=product"><i class="fa-solid fa-boxes-stacked"></i>Produtos</a></li>
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
                        case 'customer_add':
                            require 'customer_add.php';
                            break;
                        case 'customer_edit':
                            require 'customer_edit.php';
                            break;
                        case 'product':
                            require 'product.php';
                            break;
                        case 'product_add':
                            require 'product_add.php';
                            break;
                        case 'product_edit':
                            require 'product_edit.php';
                            break;
                        case 'contact':
                            require 'contact.php';
                            break;
                        case 'order':
                            require 'order.php';
                            break;
                        case 'order_add':
                            require 'order_add.php';
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

    <script src="assets/js/script-jquery.js"></script>
</body>

</html>