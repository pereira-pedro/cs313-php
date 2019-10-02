<?php
// convert json to an array
$majors = json_decode(file_get_contents('majors.json'));
$continents = json_decode(file_get_contents('continents.json'));

$request_continents = filter_input(INPUT_POST, 'continents[]' );

$response_continents = [];
var_dump($request_continents);
var_dump($continents);
var_dump($majors);
foreach($request_continents as $c)
{
    if( in_array($c['id'], $continents) )
    {
        array_push($response_continents,$c['name']);
    }
}

$response_major = array_search( filter_input(INPUT_POST, 'major' ), array_column($majors, 'id'));

// get request from POST method and sanitize them
$response = [
    'Name' => filter_input(INPUT_POST, 'name' ),
    'Email' => filter_input(INPUT_POST, 'email' ),
    'Major' => $response_major,
    'Continents' => $response_continents,
    'Comments' => filter_input(INPUT_POST, 'comments' )
];


header('Content-Type: application/json');
echo json_encode($response);
?>