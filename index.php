<? 
include "./templates/header.php";
include "./includes/db.php";
?>

<main>
    <h1>HELLO WORLD</h1>

</main>


<? 
$stmt = $pdo->prepare("SELECT * FROM user ");
$stmt->execute();
$utilisateur = $stmt->fetchAll();

if ($utilisateur) {
    var_dump($utilisateur);
} else {
    echo "Utilisateur non trouvé.";
}

?>




<?
include "./templates/footer.php"
?>