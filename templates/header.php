<?php ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Body</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
      <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" 
  />
</head>

<body>

    <header class="mb-5 shadow ">
        <nav class="navbar navbar-expand-lg navbar-light bg-light p-5">
            <div class="container-fluid">

                <?php
                if (str_contains($_SERVER['REQUEST_URI'], "admins")) { ?>
                    <a class="navbar-brand fs-1" href="../">Blog & Fun</a>
                <?php } else { ?>
                    <a class="navbar-brand fs-1" href="./">Blog & Fun</a>
                <?php
                }
                ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <?php
                            if (str_contains($_SERVER['REQUEST_URI'], "admins")) { ?>
                                <a class="nav-link fs-4" href="../article.php">Articles</a>
                            <?php } else { ?>
                                <a class="nav-link fs-4" href="./article.php">Articles</a>
                            <?php
                            }
                            ?>
                        </li>
                        <li class="nav-item">
                            <?php
                            if (str_contains($_SERVER['REQUEST_URI'], "admins")) { ?>
                                <a class="nav-link fs-4" href="../login.php">Login</a>
                            <?php } else { ?>
                                <a class="nav-link fs-4" href="./login.php">Login</a>
                            <?php
                            }
                            ?>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-4" href="#">Lien</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </header>