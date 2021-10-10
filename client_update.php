<?php
ob_start();
/** @var $dbh PDO */
require("header.php");
if (!isset($_GET['client_id'])) {
    header("Location: client.php");
    die();
}
?>
<title>Update client #<?= $_GET['client_id'] ?></title>
<h3 class="mx-sm-3">Update client #<?= $_GET['client_id']?></h3>
<body>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if (!empty($_POST)) {
    foreach ($_POST as $fieldName => $fieldValue) {
    }
    $query = "UPDATE `client` SET `client_firstname`=:client_firstname,`client_lastname`=:client_lastname,`client_address`=:client_address,`client_phone`=:client_phone,`client_email`=:client_email, `client_subscribed` =:client_subscribed, `client_other_information` =:client_other_information WHERE `client_id`=:client_id;";
    $stmt = $dbh->prepare($query);
    $parameters = [
        'client_firstname'=>$_POST['client_firstname'],
        'client_lastname'=>$_POST['client_lastname'],
        'client_address'=>$_POST['client_address'],
        'client_phone'=>$_POST['client_phone'],
        'client_email'=>$_POST['client_email'],
        'client_subscribed'=>$_POST['client_subscribed'],
        'client_other_information'=>empty($_POST['client_other_information']) ? null : $_POST['client_other_information'],
        'client_id'=>$_GET['client_id']
    ];
    if ($stmt->execute($parameters)) {
        header("Location: client.php");
    } else {
        echo friendlyError($stmt->errorInfo()[2]);
        echo "<div class=\"center row\"><button onclick=\"window.history.back()\">Back to previous page</button></div>";
        die();
    }
} else {
    $query = "SELECT * FROM `client` WHERE `client_id`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['client_id']])) {
        if ($stmt->rowCount() > 0) {
            $record = $stmt->fetchObject(); ?>
            <form method="post">
                <div class="form-group">
                    <div class="row">
                        <label for="id" class="mx-sm-3">ID</label>
                        <input type="number" id="client_id" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $record->client_id ?>"/>
                    </div>
                    <div class="row">
                        <label for="firstname" class="mx-sm-3">Firstname</label>
                        <input type="text" id="client_firstname" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_firstname" required value="<?= $record->client_firstname ?>" />
                    </div>
                    <div class="row">
                        <label for="lastname" class="mx-sm-3">Lastname</label>
                        <input type="text" id="client_lastname" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_lastname" required value="<?= $record->client_lastname ?>"/>
                    </div>
                    <div class="row">
                        <label for="address" class="mx-sm-3">Address</label>
                        <input type="text" id="client_address" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_address" required value="<?= $record->client_address ?>""/>
                    </div>
                    <div class="row">
                        <label for="phone" class="mx-sm-3">Phone</label>
                        <input type="text" id="client_phone" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_phone" required value="<?= $record->client_phone ?>" />
                    </div>
                    <div class="row">
                        <label for="email" class="mx-sm-3">Email</label>
                        <input type="text" id="client_email" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_email" required value="<?= $record->client_email ?>" />
                    </div>
                    <div class="row">
                        <label for="subscribed" class="mx-sm-3">Subscribed</label>
                        <input type="text" id="client_subscribed" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_subscribed" required value="<?= $record->client_subscribed ?>" />
                    </div>
                    <div class="row">
                        <label for="client_other_information" class="mx-sm-3">Client Other Information</label>
                        <textarea type="text" id="client_other_information" class="form-control-sm mx-sm-4 mb-2 w-25" name="client_other_information" rows="5"><?= empty($_POST['client_other_information']) ? $record->client_other_information : $_POST['description'] ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <input class="btn btn-outline-success w-25 mx-sm-4 mb-2" type="submit" value="Update"/>
                </div>
                <div class="row">
                    <button type="button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" onclick="window.location='client.php';return false;">Cancel</button>
                </div>
            </form>
        <?php } else {
            header("Location: client.php");
        }
    } else {
        die(friendlyError($stmt->errorInfo()[2]));
    }
}
?>
<?php require("footer.php")?>

