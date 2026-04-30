<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$db = new SQLite3('/data/data/com.termux/files/home/empire-api/game.db');
$action = $_GET['action'] ?? $_POST['action'] ?? '';

function generateUID() {
    return 'ED_' . uniqid() . '_' . rand(1000, 9999);
}

switch($action) {
    case 'register':
        $username = $_POST['username'] ?? '';
        $password = md5($_POST['password'] ?? '');
        $uid = generateUID();
        
        $stmt = $db->prepare('INSERT INTO users (username, password, uid) VALUES (?, ?, ?)');
        $stmt->bindValue(1, $username);
        $stmt->bindValue(2, $password);
        $stmt->bindValue(3, $uid);
        
        if($stmt->execute()) {
            $db->exec("INSERT INTO player_data (uid) VALUES ('$uid')");
            echo json_encode(['status' => 'ok', 'uid' => $uid, 'msg' => 'Kayıt başarılı']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Kullanıcı adı alınmış']);
        }
        break;

    case 'login':
        $username = $_POST['username'] ?? '';
        $password = md5($_POST['password'] ?? '');
        
        $stmt = $db->prepare('SELECT uid FROM users WHERE username=? AND password=?');
        $stmt->bindValue(1, $username);
        $stmt->bindValue(2, $password);
        $result = $stmt->execute()->fetchArray();
        
        if($result) {
            echo json_encode(['status' => 'ok', 'uid' => $result['uid'], 'msg' => 'Giriş başarılı']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Hatalı kullanıcı adı veya şifre']);
        }
        break;

    case 'save':
        $uid = $_POST['uid'] ?? '';
        $gold = $_POST['gold'] ?? 0;
        $crystal = $_POST['crystal'] ?? 0;
        $level = $_POST['level'] ?? 1;
        $heroes = $_POST['heroes'] ?? '[]';
        $towers = $_POST['towers'] ?? '[]';
        $stages = $_POST['stages_completed'] ?? '[]';
        
        $stmt = $db->prepare('UPDATE player_data SET gold=?, crystal=?, level=?, heroes=?, towers=?, stages_completed=?, updated_at=CURRENT_TIMESTAMP WHERE uid=?');
        $stmt->bindValue(1, $gold);
        $stmt->bindValue(2, $crystal);
        $stmt->bindValue(3, $level);
        $stmt->bindValue(4, $heroes);
        $stmt->bindValue(5, $towers);
        $stmt->bindValue(6, $stages);
        $stmt->bindValue(7, $uid);
        $stmt->execute();
        
        echo json_encode(['status' => 'ok', 'msg' => 'Kaydedildi']);
        break;

    case 'load':
        $uid = $_GET['uid'] ?? '';
        
        $stmt = $db->prepare('SELECT * FROM player_data WHERE uid=?');
        $stmt->bindValue(1, $uid);
        $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
        
        if($result) {
            echo json_encode(['status' => 'ok', 'data' => $result]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Oyuncu bulunamadı']);
        }
        break;

    case 'leaderboard':
        $results = $db->query('SELECT u.username, p.gold, p.level FROM users u JOIN player_data p ON u.uid=p.uid ORDER BY p.gold DESC LIMIT 10');
        $list = [];
        while($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $list[] = $row;
        }
        echo json_encode(['status' => 'ok', 'data' => $list]);
        break;

    default:
        echo json_encode(['status' => 'ok', 'msg' => 'Empire Defense API v1.0', 'endpoints' => ['register', 'login', 'save', 'load', 'leaderboard']]);
        break;
}

$db->close();
