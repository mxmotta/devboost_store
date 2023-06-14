<?php

use App\Model\Customer;

$customers = [
    new Customer(['name' => "Marcelo", 'birthdate' => '0000-00-00', 'status' => true]),
    new Customer(['name' => "Lucas", 'birthdate' => '0000-00-00', 'status' => false]),
    new Customer(['name' => "Rafael", 'birthdate' => '0000-00-00', 'status' => false])
];

if (isset($_POST['customer'])) {
    array_push($customers, new Customer([
        'name'      => $_POST['customer']['name'],
        'birthdate' => $_POST['customer']['birthdate'],
        'status'    => true,
    ]));
}

if(isset($_POST['delete'])) {
    unset($customers[$_POST['delete']['customer']]);
}

?>

<div class="card flex w-full">

    <div class="card-actions">
        <div>
            <input type="search" name="search" placeholder="Buscar">
        </div>
        <div>
            <a href="/devboost_store/?page=customer_add" class="btn btn-primary">Adicionar cliente</a>
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
                <?php foreach ($customers as $key => $customer) : ?>
                    <tr>
                        <td class="text-left"><?= $customer->get()['name'] ?></td>
                        <td class="text-center"><?= $customer->get()['birthdate'] ?></td>
                        <td class="text-right"><span class="badge <?= ($customer->get()['status'] ? 'badge-success' : 'badge-danger') ?>"><?= ($customer->get()['status'] ? 'Ativo' : 'Inativo') ?></span></td>
                        <td class="text-right">
                            <form action="/devboost_store/?page=customer" method="post">
                                <input type="hidden" name="delete[customer]" value="<?= $key ?>">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>



</div>