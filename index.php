<? 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "./templates/header.php";
include "./includes/db.php";



?>

<main>
    <h1>HELLO WORLD</h1>
</main>


<? 
$stmt = $pdo->prepare("SELECT * FROM article");
$stmt->execute();
$articles = $stmt->fetchAll();

include './templates/article_card.php';


 ?>
<div style=" display:flex; flex-wrap:wrap; justify-content:center">
<?foreach ($articles as $article)  { ?>
    
   <?= card($article);  ?>
<? } ?>
 
 </div><?

include "./templates/footer.php"
?>