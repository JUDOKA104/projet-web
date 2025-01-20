<?php
class UserDatabase
{
    private static $pdo = null;

    public static function getConnection()
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO('sqlite:' . __DIR__ . '/../data/users.sqlite');
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}