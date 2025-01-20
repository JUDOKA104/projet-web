<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'models/UserAdmin.php';

    // Récupération et sécurisation des entrées
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Utilisation de bcrypt pour le hachage
    $address = htmlspecialchars($_POST['address']);
    $phone_number = htmlspecialchars($_POST['phone_number']);

    // Création de l'administrateur
    if (UserAdmin::createAdmin($pseudo, $email, $password, $address, $phone_number)) {
        echo "<p>Administrateur créé avec succès. <a href='login.php'>Connectez-vous</a>.</p>";
    } else {
        echo "<p>Erreur lors de la création de l'administrateur. Veuillez réessayer.</p>";
    }
}
?>

<form method="POST">
    <input type="text" name="pseudo" placeholder="Pseudo" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <input type="text" name="address" placeholder="Adresse" required>
    <input type="text" name="phone_number" placeholder="Numéro de téléphone" required>
    <button type="submit">Créer Administrateur</button>
</form>