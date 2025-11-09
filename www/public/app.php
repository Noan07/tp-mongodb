<?php

include_once '../init.php';

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

$twig = getTwig();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$skip = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = [];
if ($search !== '') {
    $filter = ['$or' => [
        ['titre' => ['$regex' => $search, '$options' => 'i']],
        ['auteur' => ['$regex' => $search, '$options' => 'i']],
    ]];
}

$total = getTpCollection()->countDocuments($filter);
$totalPages = max(1, ceil($total / $limit));

$list = getTpCollection()->find($filter, [
    'sort' => ['objectid' => 1],
    'limit' => $limit,
    'skip' => $skip,
]);

// render template
try {
    echo $twig->render('index.html.twig', [
        'list' => $list,
        'page' => $page,
        'limit' => $limit,
        'total' => $total,
        'totalPages' => $totalPages,
        'hasPrev' => $page > 1,
        'hasNext' => $page < $totalPages,
        'prevPage' => max(1, $page - 1),
        'nextPage' => min($totalPages, $page + 1),
        'search' => $search,
    ]);
} catch (LoaderError|RuntimeError|SyntaxError $e) {
    echo $e->getMessage();
}



