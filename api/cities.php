<?php

use App\Model\City;

header('Content-Type: application/json');

if(!isset($_GET['state_id'])) {
    return [];
}

$city = new City();

$options = [
    'order' => 'name,asc',
    'where' => 'state_id,=,' . $_GET['state_id']
];

$cities = $city->get($options);

$data = [];

foreach($cities as $city) {
    array_push($data, $city->toArray());
}

echo json_encode($data);