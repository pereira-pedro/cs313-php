<?php
// convert json to an array
$majors = json_decode(file_get_contents('majors.json'));

// get request from POST method and sanitize them
$response = [
    'Name' => filter_input(INPUT_POST, 'name' ),
    'Email' => filter_input(INPUT_POST, 'email' ),
    'Major' => filter_input(INPUT_POST, 'major' ),
    'Comments' => filter_input(INPUT_POST, 'comments' )
];


header('Content-Type: application/json');
echo json_encode($response);
?>