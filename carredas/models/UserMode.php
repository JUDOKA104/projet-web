<?php
require_once '../config/bdd_users.php';
require_once '../config/bdd_admins.php';

class UserModel
{
    public static function createUser($pseudo, $email, $password, $address, $phone_number)
    {
        try {
            $pdo = UserDatabase::getConnection();
            $stmt = $pdo->prepare("INSERT INTO users (pseudo, email, password, address, phone_number) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$pseudo, $email, $password, $address, $phone_number]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    public static function authenticateUser($identifier, $password)
    {
        try {
            // Première tentative : Vérification si c'est un administrateur
            $admin = self::authenticateAdmin($identifier, $password);
            if ($admin) {
                $admin['is_admin'] = true; // Marquer comme administrateur
                return $admin;
            }

            // Si ce n'est pas un administrateur, on cherche dans la table des utilisateurs
            return self::authenticateNormalUser($identifier, $password);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'authentification : " . $e->getMessage());
            return null;
        }
    }

    // Authentification des administrateurs
    private static function authenticateAdmin($identifier, $password)
    {
        try {
            $pdo = AdminDatabase::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ? OR pseudo = ?");
            $stmt->execute([$identifier, $identifier]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe pour l'administrateur
            if ($admin && password_verify($password, $admin['password'])) {
                return $admin;
            }

            return null; // Aucun administrateur trouvé ou mot de passe incorrect
        } catch (PDOException $e) {
            error_log("Erreur lors de l'authentification de l'administrateur : " . $e->getMessage());
            return null;
        }
    }

    // Authentification des utilisateurs classiques
    private static function authenticateNormalUser($identifier, $password)
    {
        try {
            $pdo = UserDatabase::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR pseudo = ?");
            $stmt->execute([$identifier, $identifier]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe pour l'utilisateur classique
            if ($user && password_verify($password, $user['password'])) {
                $user['is_admin'] = false; // Marquer comme utilisateur normal
                return $user;
            }

            return null; // Aucun utilisateur trouvé ou mot de passe incorrect
        } catch (PDOException $e) {
            error_log("Erreur lors de l'authentification de l'utilisateur : " . $e->getMessage());
            return null;
        }
    }
}
?>