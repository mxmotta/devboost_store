<div class="card flex w-full">

    <div class="card-actions">
        <h2>Adicionar produto</h2>
    </div>

    <div class="card-content">

        <form action="/devboost_store/?page=product" method="post">
            <div class="flex flex-column flex-nowrap w-full">
                <label for="photo">Foto do produto</label>
                <input type="file" id="photo" name="product[photo]" placeholder="Foto do produto" class="">
            </div>
            <div class="flex flex-column flex-nowrap w-full">
                <label for="name">Nome</label>
                <input type="text" id="name" name="product[name]" placeholder="Nome do produto" class="">
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