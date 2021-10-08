<?php
ob_start();
/** @var $dbh PDO */
if (!isset($_GET['client_id'])) {
    header("Location: client.php");
    die();
}
?>
<html
<head>
    <title>Update client #<?= $_GET['client_id'] ?></title>
</head>
<body>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if (!empty($_POST)) {
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
                <div class="aligned-form">
                    <div class="row">
                        <label for="id">ID</label>
                        <input type="number" id="client_id" value="<?= $record->client_id ?>" disabled/>
                    </div>
                    <div class="row">
                        <label for="firstname">Firstname</label>
                        <input type="text" id="client_firstname" name="client_firstname" value="<?= $record->client_firstname ?>" />
                    </div>
                    <div class="row">
                        <label for="lastname">Lastname</label>
                        <input type="text" id="client_lastname" name="client_lastname" value="<?= $record->client_lastname ?>"/>
                    </div>
                    <div class="row">
                        <label for="address">Address</label>
                        <input type="text" id="client_address" name="client_address" value="<?= $record->client_address ?>""/>
                    </div>
                    <div class="row">
                        <label for="phone">Phone</label>
                        <input type="text" id="client_phone" name="client_phone" value="<?= $record->client_phone ?>" />
                    </div>
                    <div class="row">
                        <label for="email">Email</label>
                        <input type="text" id="client_email" name="client_email" value="<?= $record->client_email ?>" />
                    </div>
                    <div class="row">
                        <label for="subscribed">Subscribed</label>
                        <input type="text" id="client_subscribed" name="client_subscribed" value="<?= $record->client_subscribed ?>" />
                    </div>
                    <div class="row">
                        <label for="client_other_information">Client Other Information</label>
                        <input type="text" id="client_other_information" name="client_other_information" value="<?= $record->client_other_information ?>" />
                    </div>
                </div>
                <div class="row center">
                    <input type="submit" value="Update"/>
                    <button type="button" onclick="window.location='client.php';return false;">Cancel</button>
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
</body>
</html>
