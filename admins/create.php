<!-- edition d'article -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../includes/db.php";
require_once '../includes/auth.php';
require_auth();

var_dump($_POST);

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

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">titre de l'article</label>
        <input type="text" name="title" id="title">
        <?php if (isset($error['title'])) {
            echo "<p style=color:red>" . $error['title'] . "</p>";
        } ?>
    </div>

    <div class="form-group">
        <label for="content">Corps de l'article</label>
        <textarea name="content" id="content" cols="30" rows="10"></textarea>
        <?php if (isset($error['content'])) {
            echo "<p style=color:red>" . $error['content'] . "</p>";
        } ?>
    </div>

    <div class="form-group">
        <label for="picture" class="block">Ajout de la photo de l'article</label>
        <input type="file" name="picture" id="picture" class="btn btn-secondary">
    </div>

    <?php if (isset($error['picture'])) {
        echo "<p style=color:red>" . $error['picture'] . "</p>";
    } ?>

    <div class="form-btn">
        <input type="submit" class="btn btn-primary" value="Envoyer">
    </div>

</form>


<?php include_once '../templates/footer.php' ?>
<!-- utiliser le javascript pour recuperer les post du title et du contenu si il y a un probleme avec la photo  -->