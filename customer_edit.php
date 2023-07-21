<?php

use App\Model\Address;
use App\Model\City;
use App\Model\Contact;
use App\Model\Customer;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customer'])) {

    $customer  = new Customer($_POST['customer']);
    $customer = $customer->update();

    if (isset($_POST['customer']['contacts'])) {
        $contacts = $_POST['customer']['contacts'];

        foreach ($contacts as $contact) {
            $contact['customer_id'] = $customer->id;
            $contact = new Contact($contact);
            $contact->updateOrCreate([
                'type'          => $contact->type,
                'customer_id'   => $contact->customer_id
            ]);
        }
    }

    if (isset($_POST['customer']['address'])) {
        $address = $_POST['customer']['address'];

        $address['customer_id'] = $customer->id;
        $address = new Address($address);
        $address->updateOrCreate([
            'customer_id'   => $contact->customer_id
        ]);
    }

    echo "<script>window.location.href='/devboost_store/?page=customer'</script>";
} else {

    $customer = new Customer();
    $contact = new Contact();
    $address = new Address();
    $city = new City();

    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($id) {
        $customer = $customer->find($id);
        $contacts = $contact->get([
            'where' => ['customer_id,=,' . $id]
        ]);
        $address = $address->get([
            'where' => ['customer_id,=,' . $id]
        ]);
        $city = $city->find($address[0]->city_id);

        $customer_contacts['email'] = [
            'id' => null,
            'value' => null
        ];
        $customer_contacts['phone'] = [
            'id' => null,
            'value' => null
        ];
        $customer_contacts['mobile'] = [
            'id' => null,
            'value' => null
        ];

        foreach ($contacts as $contact) {
            $customer_contacts[$contact->type]['id'] = $contact->id;
            $customer_contacts[$contact->type]['value'] = $contact->value;
        }
    }
}

?>


<div class="card flex w-full">
    <div class="card-actions">
        <h2>Editar cliente</h2>
    </div>
    <div class="card-content">
        <form action="/devboost_store/?page=customer_edit" method="post">

            <input type="hidden" name="customer[id]" value="<?= $customer->id ?>">
            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="name">Nome</label>
                    <input type="text" id="name" name="customer[name]" value="<?= $customer->name ?>" placeholder="Nome" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="birthdate">Data de nascimento</label>
                    <input type="date" id="birthdate" name="customer[birthdate]" value="<?= $customer->birthdate ?>" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="customer[cpf]" value="<?= $customer->cpf ?>" placeholder="CPF" class="">
                </div>
            </div>

            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="email">Email</label>
                    <input type="hidden" name="customer[contacts][0][type]" value="email">
                    <input type="hidden" name="customer[contacts][0][id]" value="<?= $customer_contacts['email']['id'] ?>">
                    <input type="email" id="email" name="customer[contacts][0][value]" value="<?= $customer_contacts['email']['value'] ?>" placeholder="Email" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="phone">Telefone</label>
                    <input type="hidden" name="customer[contacts][1][type]" value="phone">
                    <input type="hidden" name="customer[contacts][1][id]" value="<?= $customer_contacts['phone']['id'] ?>">
                    <input type="text" id="phone" name="customer[contacts][1][value]" value="<?= $customer_contacts['phone']['value'] ?>" placeholder="Telefone" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="city">Celular</label>
                    <input type="hidden" name="customer[contacts][2][type]" value="mobile">
                    <input type="hidden" name="customer[contacts][2][id]" value="<?= $customer_contacts['mobile']['id'] ?>">
                    <input type="text" id="mobile" name="customer[contacts][2][value]" value="<?= $customer_contacts['mobile']['value'] ?>" placeholder="Celular" class="">
                </div>
            </div>
            <input type="hidden" name="customer[address][id]" value="<?= $address[0]->id ?>">

            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="street">Rua</label>
                    <input type="text" id="street" name="customer[address][street]" value="<?= $address[0]->street ?? "" ?>" placeholder="Rua" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="district">Bairro</label>
                    <input type="text" id="district" name="customer[address][district]" value="<?= $address[0]->district ?? "" ?>" placeholder="Bairro" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="number">Número</label>
                    <input type="text" id="number" name="customer[address][number]" value="<?= $address[0]->number ?? "" ?>" placeholder="Número" class="">
                </div>
            </div>

            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="state">Estado <div id="loading_states" class="lds-ellipsis">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div></label>
                    <select id="state" name="customer[address][state]" data-selected="<?= $city->state_id ?>" class="">
                        <option value="">Selecione o estado</option>
                    </select>
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="city">Cidade <div id="loading_cities" class="lds-ellipsis">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div></label>
                    <select id="city" name="customer[address][city_id]" data-selected="<?= $address[0]->city_id ?? "" ?>" class="">
                        <option value="">Selecione uma cidade</option>
                    </select>
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