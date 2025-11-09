<?php

include_once '../init.php';

use MongoDB\BSON\ObjectId;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = new ObjectId($_POST['id']);
        $update = [
            'titre' => $_POST['title'] ?? '',
            'auteur' => $_POST['author'] ?? '',
            'cote' => $_POST['cote'] ?? '',
            'langue' => $_POST['langue'] ?? '',
            'edition' => $_POST['edition'] ?? '',
            'siecle' => $_POST['century'],
        ];

        getTpCollection()->updateOne(
            ['_id' => $id],
            ['$set' => $update]
        );
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
}

header('Location: /app.php');
exit;
