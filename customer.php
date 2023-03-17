<?php

use App\Model\Customer;

$customers = [
    new Customer(['name' => "Marcelo", 'status' => true]),
    new Customer(['name' => "Lucas", 'status' => false]),
    new Customer(['name' => "Rafael", 'status' => false])
];

echo "<table border=1>";
echo "<tr>";
echo "<th>Nome</th>";
echo "<th>Data de nascimento</th>";
echo "<th>Status</th>";
echo "</tr>";

foreach($customers as $customer) {
    echo "<tr>";
    echo "<td>" . $customer->get()['name'] . "</td>";
    echo "<td>" . $customer->get()['birthdate'] . "</td>";
    echo "<td>" . ($customer->get()['status'] ? 'Ativo' : 'Inativo') . "</td>";
    echo "</tr>";
}

echo "</table>";

