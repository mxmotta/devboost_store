<?php

use App\Model\Customer;
use Carbon\Carbon;

$customer = new Customer();
if (isset($_GET['name'])) {
    $customers = $customer->get([
        'where' => ['name,like,%' . $_GET['name'] . '%']
    ]);
} else {
    $customers = $customer->get();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {

    $customer = $customer->find($_POST['delete']['customer']);
    $customer->delete();

    echo "<script>window.location.href='/?page=customer'</script>";
}
?>
<div class="card flex w-full">

    <div class="card-actions">
        <form id="search-form" method="GET">
            <input type="hidden" name="page" value="customer">
            <input type="search" name="name" placeholder="Buscar">
        </form>
        <div>
            <a href="/?page=customer_add" class="btn btn-primary">Adicionar cliente</a>
        </div>
    </div>

    <div class="card-content">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-left">Nome</th>
                    <th class="text-center">Data de nascimento</th>
                    <th class="text-right">Status</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer) : ?>
                    <tr>
                        <td class="text-left"><?= $customer->name ?></td>
                        <td class="text-center"><?= $customer->birthdate ? Carbon::parse($customer->birthdate)->format('d/m/Y') : '' ?></td>
                        <td class="text-right"><span class="badge <?= ($customer->status ? 'badge-success' : 'badge-danger') ?>"><?= ($customer->status ? 'Ativo' : 'Inativo') ?></span></td>
                        <td class="text-right">
                            <div class="flex justify-end gap-1">
                                <a href="/?page=customer_edit&id=<?= $customer->id ?>" class="btn btn-primary">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <form class="delete-form" action="/?page=customer" method="post">
                                    <input type="hidden" name="delete[customer]" value="<?= $customer->id ?>">
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
                text: "Tem certeza que quer deletar esse cliente?",
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

    // let search_form = document.getElementById('search-form');

    // search_form.addEventListener('submit', (event) => {
    //     event.preventDefault()

    //     let input = event.target.children.name
    //     window.location.href = `${window.location.protocol}//${window.location.host}/?page=customer&name=${input.value}`
    // })
</script>