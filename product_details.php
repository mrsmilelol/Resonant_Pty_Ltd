<?php
ob_start();
/** @var $dbh PDO */
/** @var $db_name string */
/** @var object $product Product details */
/** @var object $product_image Product images */
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
if (isset($_GET['product_upc'])) {
    $stmt = $dbh->prepare("SELECT * FROM `product` INNER JOIN `category` ON product.category_id = category.category_id WHERE product_upc = ? ORDER BY category_name;");
    if ($stmt->execute([$_GET['product_upc']])) {
        if ($stmt->rowCount() == 1) {
            $product = $stmt->fetchObject();

            // Fetch product images
            $product_images = [];
            $stmt = $dbh->prepare("SELECT * FROM `product_image` WHERE `product_upc` = ?");
            $stmt->execute([$_GET['product_upc']]);
            while ($image = $stmt->fetchObject()) {
                $product_images[] = $image;
            }

            $product_fetched = true;
        }
    }
}
?>
<form method="post">
    <div class="aligned-form">
        <div class="row">
            <label for="product_upc">ID</label>
            <input type="number" readonly id="product_upc" name="product_upc" value="<?= $product->product_upc ?>">
        </div>
        <div class="row">
            <label for="product_name">Product Name</label>
            <input type="text" readonly id="product_name" name="product_name" value="<?= $product->product_name ?>">
        </div>
        <div class="row">
            <label for="product_price">Product Price</label>
            <input type="number" readonly id="product_price" name="product_price" value="<?= $product->product_price ?>">
        </div>
        <div class="row">
            <label for="product_category">Product Category</label>
            <input type="text" readonly id="category_name" name="category_name" value="<?= $product->category_name ?>">
        </div>
        <div class="row">
            <?php if (empty($product_images)): ?>
                <p>This product has no images</p>
            <?php else:
                foreach ($product_images as $image): ?>
                    <a href="product_images/<?= $image->product_image_filename ?>" target="_blank"><img src="product_images/<?= $image->product_image_filename ?>" width="200" height="200" class="rounded mb-1 product-image-thumbnail" alt="Product Image"></a>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</form>
<?php ?>
</body>
</html>


