<?php

use App\Model\Order;
use Carbon\Carbon;

$order = new Order();
if (isset($_GET['name'])) {
    $orders = $order->get([
        'where' => ['name,like,%' . $_GET['name'] . '%']
    ]);
} else {
    $orders = $order->get();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {

    $order = $order->find($_POST['delete']['order']);
    $order->delete();

    echo "<script>window.location.href='/?page=order'</script>";
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
                    <th class="text-left">Data</th>
                    <th class="text-left">Cliente</th>
                    <!-- <th class="text-left">Produtos</th> -->
                    <th class="text-right">Status</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td class="text-left"><?= $order->id ?></td>
                        <td class="text-left"><?= $order->date ? Carbon::parse($order->date)->format('d/m/Y') : '' ?></td>
                        <td class="text-left"><?= $order->customer->name ?></td>
                        <td class="text-right"><span class="badge <?= ($order->status ? 'badge-success' : 'badge-danger') ?>"><?= ($order->status ? 'Ativo' : 'Inativo') ?></span></td>
                        <td class="text-right">
                            <div class="flex justify-end gap-1">
                                <a href="/?page=order_edit&id=<?= $order->id ?>" class="btn btn-primary">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <form class="delete-form" action="/?page=order" method="post">
                                    <input type="hidden" name="delete[order]" value="<?= $order->id ?>">
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
                text: "Tem certeza que quer deletar esse pedido?",
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