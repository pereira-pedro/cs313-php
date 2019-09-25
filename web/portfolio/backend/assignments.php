<?php
$assignments = [
    [
        'name' => 'Test',
        'description' => 'Description',
        'due' => '09/29/2019',
        'status' => 'Pending'
    ],
    [
        'name' => 'Test 2',
        'description' => 'Description 2',
        'due' => '09/30/2019',
        'status' => 'Started'
    ],
];

header('Content-Type: application/json');
echo json_encode($assignments);
?>