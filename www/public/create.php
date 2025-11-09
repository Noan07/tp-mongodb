<?php

include_once '../init.php';

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use MongoDB\BSON\ObjectId;

$twig = getTwig();

if (!empty($_POST)) {
    $last = getTpCollection()->findOne([], ['sort' => ['objectid' => -1]]);
    $nextObjectId = isset($last->objectid) ? ((int)$last->objectid + 1) : 1;
    
    $document = [
        'titre' => $_POST['title'] ?: null,
        'auteur' => $_POST['author'] ?: null,
        'siecle' => $_POST['century'] ?: null,
        'cote' => $_POST['cote'] ?: null,
        'langue' => $_POST['langue'] ?: null,
        'edition' => $_POST['edition'] ?: null,
        'objectid' => $nextObjectId,
    ];

    try {
        $insertResult = getTpCollection()->insertOne($document);
        header('Location: /app.php');
        exit;
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
} else {
    try {
        echo $twig->render('create.html.twig');
    } catch (LoaderError|RuntimeError|SyntaxError $e) {
        echo $e->getMessage();
    }
}

