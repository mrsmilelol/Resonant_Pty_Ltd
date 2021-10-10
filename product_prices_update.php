<?php require("header.php");
$PAGE_ID = "multiple_prices";?>
<title>Editing Multiple Product's Prices</title>
<h1 class="text-center">Editing Multiple Product's Prices</h1>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['upcs'])) {
    foreach ($_POST['upcs'] as $upcs) {
        if (isset($_POST['prices'][$upcs])) {
            $query = "UPDATE `product` SET `product_price`=:product_price WHERE `product_upc` = :product_upc";
            $stmt = $dbh->prepare($query);
            if (!$stmt->execute([
                'product_price' => $_POST['prices'][$upcs],
                'product_upc' => $upcs
            ])) {
                echo "<h3>Error occurred while updating price of UPC# $upcs!</h3>";
                break;
            }
        }
        else {
            echo "<h3>The price of UPC# $upcs does not exist!</h3>";
            break;
        }
    }
}
$query = "SELECT * FROM `product` INNER JOIN `category` ON product.category_id = category.category_id ORDER BY category_name;";
$stmt = $dbh->prepare($query);
if ($stmt->execute()): ?>
    <form method="post">
        <input type="submit" class="btn btn-outline-primary mx-sm-2" value="Update Prices Of Selected Products"/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Update?</th>
                <th>Product Universal Product Code</th>
                <th>Product Name</th>
                <th>Product Price</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $stmt->fetchObject()): ?>
                <td class="table-cell-center">
                    <input type="checkbox" name="upcs[]" value="<?php echo $row->product_upc; ?>"/>
                </td>
                <td><?= $row->product_upc ?></td>
                <td><?= $row->product_name ?></td>
                <td>$<input type="number" name="prices[<?=$row->product_upc?>]" value="<?= $row->product_price ?>"/></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </form>
<?php else:
    die(friendlyError($stmt->errorInfo()[2]));
endif; ?>

<?php require("footer.php");?>
