<!-- page de suppression d'article  -->
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../includes/auth.php';
require_auth(); // Aprés ça tu es connecté en tant qu'admin


// tester si l'id est valide (sinon exit ou die)
if (!isset($_GET['id'])) {
        http_response_code(400);
        echo '<br><a href="./dashboard.php">Retourner à l\'acceuil<a><br>';
        die("ID manquant");
}

// initialisation de la bdd une fois les test effectuer 
include_once "../includes/db.php";
// Recupération de l'id dans le get
$id = (int)$_GET["id"];

$validate = false;

include_once '../templates/header.php';
?>



<?php

if (isset($_POST["oui"])) {
        validateAuthToken($_SESSION['auth_token']);
        $validate = true;
} elseif (isset($_POST["non"])) {
        header('Location: ../article.php');
} else { ?>



        <form action="" method="post">
                <p>Voulez vous vraiment Supprimer cet article ?</p>
                <input type="submit" value="oui" name="oui">
                <input type="submit" value="non" name="non">
        </form>

<?php }


// preparation de requete 
if ($validate) {
        $stmt = $pdo->prepare("DELETE FROM article WHERE id=:id ");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        die("<p>Tu as bien supprimer l'article ". $id ."</p> <a href='../article.php'>Retour aux articles</a>  ");
}



// execution de requete seulement si le token est verifier 


// vérification de la bonne suppression ou de lerreur


//redirection vers dasboard ou autre.
?>