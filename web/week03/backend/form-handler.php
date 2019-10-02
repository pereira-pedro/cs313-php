<?php
// convert json to an array
$majors = json_decode(file_get_contents('majors.json'));
$continents = json_decode(file_get_contents('continents.json'));

$request_continents = filter_input(INPUT_POST, 'continents' );

$response_continents = [];
foreach($c as $continents)
{
    if( in_array($c['id'], $request_continents) )
    {
    array_push($response_continents,$c['name']);
    }
}
// get request from POST method and sanitize them
$response = [
    'Name' => filter_input(INPUT_POST, 'name' ),
    'Email' => filter_input(INPUT_POST, 'email' ),
    'Major' => filter_input(INPUT_POST, 'major' ),
    'Continents' => $response_continents,
    'Comments' => filter_input(INPUT_POST, 'comments' )
];


header('Content-Type: application/json');
echo json_encode($response);
?>