<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode(['result'=>1,'life'=>10,'max_life'=>10]);
