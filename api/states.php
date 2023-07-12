<?php

use App\Model\State;

$state = new State();

$order = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;

$options = [
    'order' => $order
];

$states = $state->get($options);

$data = [];

foreach($states as $state) {
    array_push($data, $state->toArray());
}

header('Content-Type: application/json');

echo json_encode($data);

