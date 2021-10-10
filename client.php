<?php
$PAGE_ID = "client";
require('header.php')
?>
<title>Client Information</title>
<body>
<h1 class="text-center">Client Information</h1>
<a class="btn btn-outline-primary mx-sm-2" href="client_insert.php">Add new client information</a>
<?php
/** @var $dbh PDO */
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
$query = "SELECT * FROM `client`;";
$stmt = $dbh->prepare($query);
if ($stmt->execute()): ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Subscribed</th>
            <th>Client Other Information</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetchObject()): ?>
            <tr>
                </td>
                <td><?= $row->client_id ?></td>
                <td><?= $row->client_firstname ?></td>
                <td><?= $row->client_lastname ?></td>
                <td><?= $row->client_address ?></td>
                <td><?= $row->client_phone ?></td>
                <td><?= $row->client_email ?></td>
                <td><?= $row->client_subscribed ?></td>
                <td><?= $row->client_other_information ?></td>
                <td><button id="update" class="btn btn-info btn-sm" onclick="window.location='client_update.php?client_id=<?= $row->client_id?>'">Update</button>
                    <button id="delete" class="btn btn-danger btn-sm" onclick="window.location='client_delete.php?client_id=<?= $row->client_id?>'">Delete</button>
                    <button id="download" class="btn btn-success btn-sm" onclick="window.location='client_pdf.php?client_id=<?= $row->client_id?>'">Download</button></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else:
    die(friendlyError($stmt->errorInfo()[2]));
endif; ?>
<?php require("footer.php")?>
</body>
