<?php

use App\Model\Customer;

$customer = new Customer();
$customers = $customer->get();

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
                <?php foreach ($customers as $customer) : ?>
                    <tr>
                        <td class="text-left"><?= $customer->name ?></td>
                        <td class="text-center"><?= $customer->birthdate ?></td>
                        <td class="text-right"><span class="badge <?= ($customer->status ? 'badge-success' : 'badge-danger') ?>"><?= ($customer->status ? 'Ativo' : 'Inativo') ?></span></td>
                        <td class="text-right">
                            <form action="/devboost_store/?page=customer" method="post">
                                <input type="hidden" name="delete[customer]" value="<?= $customer->id ?>">
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