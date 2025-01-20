<?php
if (!is_dir(__DIR__ . '/../data')) {
    mkdir(__DIR__ . '/../data', 0777, true);
}

require_once 'config/bdd_users.php';

try {
    $pdo = UserDatabase::getConnection();

    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pseudo TEXT NOT NULL,
        email TEXT NOT NULL,
        password TEXT NOT NULL,
        address TEXT NOT NULL,
        phone_number TEXT NOT NULL
    );";

    $pdo->exec($sql);
    echo "Users database initialized successfully in the 'data' folder!";
} catch (Exception $e) {
    echo "Error initializing users database: " . $e->getMessage();
}