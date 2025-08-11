<!-- edition d'article -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../includes/db.php";
require_once '../includes/auth.php';
require_auth();


if ($_POST) {
    $error = [];
    // test du titre

    $title = strip_tags(trim($_POST['title']));
    if ($title === '' || strlen($title) < 3) {
        $error['title'] = 'Titre vide ou trop court';
    }
    // test du contenu 
    $content = strip_tags(trim($_POST['content'] ?? ''));
    if ($content === '' || strlen($_POST['content'] < 200)) {
        $error['content'] = 'Minimum 200 character';
    };




    if (!$error) {

        // tester l'image 
        if (!isset($_FILES['picture']) || $_FILES['picture']['error'] !== UPLOAD_ERR_OK);

        $maxSize = 2 * 1024 * 1024; // 2mo maximum

        if ($_FILES['picture']['size'] > $maxSize) {
            $error['picture'] = 'Votre fichier est trop gros';
        }
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/webp', 'image/png'];
        $imageType = $_FILES['picture']['type'];
        $detectedType = $_FILES['picture']['type'];
        if (!in_array($detectedType, $allowedTypes)) {
            $error['picture'] = "Type d'extension non autorisé";
        }
    }

    if (!$error) {
        $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
        $newName = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['picture']['tmp_name'], 'C:\MAMP\htdocs\blog\uploads\images/' . $newName);
    };

    if (validateAuthToken($_SESSION['auth_token'])) {
        $stmt = $pdo->prepare('INSERT INTO article (title, content, img_url, author_id) VALUES (:title, :content, :img_url, :author_id) ');
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':img_url', $newName, PDO::PARAM_STR);
        $stmt->bindParam(':author_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        header('Location: ../article.php');
    };
}

include_once '../templates/header.php'
?>

<div class="container d-flex justify-content-center m-5">
    <h3>CREATION D'ARTICLE</h3>
</div>


<form action="" class="container m-auto" method="post" enctype="multipart/form-data">
    

        
            <div class="input-group mb-3 col-sm-3">
                <span class="input-group-text" id="inputGroup-sizing-default">titre de l'article</span>
                <input type="text" class="form-control" name="title" id="title" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                <?php if (isset($error['title'])) {
                    echo "<p style=color:red>" . $error['title'] . "</p>";
                } ?>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text">Corps de l'article</span>
                <textarea class="form-control" name="content" id="content" aria-label="Corps de l'article"></textarea>
                <?php if (isset($error['content'])) {
                    echo "<p style=color:red>" . $error['content'] . "</p>";
                } ?>
            </div>

            <div class="input-group mb-3">
                <label class="input-group-text" for="picture">Photo de l'article</label>
                <input type="file" class="form-control" name="picture" id="picture">
            </div>


            <?php if (isset($error['picture'])) {
                echo "<p style=color:red>" . $error['picture'] . "</p>";
            } ?>

            <div class="row justify-content-center">
                <input type="submit" class="btn btn-primary col" value="Envoyer">
            </div>
   

</form>


<?php include_once '../templates/footer.php' ?>
<!-- utiliser le javascript pour recuperer les post du title et du contenu si il y a un probleme avec la photo  -->