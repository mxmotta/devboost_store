<div class="card flex w-full">
    <div class="card-actions">
        <h2>Adicionar usuário</h2>
    </div>
    <div class="card-content">
        <form id="formCreate" action="/?page=user_add" method="post">
            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="name">Nome</label>
                    <input type="text" id="name" name="user[name]" placeholder="Nome" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="user[login]" placeholder="Email" class="">
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

<script>
    $('#formCreate').on('submit', (e) => {
        e.preventDefault();

        if ($('#password').val() !== $('#password_confirmation').val()) {
            Swal.fire({
                icon: 'error',
                title: 'Erro na validação',
                text: 'Confirmação de senha inválida!'
            })
        }

        e.target.submit()
    })
</script>

<?php

use App\Model\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'])) {

    if ($_POST['user']['password'] !== $_POST['user']['password_confirmation']) {
        echo "<script>window.location.href='/?page=user_add&message=Confirmação de senha inválida'</script>";
    }

    unset($_POST['user']['password_confirmation']);

    $user  = new User($_POST['user']);
    $user->password = md5($user->password);

    $user = $user->create();

    echo "<script>window.location.href='/?page=user'</script>";
}
?>