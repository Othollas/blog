<!-- Squelette de la vignette / miniature de l'article  -->

<?php

include_once "./includes/auth.php";



function card(mixed $array): mixed
{
    global $is_admin;


 


    if ($is_admin) {

   return "<div class='group-card'>
    <article class='' style='margin:1rem; border:1px, solid, black; height:300px; width:250px; text-align:center'>
        <a class='' href=article.php?id=" . $array["id"] . ">
            <div class=''>
                <img style='width:200px; height:200px; background-color:black' src='./uploads/images/" .  $array["img_url"] . "'  alt=''>
            </div>
            <div class=''>

                <p style='text-align:center;width:200px; background-color:black'>" . $array['title'] . "</p>
                <div class=''>
                    <p>Par : " . $array["author_id"] . "</p>
                </div>
                     <nav><a href='./admins/edit.php?id=" . $array["id"] . "'>Modifier</a></nav>
                    <nav><a href='./admins/delete.php?id=" . $array["id"] . "'>Effacer</a></nav>
            </div>
        </a>
    </article>
</div>";

    } else {
        return "<div class='group-card'>
    <article class='' style='margin:1rem; border:1px, solid, black; height:300px; width:250px; text-align:center'>
        <a class='' href=article.php?id=" . $array["id"] . ">
            <div class=''>
                <img style='width:200px; height:200px; background-color:black' src='./uploads/images/" .  $array["img_url"] . "'  alt=''>
            </div>
            <div class=''>

                <p style='text-align:center;width:200px; background-color:black'>" . $array['title'] . "</p>
                <div class=''>
                    <p>Par : " . $array["author_id"] . "</p>
                   
                </div>
                    
            </div>
        </a>
    </article>
</div>";
    }
}



function card_test(mixed $array): string
{
    return "<p>" . $array['title'] . "</p>";
}

?>