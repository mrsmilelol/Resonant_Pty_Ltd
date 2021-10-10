<?php
ob_start();
/** @var $dbh PDO */
/** @var $dbname string */
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
require("header.php");
?>
<body>
<h3 class="mx-sm-3">Add new client</h3>
<?php
if(!empty($_POST)){
    $query = "INSERT INTO client (client_firstname, client_lastname, client_address,`client_phone`,`client_email`, client_subscribed, client_other_information) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbh->prepare($query);
    $parameters = [
        $_POST['client_firstname'],
        $_POST['client_lastname'],
        $_POST['client_address'],
        $_POST['client_phone'],
        $_POST['client_email'],
        $_POST['client_subscribed'],
        $_POST['client_other_information']];
    if ($stmt->execute($parameters)) {
        $newRecordId = $dbh->lastInsertId();
        $query = "SELECT * FROM client WHERE `client_id`=?";
        $stmt = $dbh->prepare($query);
        if ($stmt->execute([$newRecordId])) {
            if ($stmt->rowCount() > 0) {
                $record = $stmt->fetchObject(); ?>
                <div class="mx-sm-3" >New client has been added.</div>
                <form method="post">
                    <div class="form-group">
                        <div class="row">
                            <label for="id" class="mx-sm-3">ID</label>
                            <input type="number" id="id" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $record->client_id ?>" />
                        </div>
                        <div class="row">
                            <label for="firstname" class="mx-sm-3">Firstname</label>
                            <input type="text" id="firstname" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $record->client_firstname ?>" />
                        </div>
                        <div class="row" >
                            <label for="lastname">Lastname</label>
                            <input type="text" id="lastname" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $record->client_lastname ?>" />
                        </div>
                        <div class="row" >
                            <label for="address" class="mx-sm-3">Address</label>
                            <input type="text" id="address" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $record->client_address ?>"/>
                        </div>
                        <div class="row" >
                            <label for="phone" class="mx-sm-3">Phone</label>
                            <input type="text" id="phone" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $record->client_phone ?>" />
                        </div>
                        <div class="row" >
                            <label for="email" class="mx-sm-3">Email</label>
                            <input type="text" id="email" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $record->client_email ?>" />
                        </div>
                        <div class="row" >
                            <label for="subscribed" class="mx-sm-3">Subscribed</label>
                            <input type="text" id="subscribed" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $record->client_subscribed ?>" />
                        </div>
                        <div class="row" >
                            <label for="client_other_information" class="mx-sm-3">Client Other Information</label>
                            <textarea type="text" id="client_other_information" class="form-control-sm mx-sm-4 mb-2 w-25" value="<?= $record->client_other_information ?>"></textarea>
                        </div>
                    </div>
                </form>
                <div class="center row">
                    <button class="btn btn-outline-info w-25 mx-sm-4 mb-2" onclick="window.location='client.php'">Back to the client list</button>
                </div>
            <?php } else {
                echo "Weird, the client just added has mysteriously disappeared!? ";
                echo "<div class=\"center row\"><button onclick=\"window.location='client.php'\">Back to the client list</button></div>";
            }
        } else {
            die(friendlyError($stmt->errorInfo()[2]));
        }
    } else {
        echo friendlyError($stmt->errorInfo()[2]);
        echo "<div class=\"center row\"><button onclick=\"window.history.back()\">Back to previous page</button></div>";
        die();
    }}
else {
    $query = "SELECT AUTO_INCREMENT FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'fit2104_ass2' AND TABLE_NAME='client'";
    $stmt = $dbh->prepare($query);
    $nextId = ($stmt->execute() || $stmt->rowCount() > 0) ? $stmt->fetchObject()->AUTO_INCREMENT : "Not available";
    ?>
    <form method="post">
        <div class="form-group">
            <div class="row">
                <label for="client_id" class="mx-sm-3">ID</label>
                <input type="text" id="client_id" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $nextId ?>"/>
            </div>
            <div class="row">
                <label for="client_firstname" class="mx-sm-3">First Name</label>
                <input type="text" id="client_firstname" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_firstname" required/>
            </div>
            <div class="row">
                <label for="client_lastname" class="mx-sm-3">Last Name</label>
                <input type="text" id="client_lastname" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_lastname" required/>
            </div>
            <div class="row">
                <label for="client_address" class="mx-sm-3">Address</label>
                <input type="text" id="client_address" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_address" required/>
            </div>
            <div class="row">
                <label for="client_phone" class="mx-sm-3">Phone</label>
                <input type="text" id="client_phone" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_phone" required/>
            </div>
            <div class="row">
                <label for="client_email" class="mx-sm-3">Email</label>
                <input type="text" id="client_email" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_email" required/>
            </div>
            <div class="row">
                <label for="client_subscribed" class="mx-sm-3">Subscribed</label>
                <input type="text" id="client_subscribed" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_subscribed" required/>
            </div>
            <div class="row">
                <label for="client_other_information" class="mx-sm-3">Other Information</label>
                <textarea type="text" id="client_other_information" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_other_information"></textarea>
            </div>
        </div>
        <div class="row">
            <input type="submit" class="btn btn-outline-success w-25 mx-sm-4 mb-2" value="Add"/>
        </div>
        <div class="row">
            <button type="button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" onclick="window.location='client.php';return false;">Cancel</button>
        </div>
    </form>
<?php require("footer.php");} ?>


