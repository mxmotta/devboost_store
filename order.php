<?php

use App\Model\Customer;
use App\Model\Order;
use App\Model\Product;

$customers = [
    new Customer(['id' => 1, 'name' => "Marcelo", 'birthdate' => '0000-00-00', 'status' => true]),
    new Customer(['id' => 2, 'name' => "Lucas", 'birthdate' => '0000-00-00', 'status' => false]),
    new Customer(['id' => 3, 'name' => "Rafael", 'birthdate' => '0000-00-00', 'status' => false])
];

$products = [
    new Product([
        'id'          => 1,
        'name'        => "Xiomi Redmi Note 11",
        'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
    ]),
    new Product([
        'id'          => 2,
        'name'        => "Poco X5 pro",
        'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
    ]),
    new Product([
        'id'          => 3,
        'name'        => "iPhone 14",
        'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
    ]),
];

$orders = [
    new Order([
        'id' => 1,
        'customer' => new Customer(['name' => "Marcelo", 'birthdate' => '0000-00-00', 'status' => true]),
        'products' => [
            new Product([
                'name'        => "Xiomi Redmi Note 11",
                'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
            ]),
            new Product([
                'name'        => "Poco X5 pro",
                'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
            ]),
        ],
        'status' => true
    ]),
    new Order([
        'id' => 2,
        'customer' => new Customer(['name' => "Lucas", 'birthdate' => '0000-00-00', 'status' => false]),
        'products' => [
            new Product([
                'name'        => "Poco X5 pro",
                'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
            ]),
        ],
        'status' => true
    ]),
    new Order([
        'id' => 3,
        'customer' => new Customer(['name' => "Rafael", 'birthdate' => '0000-00-00', 'status' => false]),
        'products' => [
            new Product([
                'name'        => "Xiomi Redmi Note 11",
                'description' => "Smartphone tela amoled, 128gb armazenamento, 6gb",
            ]),
        ],
        'status' => false
    ]),
];

if(isset($_POST['order'])) {
    
    // array_push($products, new Product([
    //     'name'          => $_POST['product']['name'],
    //     'description'   => $_POST['product']['description'],
    // ]));
}


?>

<div class="card flex w-full">

    <div class="card-actions">
        <div>
            <input type="search" name="search" placeholder="Buscar">
        </div>
        <div>
            <a href="/?page=order_add" class="btn btn-primary">Adicionar pedido</a>
        </div>
    </div>

    <div class="card-content">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-left">ID</th>
                    <th class="text-left">Cliente</th>
                    <th class="text-left">Produtos</th>
                    <th class="text-right">Status</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td class="text-left"><?= $order->get()['id'] ?></td>
                        <td class="text-left"><?= $order->get()['customer']->get()['name'] ?></td>
                        <td class="text-left">
                            <?php foreach($order->get()['products'] as $product){
                                echo $product->get()['name'] . '<br />';
                            } ?>
                        </td>
                        <td class="text-right">
                            <span class="badge <?= ($order->get()['status'] ? 'badge-success' : 'badge-danger') ?>">
                                <?= ($order->get()['status'] ? 'Aprovado' : 'Cancelado') ?>
                            </span>
                        </td>
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