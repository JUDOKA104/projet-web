<?php
if (!is_dir(__DIR__ . '/data')) {
    mkdir(__DIR__ . '/data', 0777, true);
}

require_once 'config/bdd.php';

try {
    $pdo = Database::getConnection();

    $sql = "CREATE TABLE IF NOT EXISTS reservations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_name TEXT NOT NULL,
        email TEXT NOT NULL,
        concert_date TEXT NOT NULL,
        concert_time TEXT NOT NULL
    );";

    $pdo->exec($sql);
    echo "Database initialized successfully in the 'data' folder!";
} catch (Exception $e) {
    echo "Error initializing database: " . $e->getMessage();
}