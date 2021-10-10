<?php
$PAGE_ID = "category";
require("header.php")
?>
<title>Category Information</title>
<body>
<h1 class="text-center">Category Information</h1>
<button class="btn btn-outline-primary mx-sm-2" onclick="window.location='category_insert.php'">Add new category information</button>
<?php
/** @var $dbh PDO */
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
$query = "SELECT * FROM `category`;";
$stmt = $dbh->prepare($query);
if ($stmt->execute()): ?>
    <table class="table table-bordered">
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
                <td style="width: 10%"><button id="update" class="btn btn-info btn-sm" onclick="window.location='category_update.php?category_id=<?= $row->category_id?>'">Update</button>
                    <button id="delete" class="btn btn-danger btn-sm" onclick="window.location='category_delete.php?category_id=<?= $row->category_id?>'">Delete</button></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else:
    die(friendlyError($stmt->errorInfo()[2]));
endif; ?>
</body>
</html>
<?php require("footer.php")?>
