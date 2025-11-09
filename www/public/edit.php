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
    if ($entity) {
        $entity = [
            '_id' => (string)$entity->_id,
            'titre' => $entity->titre ?? '',
            'auteur' => $entity->auteur ?? '',
            'siecle' => $entity->siecle ?? '',
            'cote' => $entity->cote ?? '',
            'langue' => $entity->langue ?? '',
            'edition' => $entity->edition ?? '',
        ];
    } else {
        throw new RuntimeException('Document introuvable');
    }
} catch (Throwable $e) {
    echo $e->getMessage();
}

try {
    echo $twig->render('update.html.twig', ['entity' => $entity]);
} catch (LoaderError|RuntimeError|SyntaxError $e) {
    echo $e->getMessage();
}