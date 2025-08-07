<!-- script qui permet de se login grace à une auth depuis un formulaire  -->
<?php
// script pour gerer les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
// j'inclus la page auth.php
include_once './includes/auth.php';

if (is_authenticated()) {
    header('Location: ./admins/dashboard.php');
    exit();
}


$error_form = false;
$error_empty = false;

// on recuper les post si il y a 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // tester les posts 


    // si un malin enleve le required dans le html alors on teste !!
    if ($_POST['username'] === '' || $_POST['password'] === '') {
        $error_empty = true;
        exit();
    }

    // récuperer les post et les nettoyer;
    $username = strip_tags(trim($_POST['username']));
    $password = strip_tags(trim($_POST['password']));
    require_once './includes/db.php';
    
    // recuperer le mail et le username
    $stmt = $pdo->prepare("SELECT id, email, password FROM USER where is_admin = true");
    $stmt->execute();
    $admin = $stmt->fetch(); // Si plusieurs admins mettre fetchAll()

    if ($admin['email'] === $username && $admin['password'] === $password) {




        if (authenticate($username, $password)) {
             $_SESSION['auth_token'] = generateAuthToken($admin['id']);
             $_SESSION['user_id'] = $admin['id'];
            header('Location: ./admins/dashboard.php');
        };
    }


    echo ('<p>est ce que tu passes le nom? : ' . ($admin['email'] === $username ? 'tu passes' : 'tu passes pas' && $error_form = true) . '</p>');
    echo ('<p>est ce que tu passes le password? : ' . ($admin['password'] === $password ? 'tu passes' : 'tu passes pas' && $error_form = true) . '</p>');
}


include_once './templates/header.php';
?>


<form action="./login.php" method="post">

    <div class="form-group">
        <label for="username">Entre ton pseudo</label>
        <input type="text" name="username" id="username" autocomplete="false" required>

    </div>

    <div class="form-group">
        <label for="password">Rentre ton mot de passe</label><input type="password" name="password" id="password" autocomplete="false" required>
    </div>
    <?php

    echo $error_empty ? '<p style="color:red">Vous devez entré un pseudo/password </p>' : null;
    echo $error_form ?  '<p style="color:red"> Erreur email/password </p>' : null;
    ?>
    <div class="form-btn">
        <button type="submit">Envoyer</button>
    </div>

</form>

<?php include_once './templates/footer.php' ?>