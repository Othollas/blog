<!-- script qui permet de se deconnecter, grace à un session destroy -->

<?php 
    function logout(){
        unset($_SESSION['auth_token']);
        unset($_SESSION["user_id"]);
        session_destroy();
    };
?>