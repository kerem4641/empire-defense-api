<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
$db = new SQLite3('/data/data/com.termux/files/home/empire-api/game.db');
$imei = $_GET['imei_key'] ?? $_POST['imei_key'] ?? uniqid();
$uid = 'ED_' . md5($imei);
$stmt = $db->prepare('INSERT OR IGNORE INTO users (username, password, uid) VALUES (?, ?, ?)');
$stmt->bindValue(1, $imei);
$stmt->bindValue(2, md5($imei));
$stmt->bindValue(3, $uid);
$stmt->execute();
$db->exec("INSERT OR IGNORE INTO player_data (uid) VALUES ('$uid')");
echo json_encode(['result'=>1,'uid'=>$uid,'token'=>md5($uid),'nickname'=>'Player','gold'=>1000,'crystal'=>500,'level'=>1]);
$db->close();
