<div class="card flex w-full">
    <div class="card-actions">
        <h2>Adicionar cliente</h2>
    </div>
    <div class="card-content">
        <form action="/?page=customer_add" method="post">
            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="name">Nome</label>
                    <input type="text" id="name" name="customer[name]" placeholder="Nome" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="birthdate">Data de nascimento</label>
                    <input type="date" id="birthdate" name="customer[birthdate]" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="customer[cpf]" placeholder="CPF" class="">
                </div>
            </div>

            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="email">Email</label>
                    <input type="hidden" name="customer[contacts][0][type]" value="email">
                    <input type="email" id="email" name="customer[contacts][0][value]" placeholder="Email" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="phone">Telefone</label>
                    <input type="hidden" name="customer[contacts][1][type]" value="phone">
                    <input type="text" id="phone" name="customer[contacts][1][value]" placeholder="Telefone" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="city">Celular</label>
                    <input type="hidden" name="customer[contacts][2][type]" value="mobile">
                    <input type="text" id="mobile" name="customer[contacts][2][value]" placeholder="Celular" class="">
                </div>
            </div>

            <div class="flex flex-row justify-between gap-1">
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="street">Rua</label>
                    <input type="text" id="street" name="customer[address][street]" placeholder="Rua" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="district">Bairro</label>
                    <input type="text" id="district" name="customer[address][district]" placeholder="Bairro" class="">
                </div>
                <div class="flex flex-column flex-nowrap w-full">
                    <label for="number">Número</label>
                    <input type="text" id="number" name="customer[address][number]" placeholder="Número" class="">
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
                    <select id="state" name="customer[address][state]" class="">
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
                    <select id="city" name="customer[address][city_id]" class="">
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

<?php

use App\Model\Address;
use App\Model\Contact;
use App\Model\Customer;

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customer'])) {

        $customer  = new Customer($_POST['customer']);
        $customer = $customer->create();

        if (isset($_POST['customer']['contacts'])) {
            $contacts = $_POST['customer']['contacts'];
    
            foreach ($contacts as $contact) {
                $contact['customer_id'] = $customer->id;
                $contact = new Contact($contact);
                $contact->create();
            }
        }
    
        if (isset($_POST['customer']['address'])) {
            $address = $_POST['customer']['address'];
    
            $address['customer_id'] = $customer->id;
            $address = new Address($address);
            $address->create();
        }

        echo "<script>window.location.href='/?page=customer'</script>";
    }
?>