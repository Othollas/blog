<? 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "./templates/header.php";
include "./includes/db.php";


$stmt = $pdo->prepare("SELECT a.*, u.username FROM article AS a JOIN user AS u ON a.author_id = u.id ");
$stmt->execute();
$articles = $stmt->fetchAll();

include './templates/article_card.php';


 ?>
    <div class="container-fluid m-auto" style="min-width:350px">

        <div class=" row justify-content-center m-1 g-5">

            <? foreach ($articles as $article) { ?>
                <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                    <?= card($article); ?>
                </div>
            <? }; ?>
        </div>
    </div>
 
 <?
include "./templates/footer.php"
?>