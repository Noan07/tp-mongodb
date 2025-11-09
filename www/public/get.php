<?php

include_once '../init.php';

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use MongoDB\BSON\ObjectId;

$twig = getTwig();

try {
    if (!isset($_GET['id'])) {
        throw new RuntimeException('Identifiant manquant');
    }
    $id = new ObjectId($_GET['id']);
    $entity = getTpCollection()->findOne(['_id' => $id]);
} catch (Throwable $e) {
    echo $e->getMessage();
}

try {
    echo $twig->render('get.html.twig', ['entity' => $entity]);
} catch (LoaderError|RuntimeError|SyntaxError $e) {
    echo $e->getMessage();
}