<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>

<h1>Bienvenue, <?= htmlspecialchars($user['pseudo']) ?></h1>
<p>Email : <?= htmlspecialchars($user['email']) ?></p>
<p>Adresse : <?= htmlspecialchars($user['address']) ?></p>
<p>Téléphone : <?= htmlspecialchars($user['phone_number']) ?></p>

<?php if ($user['is_admin']): ?>
<p>Statut : Administrateur</p>
<?php else: ?>
<p>Statut : Utilisateur</p>
<?php endif; ?>

<a href="/../index.php">Se déconnecter</a>