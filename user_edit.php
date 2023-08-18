<?php

use App\Model\User;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'])) {


    if (
        isset($_POST['user']['password']) &&
        $_POST['user']['password'] != '' &&
        $_POST['user']['password'] === $_POST['user']['password_confirmation']
    ) {
        $_POST['user']['password'] = md5($_POST['user']['password']);
    } else {
        unset($_POST['user']['password']);
    }

    unset($_POST['user']['password_confirmation']);

    $user  = new User($_POST['user']);
    $user = $user->update();

    echo "<script>window.location.href='/?page=user'</script>";
} else {

    $user = new User();

    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($id) {
        $user = $user->find($id);
    }
}

?>


<div class="card flex w-full">
    <div class="card-actions">
        <h2>Editar usuário</h2>
    </div>
    <div class="card-content">
        <form action="/?page=user_edit" method="post">

            <input type="hidden" name="user[id]" value="<?= $user->id ?>">
            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="name">Nome</label>
                    <input type="text" id="name" name="user[name]" value="<?= $user->name ?>" placeholder="Nome" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="user[login]" value="<?= $user->login ?>" placeholder="Email" class="">
                </div>
            </div>

            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="user[password]" placeholder="Senha" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="password_confirmation">Confirmar Senha</label>
                    <input type="password" id="password_confirmation" name="user[password_confirmation]" placeholder="Confirmar Senha" class="">
                </div>
            </div>

            <div class="text-right w-full">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Gravar
                </button>
            </div>
        </form>
    </div>
</div>