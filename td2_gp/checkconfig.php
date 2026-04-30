<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode(['result'=>1,'need_update'=>0,'version'=>'1.6.3.0']);
