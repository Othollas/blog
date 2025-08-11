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
        <div class="my-5">
            <h5><?= $article['title'] ?></h5>
            <img class="image-fluid" src="./uploads/images/<?= $article['img_url'] ?>" alt="Photo de l'article">
            <div class="">

                <p><?= $article['content'] ?></p>
                <div class="d-flex">
                    <p class="m-2">Par : <?= $article['username'] ?></p>
                    <p class="m-2">Crée le : <?= $article['created_at'] ?></p>
                </div>
            </div>
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