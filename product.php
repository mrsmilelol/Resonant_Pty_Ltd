<!doctype html>
<head>
    <title>Product Information</title>
</head>
<body>
<form action="product_search.php" method="post">
    <input type="text" name="search" placeholder="Search for products..."/>
    <input type="submit" value="Submit" />
</form>
<h1>Product Information</h1>
<button onclick="window.location='product_insert.php'">Add new product information</button>
<?php
include("connection.php");
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
$query = "SELECT * FROM `product`;";
$stmt = $dbh->prepare($query);
if ($stmt->execute()): ?>
    <table border="1">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Product Unit Price</th>
            <th>Product Price</th>
            <th>Product Category</th>
            <th>Action</th>>
            <th>Product Image</th>>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetchObject()): ?>
            <td><?= $row->product_name ?></td>
            <td><?= $row->product_upc ?></td>
            <td><?= $row->product_price ?></td>
            <td><?= $row->product_category ?></td>
            <td><button id="update" onclick="window.location='product_update.php?product_name=<?= $row->product_name?>'">Update</button>
                <button id="delete" onclick="window.location='product_delete.php?product_name=<?= $row->product_name?>'">Delete</button></td>
            <td><button id="upload" onclick="window.location='product_image.php?product_name=<?= $row->product_name?>'">Upload</button></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else:
    die(friendlyError($stmt->errorInfo()[2]));
endif; ?>
</body>
</html>