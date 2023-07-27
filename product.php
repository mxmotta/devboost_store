<?php

use App\Model\Product;

$products = [
    new Product([
        'name'        => "Xiomi Redmi Note 11",
        'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
    ]),
    new Product([
        'name'        => "Poco X5 pro",
        'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
    ]),
    new Product([
        'name'        => "iPhone 14",
        'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
    ]),
];



if(isset($_POST['product'])) {
    array_push($products, new Product([
        'name'          => $_POST['product']['name'],
        'description'   => $_POST['product']['description'],
    ]));
}

?>

<div class="card flex w-full">

    <div class="card-actions">
        <div>
            <input type="search" name="search" placeholder="Buscar">
        </div>
        <div>
            <a href="/?page=product_add" class="btn btn-primary">Adicionar produto</a>
        </div>
    </div>

    <div class="card-content">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-left">Nome</th>
                    <th class="text-left">Descrição</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td class="text-left"><?= $product->get()['name'] ?></td>
                        <td class="text-left"><?= $product->get()['description'] ?></td>
                        <td class="text-right">
                            <button class="btn btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>



</div>
