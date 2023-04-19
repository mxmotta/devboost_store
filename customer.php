<?php

use App\Model\Customer;

$customers = [
    new Customer(['name' => "Marcelo", 'birthdate' => '0000-00-00', 'status' => true]),
    new Customer(['name' => "Lucas", 'birthdate' => '0000-00-00', 'status' => false]),
    new Customer(['name' => "Rafael", 'birthdate' => '0000-00-00', 'status' => false])
];
?>

<div class="card flex w-full">

    <div class="card-actions">
        <div>
            <input type="search" name="search" placeholder="Buscar">
        </div>
        <div>
            <a href="#" class="btn btn-primary">Adicionar cliente</a>
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
                        <td class="text-left"><?= $customer->get()['name'] ?></td>
                        <td class="text-center"><?= $customer->get()['birthdate'] ?></td>
                        <td class="text-right"><span class="badge <?= ($customer->get()['status'] ? 'badge-success' : 'badge-danger') ?>"><?= ($customer->get()['status'] ? 'Ativo' : 'Inativo') ?></span></td>
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