<?php
// script pour gerer les articles 
include_once './includes/auth.php';
include_once './includes/db.php';

if (is_authenticated()){
    $is_admin = true;
}

if (!empty($_GET["id"])) {
    $stmt = $pdo->prepare('SELECT * FROM article where id=:id');
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch();
} else {
    $stmt = $pdo->prepare('SELECT * FROM article');
    $stmt->execute();
    $articles = $stmt->fetchAll();
}

include_once "./templates/header.php";

if (isset($article) && !empty($article)) {
?>
    <div class="group" style="display:flex;  width:1200px; justify-content:center; align-items:center; margin:auto">
        <img style="height:200px; width:200px; margin:2rem" src="./uploads/images/<?= $article['img_url'] ?>" alt="Photo de l'article">
        <div class="text-group">
            <h1><?= $article['title'] ?></h1>
            <p><?= $article['content'] ?></p>
        </div>
    </div>

<?php
} elseif (isset($_GET["id"]) && empty($article)) {
?>

    <div class="group" style="display:flex; justify-content:center; align-items:center; margin:auto">
        <img style=" margin:2rem" src="./uploads/images/404.webp ?>" alt="404 NOT FOUND">
        <div class="text-group">

        </div>
    </div>

<?php } else {
    include './templates/article_card.php'; ?>

    <div class="container d-flex flex-wrap gap-3 flex-sm-column">

        <? foreach ($articles as $article) { echo card($article); }; ?>

    </div>

<? }  include_once './templates/footer.php'; ?>