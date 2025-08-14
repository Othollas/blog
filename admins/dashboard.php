<!-- tableau de bord Admin (liste + action) -->

<!-- Toujours en premier, tester si l'utilisateur est bien admin. sinon le rediriger -->

<?php

// script pour gerer les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../includes/auth.php"; // inclus l'accés au script d'authentification

require_auth();

// Si tu es ici c'est que tu es authentifié
include_once "../includes/db.php"; // inclus l'acces à la bdd

validateAuthToken($_SESSION['auth_token']);

include_once '../templates/header.php'
?>
<div class="border text-center p-5 m-5 rounded shadow" >


    <h2>Bienvenue dans le dashboard</h2>
    <p>Vous êtes connecté en tant qu'admin.</p>

    <nav class="d-grid gap-3 col-4 mx-auto ">
        <a class="btn btn-outline-primary" href="../article.php">Gérer les articles</a>
        <a class="btn btn-outline-success" href="./create.php">Ecrire un article</a>
        <a class="btn btn-danger" href="?logout">Déconnexion</a>
    </nav>
</div>
<?php

if (isset($_GET['logout'])) {
    include_once '../logout.php';
    logout();
    header('Location: ../');
    exit();
}


include_once "../templates/footer.php";
?>