<?php
// Inclusion du header
require('inc/header.php');

// Recuperation du nom de l'utilisateur saisi par le user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    // Construction de notre shema de donnee
    $username = htmlspecialchars(trim($_POST['username']));

    var_dump($username);
    
    // Enregistrement du nom dans une session
    $_SESSION['username'] = $username;

    // Redirection vers la page du chat
    header('Location: index.php', true);
    die();
}

?>
<div class="container w-25 mt-3 bg-white shadow-sm p-3 mb-5 bg-body-tertiary rounded">
    <form class="mt-4" action="" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Nom d'Utilisateur</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="nom d'utilisateur">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Connexion</button>
        </div>
    </form>
</div>

<?php

// Inclusion du footer
require('inc/footer.php') ?>