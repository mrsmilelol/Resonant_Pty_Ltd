<?php require("header.php");
$PAGE_ID = "photo_shoot";?>
<title>Photo-shoot Information</title>
<body>
<h1 class="text-center">Photo-shoot Information</h1>
<button class="btn btn-outline-primary mx-sm-2" onclick="window.location='photo_insert.php'">Add new photo-shoot information</button>
<?php
/** @var $dbh PDO */
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
$query = "SELECT * FROM `photo_shoot` INNER JOIN `client` ON photo_shoot.client_id = client.client_id ORDER BY client_firstname,client_lastname;";
$stmt = $dbh->prepare($query);
if ($stmt->execute()): ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Client ID</th>
            <th>Client First Name</th>
            <th>Client Last Name</th>
            <th>Name</th>
            <th>Description</th>
            <th>Date</th>
            <th>Quote</th>
            <th>Other Information</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetchObject()): ?>
            <td><?= $row->client_id ?></td>
            <td><?= $row->client_firstname ?></td>
            <td><?= $row->client_lastname ?></td>
            <td><?= $row->photo_shoot_name ?></td>
            <td><?= $row->photo_shoot_description ?></td>
            <td><?= $row->photo_shoot_date ?></td>
            <td><?= $row->photo_shoot_quote ?></td>
            <td><?= $row->photo_shoot_other_information ?></td>
            <td>
                <button id="details" class="btn btn-success btn-sm" onclick="window.location='photo_details.php?photo_shoot_name=<?=$row->photo_shoot_name?>'">Details</button>
                <button id="update" class="btn btn-info btn-sm" onclick="window.location='photo_update.php?photo_shoot_name=<?= $row->photo_shoot_name?>'">Update</button>
                <button id="delete" class="btn btn-danger btn-sm" onclick="window.location='photo_delete.php?photo_shoot_name=<?= $row->photo_shoot_name?>'">Delete</button>
            </td>
            </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else:
    die(friendlyError($stmt->errorInfo()[2]));
endif; ?>
</body>
</html>
<?php require("footer.php") ?>
