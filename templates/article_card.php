<!-- Squelette de la vignette / miniature de l'article  -->

<?php

include_once "./includes/auth.php";



function card(mixed $array): mixed
{
    global $is_admin;


    if ($is_admin) {

return "<div class='card h-100 shadow p-2 mb-2 rounded d-flex flex-column'>
            <a class='text-decoration-none text-dark flex-grow-1' href='article.php?id=" . $array["id"] . "'>
                <div class='card-body text-center d-flex flex-column h-100 justify-content-between'>
                    <h5 class='card-title'>" . $array['title'] . "</h5>
                    <div class='flex-grow-1 d-flex align-items-center justify-content-center py-2'>
                        <img class='img-fluid mh-100' style='max-height: 150px; object-fit: contain' src='./uploads/images/" . $array["img_url"] . "' alt=''>
                    </div>
                    <p class='mb-0 mt-auto'>Par : " . $array["username"] . "</p>
                </div>
            </a>
            <div class='card-footer bg-transparent border-0 py-2'>
                <div class='d-flex justify-content-around'>
                    <a class='btn btn-sm btn-outline-primary px-3' href='./admins/edit.php?id=" . $array["id"] . "'>Modifier</a>
                    <a class='btn btn-sm btn-outline-danger px-3' href='./admins/delete.php?id=" . $array["id"] . "'>Effacer</a>
                </div>
            </div>
        </div>";
    } else {
        return "<div class='card h-100 shadow p-2 mb-2 rounded'>
                    <a class='text-decoration-none text-dark h-100 d-block' href=article.php?id=" . $array["id"] . " >
                        <div class='card-body text-center d-flex flex-column h-100 justify-content-between'>
                            <h5 class='card-title'>" . $array['title'] . "</h5>
                            <img class='card-img-top img-fluid'  src='./uploads/images/" . $array["img_url"] . "'  alt=''>
                            <p class='mb-2'>Par : " . $array["username"] . "</p>
                        </div>
                    </a>
                </div>";
    }
}





function card_test(mixed $array): string
{
    return "<p>" . $array['title'] . "</p>";
}

?>