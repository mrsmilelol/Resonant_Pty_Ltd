<?php
/** @var $dbh PDO */
require("header.php");
if (!isset($_GET['client_id'])) {
    header("Location: client.php");
    die();
}
?>
<body>
<h3 class="mx-sm-2">Delete client</h3>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    $query = "DELETE FROM `client` WHERE `client_id`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['client_id']])) {
        echo "<span class=\"mx-sm-3\"> Client information is successfully deleted</span> ";
        echo "<div class=\"row\"><button  class=\"btn btn-outline-info w-25 mx-sm-4 mb-2\"  onclick=\"window.location='client.php'\">Back to the client list</button></div>";
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
                <div class="form-group">
                    <div class="row">
                        <label for="id" class="mx-sm-3">ID</label>
                        <input type="number" class="form-control-sm mx-sm-4 mb-2 w-25" readonly id="id" value="<?= $row->client_id ?>" />
                    </div>
                    <div class="row">
                        <label for="firstname" class="mx-sm-3">Firstname</label>
                        <input type="text" class="form-control-sm mx-sm-4 mb-2 w-25" readonly id="firstname" value="<?= $row->client_firstname ?>" />
                    </div>
                    <div class="row">
                        <label for="lastname" class="mx-sm-3">Lastname</label>
                        <input type="text" class="form-control-sm mx-sm-4 mb-2 w-25" readonly id="lastname" value="<?= $row->client_lastname ?>" />
                    </div>
                    <div class="row">
                        <label for="address" class="mx-sm-3">Address</label>
                        <input type="text" class="form-control-sm mx-sm-4 mb-2 w-25" readonly id="address" value="<?= $row->client_address ?>" />
                    </div>
                    <div class="row">
                        <label for="phone" class="mx-sm-3">Phone</label>
                        <input type="text" class="form-control-sm mx-sm-4 mb-2 w-25" readonly id="phone" value="<?= $row->client_phone ?>" />
                    </div>
                    <div class="row">
                        <label for="email" class="mx-sm-3">Email</label>
                        <input type="text" class="form-control-sm mx-sm-4 mb-2 w-25" readonly id="email" value="<?= $row->client_email ?>" />
                    </div>
                    <div class="row">
                        <label for="subscribed" class="mx-sm-3">Subscribed</label>
                        <input type="text" class="form-control-sm mx-sm-4 mb-2 w-25" readonly id="subscribed" value="<?= $row->client_subscribed ?>" />
                    </div>
                    <div class="row">
                        <label for="client_other_information" class="mx-sm-3">Client Other Information</label>
                        <input type="text" class="form-control-sm mx-sm-4 mb-2 w-25" readonly id="client_other_information" value="<?= $row->client_other_information ?>" />
                    </div>
                    <div class="row">
                        <input type="submit" name="action" id="delete-button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" value="Delete"/>
                    </div>
                    <div class="row">
                        <button type="button" class="btn btn-outline-info w-25 mx-sm-4 mb-2" onclick="window.location='client.php';return false;">Cancel</button>
                    </div>
            </form>
        <?php } else {
            header("Location: client.php");
        }
    } else {
        die(friendlyError($stmt->errorInfo()[2]));
    }
} ?>
<?php require("footer.php")?>
