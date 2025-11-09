<?php

include_once '../init.php';

use MongoDB\BSON\ObjectId;

try {
    if (!isset($_GET['id'])) {
        throw new RuntimeException('Identifiant manquant');
    }
    $id = new ObjectId($_GET['id']);
    getTpCollection()->deleteOne(['_id' => $id]);
} catch (Throwable $e) {
    echo $e->getMessage();
}

header('Location: /app.php');
exit;
