<?php require "vendor/autoload.php"; ?>

<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    switch ($page) {
        case 'states':
            require 'api/states.php';
            break;
        case 'cities':
            require 'api/cities.php';
            break;

        default:
            echo [
                "message" => "Erro 404, página não encontrada",
                "code"    => 404
            ];
            break;
    }
}
?>