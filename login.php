<?php
// Inclusion du header
require('inc/header.php');
require('functions.php');

$user = '';

// Recuperation du nom de l'utilisateur saisi par le user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    // Construction de notre shema de donnee
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    $user = connecter_utilisateur($username, $password);

    if($user['type'] == "Success") {
        $_SESSION['user'] = json_encode($user['user']);

        // Redirection vers la page du chat
        header('Location: index.php', true);
        die();
    }

}

?>
<div class="container w-25">
    <?php if ($user != '' && $user['type'] == "Erreur"): ?>
        <div class="alert alert-danger" role="alert">
            <?= $user['message'] ?>
        </div>
    <?php endif ?>
</div>
<div class="container w-25 mt-3 bg-white shadow-sm p-3 mb-5 bg-body-tertiary rounded">

    <form class="mt-4" action="" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Nom d'Utilisateur</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="nom de l'utilisateur">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="mot de passe de l'utilisateur">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Connexion</button>
        </div>

        <div class="mb-3">
            <a href="http://localhost/test/create.php">Creer un compte</a>
        </div>
    </form>
</div>

<?php

// Inclusion du footer
require('inc/footer.php') ?>