<?php
session_start();

$_SESSION['username'] = null;
unset($_SESSION['username']);

var_dump($_SESSION);

session_destroy();

header('Location: index.php', true);