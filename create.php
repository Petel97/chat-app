<?php
// Inclusion du header
require('inc/header.php');
require('functions.php');

// Recuperation du message saisi par le user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['username']) && isset($_POST['password']) ) {
    // Construction de notre shema de donnee
    $user = [
        "prenom" => $_POST['prenom'],
        "nom" => $_POST['nom'],
        "username" => $_POST['username'],
        "password" => hash('ripemd160', $_POST['password'])
    ];

    ajouter_utilisateur($user);

    header('Location: login.php', true);
    die();
}

?>
<div class="container w-25 mt-3 bg-white shadow-sm p-3 mb-5 bg-body-tertiary rounded">
    <form class="mt-4" action="" method="post">
        <div class="mb-3">
            <label for="prenom" class="form-label">Prenom</label>
            <input type="text" name="prenom" class="form-control" id="prenom" placeholder="prenom de l'utilisateur">
        </div>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" id="nom" placeholder="nom de l'utilisateur">
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Nom d'Utilisateur</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="nom de l'utilisateur">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="mot de passe de l'utilisateur">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Creer</button>
        </div>
        <div class="mb-3">
            <a href="http://localhost/test/login.php">Connexion</a>
        </div>
    </form>
</div>

<?php

// Inclusion du footer
require('inc/footer.php') ?>