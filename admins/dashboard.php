<!-- tableau de bord Admin (liste + action) -->

 <!-- Toujours en premier, tester si l'utilisateur est bien admin. sinon le rediriger -->
 <?php

include_once "../includes/db.php"; // inclus l'acces à la bdd
include_once "../includes/auth.php"; // inclus l'accés au script d'authentification

require_auth();


// Si tu es ici c'est que tu es authentifié 
include_once '../templates/header.php'
?>

<h1>Bienvenue dans le dashboard</h1>
<p>Vous etes connecter en tant qu'admin.</p>

<nav>
    <a href="../article.php">Gérer les articles</a>
    <a href="./create.php">Ecrire un article</a>
    <a href="?logout">Déconnexion</a>
</nav>

<?php 
if(isset($_GET['logout'])){
    include_once '../logout.php';
    logout();
    header('Location: ../');
    exit();
}
?>