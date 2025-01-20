<?php
if (!is_dir(__DIR__ . '/../data')) {
    mkdir(__DIR__ . '/../data', 0777, true);
}

require_once 'config/bdd_admins.php';

try {
    $pdo = AdminDatabase::getConnection();

    $sql = "CREATE TABLE IF NOT EXISTS admins (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pseudo TEXT NOT NULL UNIQUE,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        address TEXT,
        phone_number TEXT
    );";

    $pdo->exec($sql);

    echo "Admins database initialized successfully in the 'data' folder!";
} catch (Exception $e) {
    echo "Error initializing admins database: " . $e->getMessage();
}