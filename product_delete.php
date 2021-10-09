<?php

$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['product_ids'])) {
    $query_placeholders = trim(str_repeat("?,", count($_POST['product_ids'])), ",");

    $query = "SELECT * FROM `product_image` WHERE `product_upc` in (" . $query_placeholders . ")";
    $stmt = $dbh->prepare($query);
    $stmt->execute($_POST['product_ids']);
    while ($image = $stmt->fetchObject()) {
        $fileFullPath = "product_images" . DIRECTORY_SEPARATOR . $image->product_image_filename;
        unlink($fileFullPath);
    }

    $query = "DELETE FROM `product_image` WHERE `product_upc` in (" . $query_placeholders . ")";
    $stmt = $dbh->prepare($query);
    $stmt->execute($_POST['product_ids']);

    $query = "DELETE FROM `product` WHERE `product_upc` in (" . $query_placeholders . ")";
    $stmt = $dbh->prepare($query);
    $stmt->execute($_POST['product_ids']);
}
header("Location: product.php");
exit();

