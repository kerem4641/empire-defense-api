<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode([
    'result' => 1,
    'award' => [
        ['day' => 1, 'type' => 1, 'num' => 100],   // 100 crystal
        ['day' => 3, 'type' => 1, 'num' => 200],
        ['day' => 7, 'type' => 1, 'num' => 500],
        ['day' => 15, 'type' => 1, 'num' => 1000],
        ['day' => 30, 'type' => 1, 'num' => 3000],
    ],
    'login_days' => 1
]);
