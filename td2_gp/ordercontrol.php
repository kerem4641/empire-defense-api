<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode(['result'=>1,'order_id'=>uniqid(),'status'=>'ok']);
