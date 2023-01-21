<?php
 // Inclusion du header
 require('inc/header.php');
 require('functions.php');

    if(!isset($_SESSION['user'])){
        header('Location: login.php', true);
        die();
    }

    // construction du chemin de notre fichier donnees
    $chemin = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'donnee';

    // Recuperation du message saisi par le user
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
        // Construction de notre shema de donnee
        $message = [
            "user_id" => $user->id,
            "message" => htmlspecialchars(trim($_POST['message'])),
            "date" => date('d/m/Y G:i:s'),
            "groupe_id" => $_SESSION['groupe_id']
        ];
        
        creer_message($message);
    }

    // Recuperation des donnees enregistrer dans le fichier
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_id'])) {
        $messages = recurer_message_by_users($user->id, $_GET['user_id']);

        $_SESSION['groupe_id'] = groupe_by_users($user->id, $_GET['user_id'])->groupe_id;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['user_id'])) {
        $messages = recurer_message_by_users($user->id, $_GET['user_id']);
    }


    

    $users = recurer_users($user->id);
?>


    <div class="container row m-auto w-50 mt-3 bg-white shadow-sm p-0 mb-5 bg-body-tertiary rounded">
        <div class="col-3 mh-100 overflow-y-scroll bg-info">
            <h5 class="text-center mt-2">Utilisateurs</h5>
            <?php foreach($users as $usr): ?>
                <a href="http://localhost/test/?user_id=<?= $usr->id ?>"><?= $usr->prenom ?> <?= $usr->nom ?></a>
            <?php endforeach ?>
        </div>
        <div class="col-9 p-3">
            <?php if (isset($messages)): ?>
                <div class="mh-500 overflow-y-scroll">
                    <?php foreach($messages as $msg): ?>
                        <div <?php if($msg->user_id == $user->id): ?>class="text-end" <?php endif ?> >
                            <span class="badge<?php if($msg->user_id == $user->id): ?> text-bg-primary<?php else: ?> text-bg-secondary<?php endif ?>"><?= $msg->message ?></span>
                                <span class="text-body-secondary"><?= $msg->date ?></span>
                        </div>
                    <?php endforeach ?>
                </div>
                <form class="mt-4" action="" method="post">
                    <div class="row g-1 align-items-center">
                        <div class="col-10">
                            <input type="text" name="message" id="message" class="form-control">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <div>
                    <h2>Bienvenu sur ChAT APP</h2>
                    <p>Clicker sur un utilisateur pour commencer la conversation</p>
                </div>
            <?php endif ?>
        </div>
        
    </div>
<?php

// Inclusion du footer
require('inc/footer.php') ?>
