<html
<head>
    <title>Client Information</title>
</head>
<body>
<h1>Client Information</h1>
<button onclick="window.location='client_insert.php'">Add new client information</button>
<?php
/** @var $dbh PDO */
include("connection.php");
$query = "SELECT * FROM `client`;";
$stmt = $dbh->prepare($query);
if ($stmt->execute()): ?>
    <table border="1">
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
                <td><button id="update" onclick="window.location='client_update.php?client_id=<?= $row->client_id?>'">Update</button>
                    <button id="delete" onclick="window.location='client_delete.php?client_id=<?= $row->client_id?>'">Delete</button></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else:
    die(friendlyError($stmt->errorInfo()[2]));
endif; ?>
</body>
</html>
