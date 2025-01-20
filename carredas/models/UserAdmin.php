<?php
require_once '../config/bdd_admins.php';

class UserAdmin
{
    // Crée un nouvel administrateur
    public static function createAdmin($pseudo, $email, $password, $address, $phone_number)
    {
        try {
            // Connexion à la base de données des admins
            $pdo = AdminDatabase::getConnection();

            // Vérification de la connexion
            if (!$pdo) {
                error_log("Connexion à la base de données échouée.");
                return false;
            } else {
                error_log("Connexion réussie à la base de données.");
            }

            // Vérification si l'admin existe déjà
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE email = ? OR pseudo = ?");
            $stmt->execute([$email, $pseudo]);
            $exists = $stmt->fetchColumn();
            error_log("Résultat de la vérification d'existence: $exists");

            if ($exists) {
                return false; // L'admin existe déjà
            }

            // Insertion de l'admin dans la base de données
            $stmt = $pdo->prepare("INSERT INTO admins (pseudo, email, password, address, phone_number) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt->execute([$pseudo, $email, $password, $address, $phone_number])) {
                error_log("Erreur SQL lors de l'insertion de l'administrateur : " . implode(" - ", $stmt->errorInfo()));
                return false;
            }

            error_log("Insertion de l'administrateur réussie.");
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la création de l'administrateur : " . $e->getMessage());
            return false;
        }
    }

    // Authentifie un administrateur
    public static function authenticateAdmin($identifier, $password)
    {
        try {
            // Connexion à la base de données des admins
            $pdo = AdminDatabase::getConnection();
            // Préparer la requête pour retrouver un administrateur par email ou pseudo
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ? OR pseudo = ?");
            $stmt->execute([$identifier, $identifier]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si un administrateur est trouvé, vérifier le mot de passe
            if ($admin && password_verify($password, $admin['password'])) {
                return $admin;
            }

            return null; // Si aucun administrateur valide
        } catch (PDOException $e) {
            error_log("Erreur lors de l'authentification de l'administrateur : " . $e->getMessage());
            return null;
        }
    }
}
?>