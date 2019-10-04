<?php
// convert json to an array
$majors = json_decode(file_get_contents('majors.json'));
$continents = json_decode(file_get_contents('continents.json'));

$request_continents = filter_input_array (INPUT_POST, 
[
    'continents' => [
        'flags'  => FILTER_REQUIRE_ARRAY,
    ]
]);

$response_continents = [];
$t = array_column($continents, 'id');
foreach($request_continents['continents'] as $c)
{
    $key = array_search( $c, $t);
    if( $key !== FALSE )
    {
        array_push($response_continents,$continents[$key]->name);
    }
}
 $request_major = filter_input(INPUT_POST, 'major' );
$key = array_search( $request_major, array_column($majors, 'id'));
$request_major = $key !== false ? 
    $response_major = $majors[$key]->name :
    'Not found';

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