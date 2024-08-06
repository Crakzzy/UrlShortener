<?php

use Shortener\Shortener;

include_once '../vendor/autoload.php';

$shortener = new Shortener();

$uri = trim($_SERVER['REQUEST_URI'], '/');

if (empty($uri)) {
    include_once 'create.php';
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h1>" . $shortener->createNewEntry($_POST['base_url']) . "<h1>";
} else {
    $shortener->redirect();
}

