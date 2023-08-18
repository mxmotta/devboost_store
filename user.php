<?php

use App\Model\User;

$user = new User();
if (isset($_GET['name'])) {
    $users = $user->get([
        'where' => ['name,like,%' . $_GET['name'] . '%']
    ]);
} else {
    $users = $user->get();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {

    $user = $user->find($_POST['delete']['user']);
    $user->delete();

    echo "<script>window.location.href='/?page=user'</script>";
}
?>
<div class="card flex w-full">

    <div class="card-actions">
        <form id="search-form" method="GET">
            <input type="hidden" name="page" value="user">
            <input type="search" name="name" placeholder="Buscar">
        </form>
        <div>
            <a href="/?page=user_add" class="btn btn-primary">Adicionar usuário</a>
        </div>
    </div>

    <div class="card-content">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-left">Nome</th>
                    <th class="text-left">Email</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td class="text-left"><?= $user->name ?></td>
                        <td class="text-left"><?= $user->login ?></td>
                        <td class="text-right">
                            <div class="flex justify-end gap-1">
                                <a href="/?page=user_edit&id=<?= $user->id ?>" class="btn btn-primary">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <form class="delete-form" action="/?page=user" method="post">
                                    <input type="hidden" name="delete[user]" value="<?= $user->id ?>">
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
                text: "Tem certeza que quer deletar esse usuário?",
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