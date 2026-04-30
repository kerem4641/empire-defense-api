<?php
$db = new SQLite3('/data/data/com.termux/files/home/empire-api/game.db');

$db->exec('CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT,
    uid TEXT UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)');

$db->exec('CREATE TABLE IF NOT EXISTS player_data (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    uid TEXT UNIQUE,
    gold INTEGER DEFAULT 1000,
    crystal INTEGER DEFAULT 0,
    level INTEGER DEFAULT 1,
    heroes TEXT DEFAULT "[]",
    towers TEXT DEFAULT "[]",
    stages_completed TEXT DEFAULT "[]",
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
)');

echo "Database hazır!\n";
$db->close();
