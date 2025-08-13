<?php
// script pour gerer les articles 
include_once './includes/auth.php';
include_once './includes/db.php';

if (is_authenticated()) {
    $is_admin = true;
}

if (!empty($_GET["id"])) {
    $stmt = $pdo->prepare('SELECT a.*, u.username FROM article AS a JOIN user AS U ON a.author_id = u.id where a.id=:id');
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch();
} else {
    $stmt = $pdo->prepare('SELECT a.*, u.username FROM article AS a JOIN user AS U ON a.author_id = u.id ');
    $stmt->execute();
    $articles = $stmt->fetchAll();
}

include_once "./templates/header.php";

if (isset($article) && !empty($article)) {
?>


<div class="container">
    <article class="d-md-flex gap-4 mb-5 p-3 border rounded">
        <div class="flex-shrink-0 mb-3 mb-md-0 " style="max-width: 450px; min-width: 300px;">
            <img class="img-fluid rounded shadow-sm" 
                 src="./uploads/images/<?= $article['img_url'] ?>" 
                 alt="Photo de l'article"
                 style="object-fit: cover; height: 100%; max-height: 300px;">
        </div>
  
        <div class="flex-grow-1">
            <h2 class="mb-3"><?= $article['title'] ?></h2>
            <div class="mb-4 text-justify">
                <?= $article['content'] ?>
            </div>
            

            <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-top">
                <p class="mb-0 text-muted">Auteur : <?= $article['username'] ?></p>
                <p class="mb-0 text-muted">Publié le : <?= date('d/m/Y', strtotime($article['created_at'])) ?></p>
            </div>
        </div>
    </article>
</div>

<?php
} elseif (isset($_GET["id"]) && empty($article)) {
?>

    <div class="d-flex justify-content-center m-auto">
        <img src="./uploads/images/404.webp ?>" alt="404 NOT FOUND">

    </div>

<?php } else {
    include './templates/article_card.php'; ?>

    <div class="container-fluid">

        <div class="row g-4 justify-content-center">

            <? foreach ($articles as $article) { ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <?= card($article); ?>
                </div>
            <? }; ?>
        </div>
    </div>

<? }
include_once './templates/footer.php'; ?>