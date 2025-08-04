<?php 
require_once "./db.php";

if(!isset($_POST["user"]) && !isset($_POST["password"])){
    header('Location: ../');
}

$stmt = $pdo->prepare("SELECT * FROM USER where is_admin = true");
$stmt->execute();
$admin = $stmt->fetch();



?>