<?php

use App\Model\Customer;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\Product;
use Carbon\Carbon;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order'])) {


    $order  = new Order($_POST['order']);
    $order->date = Carbon::now()->format('Y-m-d H:i:s');
    $order->status = 0;
    $order = $order->create();

    if (isset($_POST['order_products'])) {
        foreach ($_POST['order_products'] as $order_product) {
            $order_product = new OrderProduct($order_product);
            $order_product->order_id = $order->id;

            $order_product->create();
        }
    }

    echo "<script>window.location.href='/?page=order'</script>";
} else {

    $customer = new Customer();
    $product = new Product();

    $customers = $customer->get();
    $products = $product->get();
}

?>

<div class="card flex w-full">

    <div class="card-actions">
        <h2>Cadastrar pedido</h2>
    </div>

    <div class="card-content">

        <form id="orderForm" action="/?page=order_add" method="post">

            <div class="flex flex-column flex-nowrap w-full">
                <label for="customer_id">Clientes</label>
                <select id="customer_id" name="order[customer_id]" class="" required>
                    <option value="">Selecione um cliente</option>
                    <?php foreach ($customers as $customer) : ?>
                        <option value="<?= $customer->id ?>"><?= $customer->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="text-right w-full">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Gravar
                </button>
            </div>

            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="product_id">Produtos</label>
                    <select id="product_id" name="order_product[product_id]" class="">
                        <option value="">Selecione um produto</option>
                        <?php foreach ($products as $product) : ?>
                            <option value="<?= $product->id ?>"><?= $product->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="qtd">Quantidade</label>
                    <input type="text" id="qtd" name="order_product[qtd]" placeholder="Quantidade" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="price">Preço</label>
                    <input type="text" id="price" name="order_product[price]" placeholder="Preço do produto" class="money">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="">&nbsp;</label>
                    <button id="addProductOrder" type="button" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Adicionar
                    </button>
                </div>
            </div>

            <table id="productOrderTable" class="table">
                <thead>
                    <tr>
                        <th class="text-left">Nome</th>
                        <th class="text-left">Quantidade</th>
                        <th class="text-left">Preço</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </form>
    </div>

</div>

<script type="module">
    import {
        v4 as uuidv4
    } from 'https://jspm.dev/uuid';

    $('#addProductOrder').on('click', (e) => {

        let order_product = {
            id: uuidv4(),
            product_id: $('#product_id option:selected').val(),
            name: $('#product_id option:selected').text(),
            qtd: $('#qtd').val(),
            price: $('#price').val()
        }

        if (!order_product.id || !order_product.qtd || !order_product.price) {
            return
        }

        $('#productOrderTable').find('tbody').append(`
        <tr id="productOrderLine_${order_product.id}">
            <td class="text-left">${order_product.name}</td>
            <td class="text-left">${order_product.qtd}</td>
            <td class="text-left">${order_product.price}</td>
            <td class="text-right">
                <div class="flex justify-end gap-1">
                    <button type="button" data-id='${order_product.id}' class="btn btn-danger btn-delete">
                        <i data-id='${order_product.id}' class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
        `)

        $('#orderForm').append(`
            <input id="productOrderProduct_${order_product.id}" type="hidden" name="order_products[${order_product.id}][product_id]" value="${order_product.product_id}" />
            <input id="productOrderQtd_${order_product.id}" type="hidden" name="order_products[${order_product.id}][qtd]" value="${order_product.qtd}" />
            <input id="productOrderPrice_${order_product.id}" type="hidden" name="order_products[${order_product.id}][price]" value="${order_product.price}" />
        `)

        $('#product_id').val('')
        $('#qtd').val('')
        $('#price').val('')
    })

    $(document).on('click', '.btn-delete', (e) => {

        let id = $(e.target).data('id')

        $(`#productOrderLine_${id}`).remove()
        $(`#productOrderProduct_${id}`).remove()
        $(`#productOrderQtd_${id}`).remove()
        $(`#productOrderPrice_${id}`).remove()
    })
</script>