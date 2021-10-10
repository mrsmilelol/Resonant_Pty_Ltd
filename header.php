<?php
ob_start(); // To allow setting header when there's already page contents rendered

/** @var string $PAGE_ID Identify which page is loading the header, so the active menu item can be correctly recognised */
/** @var string $PAGE_USERNAME Username of the current logged in user */
/** @var string $PAGE_ALLOWGUEST If a page allows guest to visit */
/** @var PDO $dbh Database connection */
require("start.php")
?>
<!doctype html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Resonant</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="product.php">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="client.php">Client</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category.php">Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="photoshoot.php">Photo Shoot</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product_prices_update.php">Multiple Products</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
