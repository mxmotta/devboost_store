<?php

use App\Model\Product;

$product = new Product();
if (isset($_GET['name'])) {
    $products = $product->get([
        'where' => ['name,like,%' . $_GET['name'] . '%']
    ]);
} else {
    $products = $product->get();

    // foreach($products as $product){
    //     $target_dir = "uploads/product/" . $product->id . "/";
    //     $files = array_diff(scandir($target_dir), array('.', '..'));
        
    //     if(count($files) > 0){
    //         var_dump(end($files));
    //         // $product->photo = end($files);
    //     }
    
    // }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {

    $product = $product->find($_POST['delete']['product']);
    $product->delete();

    echo "<script>window.location.href='/?page=product'</script>";
}
?>

<div class="card flex w-full">

    <div class="card-actions">
        <form id="search-form" method="GET">
            <input type="hidden" name="page" value="product">
            <input type="search" name="name" placeholder="Buscar">
        </form>
        <div>
            <a href="/?page=product_add" class="btn btn-primary">Adicionar produto</a>
        </div>
    </div>

    <div class="card-content">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th class="text-left">Nome</th>
                    <th class="text-left">Descrição</th>
                    <th class="text-left">Preço</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td class="text-left">
                            <img src="/uploads/product/<?= $product->id ?>/20230802011537.jpg" alt="" width="70">
                        </td>
                        <td class="text-left"><?= $product->name ?></td>
                        <td class="text-left"><?= $product->description ?></td>
                        <td class="text-left">R$ <?= number_format($product->price, 2, ',', '.') ?></td>
                        <td class="text-right">
                            <div class="flex justify-end gap-1">
                                <a href="/?page=product_edit&id=<?= $product->id ?>" class="btn btn-primary">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <form class="delete-form" action="/?page=product" method="post">
                                    <input type="hidden" name="delete[product]" value="<?= $product->id ?>">
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
                text: "Tem certeza que quer deletar esse produto?",
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