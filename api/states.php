<?php

use App\Model\State;

$state = new State();
$states = $state->get();

$data = [];

foreach($states as $state) {
    array_push($data, $state->toArray());
}

header('Content-Type: application/json');

echo json_encode($data, JSON_PRETTY_PRINT);

