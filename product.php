<!doctype html>
<head>
    <title>Product Information</title>
</head>
<body>
<form action="" method="post">
    <input type="text" name="search" placeholder="Search for products..."/>
    <input type="submit" name = "submit" value="Submit" />
</form>
<h1>Product Information</h1>
<button onclick="window.location='product_insert.php'">Add new product information</button>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
$query="";
if(isset($_POST['submit'])){
    $search = $_POST['search'];
    $query = "SELECT * FROM `product` INNER JOIN `category` ON product.category_id = category.category_id WHERE product_upc LIKE '%".$search."%' ORDER BY category_name;";
}
else{
    $query = "SELECT * FROM `product` INNER JOIN `category` ON product.category_id = category.category_id ORDER BY category_name;";
}
$stmt = $dbh->prepare($query);
if ($stmt->execute()): ?>
    <table border="1">
        <thead>
        <tr>
            <th>Product Universal Product Code</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Category</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetchObject()): ?>
            <td><?= $row->product_upc ?></td>
            <td><?= $row->product_name ?></td>
            <td><?= $row->product_price ?></td>
            <td><?= $row->category_name ?></td>
            <td><button id="update" onclick="window.location='product_update.php?product_upc=<?= $row->product_upc?>'">Update</button>
                <button id="delete" onclick="window.location='product_delete.php?product_upc=<?= $row->product_upc?>'">Delete</button></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else:
    die(friendlyError($stmt->errorInfo()[2]));
endif; ?>
</body>
</html>
