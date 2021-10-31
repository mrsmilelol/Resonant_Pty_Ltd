<?php
$PAGE_ID = "product";
require('header.php')
?>
<title>Product Information</title>
<form action="" method="post" class="d-flex">
    <input type="text" class="form-control-sm"  name="search" id="search" placeholder="Search for products..." style="position: relative; left: 10px; top: 5px"/>
    <input type="submit" class="btn btn-outline-success position-relative" name = "submit" value="Submit" style="position: absolute; left: 15px; top: 5px"/>
</form>
<h1 class="text-center">Product Information</h1>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
$query="";
if(isset($_POST['submit'])){
    $search = $_POST['search'];
    $query = "SELECT * FROM `product` INNER JOIN `category` ON product.category_id = category.category_id WHERE product_upc LIKE '%".$search."%' ORDER BY category_name;";
}
else{
    $query = "SELECT * FROM `product` INNER JOIN `category` ON product.category_id = category.category_id ORDER BY product_upc;";
}
$stmt = $dbh->prepare($query);
if ($stmt->execute()): ?>
<a class="btn btn-outline-primary mx-sm-2" href="product_insert.php" style="position:relative;top:38px;">Add new product information</a>
<div class="table-responsive">
    <form method="post" action="product_delete.php" id="product_delete">
        <div>
            <input type="submit" class="btn btn-outline-danger float-end mx-sm-n2" value="Delete Selected Products"/>
        </div>
        <table class="table table-bordered" style="position: center;">
            <thead>
            <tr>
                <th scope="col">Delete?</th>
                <th scope="col">Product Universal Product Code</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Price</th>
                <th scope="col">Product Category</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $stmt->fetchObject()): ?>
                <td class="table-cell-center">
                    <input type="checkbox" name="product_ids[]" value="<?php echo $row->product_upc; ?>"/>
                </td>
                <td><?= $row->product_upc ?></td>
                <td><?= $row->product_name ?></td>
                <td>$<?= $row->product_price ?></td>
                <td><?= $row->category_name ?></td>
                <td class="table-cell-center">
                    <a class="btn btn-success btn-sm" href="product_details.php?product_upc=<?= $row->product_upc?>">Details</a>
                    <a class="btn btn-info btn-sm"  onclick="window.location='product_update.php?product_upc=<?= $row->product_upc?>'">Update</a>
                    <button type="submit" class="btn btn-danger btn-sm" name="product_ids[]" onclick="location.reload()" value="<?= $row->product_upc?>">Delete</button>
                </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </form>
    <?php else:
        die(friendlyError($stmt->errorInfo()[2]));
    endif; ?>
</div>
<?php require('footer.php'); ?>
