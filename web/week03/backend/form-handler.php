<?php
$response = [
    'name' => filter_input(INPUT_POST, 'name' ),
    'email' => filter_input(INPUT_POST, 'email' ),
    'major' => filter_input(INPUT_POST, 'major' ),
    'comments' => filter_input(INPUT_POST, 'comments' )
];

header('Content-Type: application/json');
echo json_encode($response);
?>