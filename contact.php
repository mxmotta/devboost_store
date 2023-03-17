
<?php

use App\Model\Contact;

echo "<pre>";
$contact = new Contact([
    'type' => "email",
    'data' => "marcelo.motta@gmail.com",
]);

var_dump($contact->get());


echo "</pre>";