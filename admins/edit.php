<!-- Page de modification d'article -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../includes/db.php";
require_once '../includes/auth.php';

require_auth();

// recuperation de l'id dans le get 
$id = (int)$_GET['id'];

if (is_authenticated()) {
    $stmt = $pdo->prepare("SELECT title, content, img_url FROM article WHERE id=:id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch();


    if (!$_POST) {

        // recuperation de l'article dans la bdd et remplissage des champs quand le champs est poster (permet de garder en memoire les modification de texte si il y a des erreurs)
        $anciennePhoto = htmlspecialchars($data['img_url'] ?? '');
        $titlePropre = htmlspecialchars($data['title'] ?? '');
        $contenuPropre = htmlspecialchars($data['content'] ?? '');
    }
}

if ($_POST) {

    $error = [];


    // test du titre
    $title = strip_tags(trim($_POST['title']));
    if ($title === '' || strlen($title) < 3) {
        $error['title'] = 'Titre vide ou trop court';
    }

    // remise du titre dans le champ
    $titlePropre = htmlspecialchars($_POST['title'] ?? '');


    // test du contenu 
    $content = strip_tags(trim($_POST['content']));
    if (strlen($_POST['content']) < 200) {
        $error['content'] = 'Minimum 200 character';
    };

    // remise du contenu dans le champ
    $contenuPropre = htmlspecialchars($_POST['content'] ?? '');

    
    // Test si l'utilisateur veut uploader une image 
    if ($_FILES['picture']['name'] !== '' && !$error) {
      
        // tester la nouvelle image 
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



        if (!$error) {





            // destruction de l'ancienne image
            $anciennePhoto = htmlspecialchars($data['img_url'] ?? '');
            $file = "C:\MAMP\htdocs\blog\uploads\images/". $anciennePhoto;
            

            if (file_exists($file)) {
                unlink($file);
            }

            // redirection de l'image envoyer depuis le post file 
            $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            $newName = uniqid() . "." . $ext;
            move_uploaded_file($_FILES['picture']['tmp_name'], 'C:\MAMP\htdocs\blog\uploads\images/' . $newName);

            $stmt = $pdo->prepare("UPDATE article SET title=:title, content=:content, img_url=:img_url  WHERE id=:id");
            $stmt->bindParam(":title", $titlePropre, PDO::PARAM_STR);
            $stmt->bindParam(":content", $contenuPropre, PDO::PARAM_STR);
            $stmt->bindParam(":img_url", $newName, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                header('Location: ../article.php');
            }
        }
    } else {

        if (!$error) {
            var_dump("avant", $stmt->rowCount() > 0);
            $stmt = $pdo->prepare("UPDATE article SET title=:title, content=:content  WHERE id=:id");
            $stmt->bindParam(":title", $titlePropre, PDO::PARAM_STR);
            $stmt->bindParam(":content", $contenuPropre, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            var_dump("aprés", $stmt->rowCount());
            if ($stmt->rowCount() > 0) {

                header('Location: ../article.php');
            }
        }
    }
}












// tester si lla photo à changer ou non, si oui supprimer le fichier dans le dossier + changer le nom dans la base de donnée / sino laisser tel quel 



// vérifier avec le token avant d'envoyer en bdd 


// message de confirmation d'envois/ modification ou erreur 


// redirection
?>
<!-- 3. Affichage dans le formulaire -->
<form action="" method="post" enctype="multipart/form-data" style="display:flex; align-items:center; justify-content:center; flex-direction:column; width:100vw">

    <div class="form-group" style="margin:1rem">
        <label style="display:block; text-align:center; margin-bottom:10px" for="title">titre de l'article</label>
        <input style="display:block; text-align:center; margin-bottom:10px" type="text" name="title" id="title" value='<?= nl2br($titlePropre) ?>'>
        <?php if (isset($error['title'])) {
            echo "<p style=color:red>" . $error['title'] . "</p>";
        } ?>
    </div>

    <div class="form-group" style="margin:1rem">
        <label style="display:block; text-align:center; margin-bottom:10px" for="content">Corps de l'article</label>


        <textarea style="display:block; margin-bottom:10px" name="content" id="content" cols="60" rows="20"><?= nl2br($contenuPropre) ?></textarea>
        <?php if (isset($error['content'])) {
            echo "<p style=color:red>" . $error['content'] . "</p>";
        } ?>
    </div>

    <div class="form-group" style="margin:1rem">
        <label for="picture">Ajout de la photo de l'article</label>
        <input type="file" name="picture" id="picture">
    </div>

    <?php if (isset($error['picture'])) {
        echo "<p style=color:red>" . $error['picture'] . "</p>";
    } ?>

    <div class="form-btn">
        <input type="submit" value="Envoyer">
    </div>

</form>