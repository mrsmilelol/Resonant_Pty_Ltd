<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2', 'fit2104', 'fit2104');
if (!isset($_GET['product_name'])) {
    header("Location: product.php");
    die();
}
?>
<html
<head>
</head>
<body>
<h1>Delete client</h1>
<?php
include("connection.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    $query = "DELETE FROM `product` WHERE `product_name`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['product_name']])) {
        echo "Product #" . $_GET['product_name'] . " has been deleted. ";
        echo "<button onclick=\"window.location='product.php'\">Back to the product list</button>";
    } else {
        echo friendlyError($stmt->errorInfo()[2]);
        echo "<button onclick=\"window.history.back()\">Back to previous page</button>";
        die();
    }
} else {
    $query = "SELECT * FROM `product` WHERE `product_name`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['product_name']])) {
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetchObject(); ?>
            <form method="post">
                <label for="name">Product Name</label>
                <input type="text" id="name" value="<?= $row->product_name ?>" disabled/><br>
                <label for="upc">Unit Price</label>
                <input type="number" id="upc" value="<?= $row->product_upc ?>" disabled/><br>
                <label for="price">Selling Price</label>
                <input type="number" id="price" value="<?= $row->product_price ?>" disabled/><br>
                <label for="category">Category</label>
                <input type="text" id="category" value="<?= $row->product_category ?>" disabled/><br>
                <input type="submit" name="action" id="delete-button" value="Delete"/>
                <button type="button" onclick="window.location='product.php';return false;">Cancel</button>
            </form>
        <?php } else {
            header("Location: product.php");
        }
    } else {
        die(friendlyError($stmt->errorInfo()[2]));
    }
} ?>
</body>
</html>
