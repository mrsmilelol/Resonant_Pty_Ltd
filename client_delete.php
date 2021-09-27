<?php
/** @var $dbh PDO */
if (!isset($_GET['client_id'])) {
    header("Location: client.php");
    die();
}
?>
<html
<head>
</head>
<body>
<h1>Delete client</h1>
<?php
include("connection.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    $query = "DELETE FROM `client` WHERE `client_id`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['client_id']])) {
        echo "Client #" . $_GET['client_id'] . " has been deleted. ";
        echo "<button onclick=\"window.location='client.php'\">Back to the client list</button>";
    } else {
        echo friendlyError($stmt->errorInfo()[2]);
        echo "<button onclick=\"window.history.back()\">Back to previous page</button>";
        die();
    }
} else {
    $query = "SELECT * FROM `client` WHERE `client_id`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['client_id']])) {
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetchObject(); ?>
            <form method="post">
                <label for="id">ID</label>
                <input type="number" id="id" value="<?= $row->client_id ?>" disabled/><br>
                <label for="firstname">Firstname</label>
                <input type="text" id="firstname" value="<?= $row->client_firstname ?>" disabled/><br>
                <label for="lastname">Lastname</label>
                <input type="text" id="lastname" value="<?= $row->client_lastname ?>" disabled/><br>
                <label for="address">Address</label>
                <input type="text" id="address" value="<?= $row->client_address ?>" disabled/><br>
                <label for="phone">Phone</label>
                <input type="text" id="phone" value="<?= $row->client_phone ?>" disabled/><br>
                <label for="email">Email</label>
                <input type="text" id="email" value="<?= $row->client_email ?>" disabled/><br>
                <label for="subscribed">Subscribed</label>
                <input type="number" id="subscribed" value="<?= $row->client_subscribed ?>" disabled/><br>
                <label for="client_other_information">Client Other Information</label>
                <input type="text" id="client_other_information" value="<?= $row->client_other_information ?>" disabled/><br>
                <input type="submit" name="action" id="delete-button" value="Delete"/>
                <button type="button" onclick="window.location='client.php';return false;">Cancel</button>
            </form>
        <?php } else {
            header("Location: client.php");
        }
    } else {
        die(friendlyError($stmt->errorInfo()[2]));
    }
} ?>
</body>
</html>
