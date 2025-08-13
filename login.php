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

    
    if ($admin['email'] === $username && password_verify($password, $admin['password'])) {

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

<div class="container text-center vh-100 border">
    <h3 class="m-5">LOGIN</h3>

    <form action="./login.php" method="post" class="container">

        <div class="input-group mb-5 col-xl-3">
            <span class="input-group-text p-4" id="inputGroup-sizing-default">Entre ton pseudo</span>

            <input type="text" class="form-control" name="username" id="username" autocomplete="false" required aria-label="user input" aria-describedby="inputGroup-sizing-default">

        </div>

        <div class="input-group mb-5 col-sm-3 ">
            <span class="input-group-text p-4" id="inputGroup-sizing-default">Rentre ton mot de passe</span>
            <input type="password" name="password" id="password" autocomplete="false" required class="form-control" aria-label="password input" aria-describedby="inputGroup-sizing-default">
        </div>


        <?php

        echo $error_empty ? '<p class="text-danger">Vous devez entré un pseudo/password </p>' : null;
        echo $error_form ?  '<p class="text-danger"> Erreur email/password </p>' : null;
        ?>

        <button class="btn btn-primary w-100 p-4 mb-5" type="submit">Envoyer</button>


    </form>
</div>

<?php include_once './templates/footer.php' ?>