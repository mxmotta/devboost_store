<div class="card flex w-full">

    <div class="card-actions">
        <h2>Adicionar produto</h2>
    </div>

    <div class="card-content">

        <form action="/?page=product_add" method="post" enctype="multipart/form-data">
            <div class="flex flex-column flex-nowrap w-full">
                <label for="photo">Foto do produto</label>
                <input type="file" id="photo" name="photo" placeholder="Foto do produto" class="">
            </div>
            <div class="flex flex-column flex-nowrap w-full">
                <label for="name">Nome</label>
                <input type="text" id="name" name="product[name]" placeholder="Nome do produto" class="">
            </div>
            <div class="flex flex-column flex-nowrap w-full">
                <label for="price">Preço</label>
                <input type="text" id="price" name="product[price]" placeholder="Preço do produto" class="money">
            </div>
            <div class="flex flex-column flex-nowrap w-full">
                <label for="description">Descrição</label>
                <textarea id="description" name="product[description]" placeholder="Descrição do produto" rows="10" class=""></textarea>
            </div>
            <div class="text-right w-full">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Gravar
                </button>
            </div>
        </form>

    </div>

</div>

<?php

use App\Model\Product;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product'])) {

    $product  = new Product($_POST['product']);

    $product = $product->create();

    if (isset($_FILES['photo'])) {
        $product->createPhoto($_FILES['photo']);
    }

    echo "<script>window.location.href='/?page=product'</script>";
}
?>