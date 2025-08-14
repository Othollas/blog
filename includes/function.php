<!-- fonction importante qui reviennent dans le code, redirect(), is_admin(),  -->

<?php





// Déconnexion

function logout(){
    unset($_SESSION['auth']);
    session_destroy();
};


?>