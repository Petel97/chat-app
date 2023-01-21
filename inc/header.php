<?php  
    // Demarer une session
    session_start();
    if(isset($_SESSION['user'])){
        $user = json_decode($_SESSION['user']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHAT APP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        .mh-500 {
            max-height: 400px;
            min-height: 300px;
            height: 80%;
        }
        .mh-100 {
            min-height: 395px;
            height: 100%;
        }
        .badge {
            font-size: 14px;
            font-weight: normal;
        }
        .text-body-secondary {
            display: block;
            font-size: 9px;
        }
    </style>
    
</head>
<body class="bg-primary">
    <nav class="navbar navbar-expand-lg bg-primary w-50 m-auto" data-bs-theme="dark">
        <div class="container-fluid<?php if(!isset($user)):  ?> justify-content-center<?php endif ?>">
            <a class="navbar-brand" href="#">CHAT APP</a>
            <?php if(isset($user)):  ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                
            </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $user->username ?>
                </a>
                <ul class="dropdown-menu">
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="deconnexion.php">Deconnexion</a></li>
                </ul>
                </li>

                </ul>
                
            </div>
            <?php endif ?>
        </div>
    </nav>
