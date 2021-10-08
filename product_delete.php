<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2', 'fit2104', 'fit2104');
if (!isset($_GET['product_upc'])) {
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    $query = "DELETE FROM `product` WHERE `product_upc`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['product_upc']])) {
        echo "Product #" . $_GET['product_upc'] . " has been deleted. ";
        echo "<button onclick=\"window.location='product.php'\">Back to the product list</button>";
    } else {
        echo friendlyError($stmt->errorInfo()[2]);
        echo "<button onclick=\"window.history.back()\">Back to previous page</button>";
        die();
    }
} else {
    $query = "SELECT * FROM `product` INNER JOIN `category` ON product.category_id = category.category_id WHERE `product_upc`=? ORDER BY category_name;";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['product_upc']])) {
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetchObject(); ?>
            <form method="post">
                <label for="name">Product Name</label>
                <input type="number" id="upc" value="<?= $row->product_upc ?>" disabled/><br>
                <label for="price">Selling Price</label>
                <input type="text" id="name" value="<?= $row->product_name ?>" disabled/><br>
                <label for="upc">Universal Product Code</label>
                <input type="number" id="price" value="<?= $row->product_price ?>" disabled/><br>
                <label for="category">Category</label>
                <input type="text" id="category" value="<?= $row->category_name ?>" disabled/><br>
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

