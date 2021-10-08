<head>
    <title>Update client #<?= $_GET['product_upc'] ?></title>
</head>
<body>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if (!empty($_POST)) {
    $query = "UPDATE `product` SET `product_name`=:product_name,`product_price`=:product_price,`category_id`=:category_id  WHERE `product_upc`=:product_upc;";
    $stmt = $dbh->prepare($query);
    $parameters = [
        'product_name'=>$_POST['product_name'],
        'product_price'=>$_POST['product_price'],
        'category_id'=>$_POST['category_id'],
        'product_upc'=>$_GET['product_upc']
    ];
    if ($stmt->execute($parameters)) {
        header("Location: product.php");
    } else {
        echo friendlyError($stmt->errorInfo()[2]);
        echo "<div class=\"center row\"><button onclick=\"window.history.back()\">Back to previous page</button></div>";
        die();
    }
} else {
    $query = "SELECT * FROM `product` WHERE `product_upc`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['product_upc']])) {
        if ($stmt->rowCount() > 0) {
            $record = $stmt->fetchObject(); ?>
            <form method="post">
                <div class="aligned-form">
                    <div class="row">
                        <label for="product_name">Name</label>
                        <input type="text" id="product_name" name="product_name" value="<?= $record->product_name ?>"/>
                    </div>
                    <div class="row">
                        <label for="product_upc">Universal Price Code</label>
                        <input type="number" id="product_upc"  value="<?= $record->product_upc ?>" disabled/>
                    </div>
                    <div class="row">
                        <label for="product_price">Price</label>
                        <input type="number" id="product_price" name="product_price" value="<?= $record->product_price ?>"/>
                    </div>
                    <div class="row">
                        <?php $category_stmt = $dbh->prepare("SELECT * FROM `category` ORDER BY `category_name`");
                        if ($category_stmt->execute() && $category_stmt->rowCount() > 0) { ?>
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id">
                                <?php while ($row = $category_stmt->fetchObject()): ?>
                                    <option value="<?= $row->category_id ?>"><?= $row->category_name ?></option>
                                <?php endwhile; ?>
                            </select>
                        <?php } ?>
                    </div>
                </div>
                <div class="row center">
                    <input type="submit" value="Update"/>
                    <button type="button" onclick="window.location='product.php';return false;">Cancel</button>
                </div>
            </form>
        <?php } else {
            header("Location: product.php");
        }
    } else {
        die(friendlyError($stmt->errorInfo()[2]));
    }
}
?>
</body>
</html>
