<?php
 // Inclusion du header
 require('inc/header.php');

    if(!isset($_SESSION['username'])){
        header('Location: login.php', true);
        die();
    }

    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee';

    // Recuperation du message saisi par le user
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
        // Construction de notre shema de donnee
        if (file_exists($chemin)) {
            $message = "\n" .$_SESSION['username']."\t".htmlspecialchars(trim($_POST['message']))."\t".date('d/m/Y G:i:s');
        } else {
            $message = $_SESSION['username']."\t".htmlspecialchars(trim($_POST['message']))."\t".date('d/m/Y G:i:s');
        }

        // Enregistrement des donnee dans le fichier
        file_put_contents($chemin, $message, FILE_APPEND);
    }
    $donnees = [];
    // Recuperation des donnees enregistrer dans le fichier
    if (file_exists($chemin))
        $donnees = explode("\n", file_get_contents($chemin));

    setcookie('donnees', 'Test');

?>


    <div class="container w-50 mt-3 bg-white shadow-sm p-3 mb-5 bg-body-tertiary rounded">
        <div class="mh-500 overflow-y-scroll">
            <?php foreach($donnees as $msg): ?>
                <?php $msg = explode("\t", $msg) ?>
                <div <?php if($msg[0] == $_SESSION['username']): ?>class="text-end" <?php endif ?> >
                    <span class="badge<?php if($msg[0] == $_SESSION['username']): ?> text-bg-primary<?php else: ?> text-bg-secondary<?php endif ?>"><?= $msg[1] ?></span>
                        <span class="text-body-secondary"><?= $msg[2] ?></span>
                </div>
            <?php endforeach ?>
        </div>
        
        <form class="mt-4" action="" method="post">
            <div class="row g-3 align-items-center">
                <div class="col-10">
                    <input type="text" name="message" id="message" class="form-control">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </div>
        </form>
    </div>
<?php

// Inclusion du footer
require('inc/footer.php') ?>
