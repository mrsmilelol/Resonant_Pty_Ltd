
<!doctype html>
<head>
    <title>Category Information</title>
</head>
<body>
<h1>Category Information</h1>
<div class="center row">
    <button onclick="window.location='category_insert.php'">Add new category information</button>
</div>
<?php
/** @var $dbh PDO */
#$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');

include("connection.php");
$query = "SELECT * FROM `category`;";
$stmt = $dbh->prepare($query);
if ($stmt->execute()): ?>
    <table border="1">
        <thead>
        <tr>
            <th>Category ID</th>
            <th>Category name</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetchObject()): ?>
            <tr>
                </td>
                <td><?= $row->category_id ?></td>
                <td><?= $row->category_name ?></td>
                <td><button id="update" onclick="window.location='category_update.php?category_id=<?= $row->category_id?>'">Update</button>
                    <button id="delete" onclick="window.location='category_delete.php?category_id=<?= $row->category_id?>'">Delete</button></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else:
    die(friendlyError($stmt->errorInfo()[2]));
endif; ?>
</body>
</html>
<?php
