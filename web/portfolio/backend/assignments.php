<?php
$assignments = [
    'status' => 'OK',
    'message' => '',
    'data' => [
        [
            'id' => 1,
            'title' => 'Test',
            'description' => 'Description',
            'due' => '09/29/2019',
            'url' => 'http://www.pontonet.com',
            'status' => 'Pending'
        ],
        [
            'id' => 2,
            'title' => 'Test 2',
            'description' => 'Description 2',
            'due' => '09/30/2019',
            'url' => 'http://infinita.info',
            'status' => 'Done'
        ],
        [
            'id' => 3,
            'title' => 'Test 3',
            'description' => 'Description 3',
            'due' => '09/28/2019',
            'url' => 'http://turbospot.com.br',
            'status' => 'Working'
        ]
    ]
];

header('Content-Type: application/json');
echo json_encode($assignments);
?>