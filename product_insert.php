<?php
ob_start();
/** @var $dbh PDO */
/** @var $db_name string */
?>
<!doctype html>
<html>
<head>
    <title>Add new product</title>
</head>
<body>
<h1>Add new product</h1>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if(!empty($_POST)){
    foreach ($_POST as $fieldName => $fieldValue) {
        if (empty($fieldValue)) {
            echo friendlyError("'$fieldName' field is empty. Please fix the issue try again. ");
            echo "<div class=\"center row\"><button onclick=\"window.history.back()\">Back to previous page</button></div>";
            die();
        }
    }
    $query = "INSERT INTO `product` (`product_upc`, `product_name`, `product_price`,`category_id`) VALUES (:product_upc, :product_name, :product_price, :category_id)";
    $stmt = $dbh->prepare($query);
    $parameters = [
        'product_upc' => $_POST['product_upc'],
        'product_name'=>$_POST['product_name'],
        'product_price'=>$_POST['product_price'],
        'category_id'=>$_POST['category_id']
    ];
    if ($stmt->execute($parameters)) {
        header("Location: product.php");
        exit();
    } else {
        echo friendlyError($stmt->errorInfo()[2]);
        exit();
    }}
?>
<form method="post">
    <div class="aligned-form">
        <div class="row">
            <label for="client_id">ID</label>
            <input type="number" id="product_upc" name="product_upc" />
        </div>
        <div class="row">
            <label for="client_firstname">Product Name</label>
            <input type="text" id="product_name" name="product_name" required">
        </div>
        <div class="row">
            <label for="client_lastname">Product Price</label>
            <input type="number" id="product_price" name="product_price" required">
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
        <div class="row center">
            <input type="submit" value="Add"/>
            <button type="button" onclick="window.location='client.php';return false;">Cancel</button>
        </div>
</form>
<?php ?>
</body>
</html>

