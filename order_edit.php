<?php

use App\Model\Customer;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\Product;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order'])) {

    $order  = new Order($_POST['order']);

    $order = $order->update();

    echo "<script>window.location.href='/?page=order'</script>";
} else {

    $order = new Order();
    $customer = new Customer();
    $product = new Product();

    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($id) {
        $order = $order->find($id);
        $customers = $customer->get();
        $products = $product->get();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_product'])) {
    $order_product = new OrderProduct($_POST['order_product']);
    $order_product->create();
    echo "<script>window.location.href='/?page=order_edit&id=" . $_POST['order_product']['order_id'] . "'</script>";
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['delete']) &&
    isset($_POST['delete']['order_id']) &&
    isset($_POST['delete']['product_id'])
) {

    $order_product = new OrderProduct();
    $order_products = $order_product->get([
        'where' => [
            'order_id,=,' . $_POST['delete']['order_id'],
            'product_id,=,' . $_POST['delete']['product_id'],
        ]
    ]);

    if (count($order_products) > 0) {
        $order_products[0]->deleteWhere([
            'where' => [
                'order_id,=,' . $_POST['delete']['order_id'],
                'product_id,=,' . $_POST['delete']['product_id'],
            ]
        ]);
    }

    echo "<script>window.location.href='/?page=order_edit&id=" . $_POST['delete']['order_id'] . "'</script>";
}

?>

<div class="card flex w-full">

    <div class="card-actions">
        <h2>Editar pedido</h2>
    </div>

    <div class="card-content">

        <form action="/?page=order_edit" method="post">
            <input type="hidden" name="order[id]" value="<?= $order->id ?>">

            <div class="flex flex-column flex-nowrap w-full">
                <label for="customer_id">Clientes</label>
                <select id="customer_id" name="order[customer_id]" class="" required>
                    <?php foreach ($customers as $customer) : ?>
                        <option value="<?= $customer->id ?>" <?= $customer->id == $order->customer_id ? 'selected' : '' ?>><?= $customer->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex flex-column flex-nowrap w-full">
                <label for="status">Status</label>
                <select id="status" name="order[status]" class="" required>
                    <option value="0" <?= $order->status == 0 ? 'selected' : '' ?>>Inativo</option>
                    <option value="1" <?= $order->status == 1 ? 'selected' : '' ?>>Ativo</option>
                </select>
            </div>

            <div class="text-right w-full">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Gravar
                </button>
            </div>
        </form>

        <form action="/?page=order_edit" method="post">
            <input type="hidden" name="order_product[order_id]" value="<?= $order->id ?>">

            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="product_id">Produtos</label>
                    <select id="product_id" name="order_product[product_id]" class="" required>
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Adicionar
                    </button>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th class="text-left">Nome</th>
                    <th class="text-left">Quantidade</th>
                    <th class="text-left">Preço</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order->products as $key => $order_product) : ?>

                    <tr>
                        <td class="text-left">
                            <img src="<?= $order_product->product->photo?->path ?>" alt="" width="70">
                        </td>
                        <td class="text-left"><?= $order_product->product->name ?></td>
                        <td class="text-left"><?= $order_product->qtd ?></td>
                        <td class="text-left">R$ <?= number_format($order->products[$key]->price, 2, ',', '.') ?></td>
                        <td class="text-right">
                            <div class="flex justify-end gap-1">
                                <form class="delete-form" action="" method="post">
                                    <input type="hidden" name="delete[order_id]" value="<?= $order_product->order_id ?>">
                                    <input type="hidden" name="delete[product_id]" value="<?= $order_product->product_id ?>">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>

<script>
    let formDelete = document.getElementsByClassName('delete-form');

    Array.from(formDelete).forEach(form => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            Swal.fire({
                title: 'Você está certo disso?',
                text: "Tem certeza que quer remover esse produto do pedido?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, manda ver!',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit()
                }
            })
        })
    })
</script>