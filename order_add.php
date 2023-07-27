<?php

use App\Model\Customer;
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

?>

<div class="card flex w-full">

    <div class="card-actions">
        <h2>Adicionar pedido</h2>
    </div>

    <div class="card-content">

        <form action="/?page=order" method="post">
            <div class="flex flex-column flex-nowrap w-full">
                <label for="customer">Cliente</label>
                <select id="customer" name="order[customer_id]" class="">
                    <option value="">Selecione o cliente</option>
                    <?php foreach ($customers as $customer) : ?>
                        <option value="<?= $customer->get()['id'] ?>"><?= $customer->get()['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex flex-column flex-nowrap w-full">
                <label for="customer">Produto</label>
                <select id="customer" name="order[product_id]" class="">
                    <option value="">Selecione o produto</option>
                    <?php foreach ($products as $product) : ?>
                        <option value="<?= $product->get()['id'] ?>"><?= $product->get()['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="text-right w-full">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Gravar
                </button>
            </div>
        </form>

    </div>



</div>