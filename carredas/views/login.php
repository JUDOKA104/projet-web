<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../models/UserAdmin.php'; // On inclut la classe UserAdmin
    require_once '../models/UserMode.php';  // On inclut la classe UserModel

    $identifier = htmlspecialchars($_POST['identifier']); // Peut être pseudo ou email
    $password = $_POST['password'];

    // Tentative de connexion en tant qu'administrateur
    $admin = UserAdmin::authenticateAdmin($identifier, $password);

    if ($admin) {
        // Si l'utilisateur est un administrateur, on démarre la session pour un admin
        session_start();
        $_SESSION['user'] = [
            'id' => $admin['id'],
            'pseudo' => htmlspecialchars($admin['pseudo']),
            'email' => htmlspecialchars($admin['email']),
            'address' => htmlspecialchars($admin['address']),
            'phone_number' => htmlspecialchars($admin['phone_number']),
            'is_admin' => true, // On marque l'utilisateur comme administrateur
        ];
        header('Location: profile.php');
        exit;
    } else {
        // Si l'utilisateur n'est pas un administrateur, on tente avec les utilisateurs classiques
        $user = UserModel::authenticateUser($identifier, $password);

        if ($user) {
            // Si l'utilisateur classique est trouvé et l'authentification réussit
            session_start();
            $_SESSION['user'] = [
                'id' => $user['id'],
                'pseudo' => htmlspecialchars($user['pseudo']),
                'email' => htmlspecialchars($user['email']),
                'address' => htmlspecialchars($user['address']),
                'phone_number' => htmlspecialchars($user['phone_number']),
                'is_admin' => false, // Marquer comme utilisateur normal
            ];
            header('Location: profile.php');
            exit;
        } else {
            // Si l'utilisateur n'est ni admin, ni utilisateur valide
            echo "<p>Identifiants incorrects. Veuillez réessayer.</p>";
        }
    }
}
?>

<form method="POST">
    <input type="text" name="identifier" placeholder="Pseudo ou Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>