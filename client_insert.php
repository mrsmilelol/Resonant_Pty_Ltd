<?php
ob_start();
/** @var $dbh PDO */
/** @var $dbname string */
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
?>
<!doctype html>
<html>
<head>
    <title>Add new client</title>
</head>
<body>
<h1>Add new client</h1>
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
                <div class="center row">New client has been added.</div>
                <form method="post">
                    <div class="aligned-form">
                        <div class="row">
                            <label for="id">ID</label>
                            <input type="number" id="id" value="<?= $record->client_id ?>" disabled/>
                        </div>
                        <div class="row">
                            <label for="firstname">Firstname</label>
                            <input type="text" id="firstname" value="<?= $record->client_firstname ?>" disabled/>
                        </div>
                        <div class="row">
                            <label for="lastname">Lastname</label>
                            <input type="text" id="lastname" value="<?= $record->client_lastname ?>" disabled/>
                        </div>
                        <div class="row">
                            <label for="address">Address</label>
                            <input type="text" id="address" value="<?= $record->client_address ?>"disabled/>
                        </div>
                        <div class="row">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" value="<?= $record->client_phone ?>" disabled/>
                        </div>
                        <div class="row">
                            <label for="email">Email</label>
                            <input type="text" id="email" value="<?= $record->client_email ?>" disabled/>
                        </div>
                        <div class="row">
                            <label for="subscribed">Subscribed</label>
                            <input type="text" id="subscribed" value="<?= $record->client_subscribed ?>" disabled/>
                        </div>
                        <div class="row">
                            <label for="client_other_information">Client Other Information</label>
                            <input type="text" id="client_other_information" value="<?= $record->client_other_information ?>" disabled/>
                        </div>
                    </div>
                </form>
                <div class="center row">
                    <button onclick="window.location='client.php'">Back to the client list</button>
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
        <div class="aligned-form">
            <div class="row">
                <label for="client_id">ID</label>
                <input type="text" id="client_id" value="<?= $nextId ?>" disabled/>
            </div>
            <div class="row">
                <label for="client_firstname">First Name</label>
                <input type="text" id="client_firstname" name="client_firstname"/>
            </div>
            <div class="row">
                <label for="client_lastname">Last Name</label>
                <input type="text" id="client_lastname" name="client_lastname"/>
            </div>
            <div class="row">
                <label for="client_address">Address</label>
                <input type="text" id="client_address" name="client_address"/>
            </div>
            <div class="row">
                <label for="client_phone">Phone</label>
                <input type="text" id="client_phone" name="client_phone"/>
            </div>
            <div class="row">
                <label for="client_email">Email</label>
                <input type="text" id="client_email" name="client_email"/>
            </div>
            <div class="row">
                <label for="client_subscribed">Subscribed</label>
                <input type="text" id="client_subscribed" name="client_subscribed"/>
            </div>
            <div class="row">
                <label for="client_other_information">Other Information</label>
                <input type="text" id="client_other_information" name="client_other_information"/>
            </div>
        </div>
        <div class="row center">
            <input type="submit" value="Add"/>
            <button type="button" onclick="window.location='client.php';return false;">Cancel</button>
        </div>
    </form>
<?php } ?>
</body>
</html>

