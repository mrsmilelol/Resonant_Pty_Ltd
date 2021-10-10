<?php
ob_start();
/** @var $dbh PDO */
/** @var $db_name string */
/** @var object $client client details */
require("header.php");
?>
<title>Client pdf</title>
<body>
<h3 class="mx-sm-3">Details of client ID "<?=$_GET['client_id']  ?>" that you are going to print</h3>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if (isset($_GET['client_id'])) {
    $query = "SELECT * FROM `client` WHERE `client_id` = ?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['client_id']])) {
        if ($stmt->rowCount() == 1) {
            $client = $stmt->fetchObject();}

    }
}

?>
<form method="post">
    <div class="form-group">
        <div class="row">
            <label for="client_id" class="mx-sm-3">Client ID</label>
            <input type="number"  id="client_id" name="client_id" class="form-control-sm mx-sm-4 mb-2 w-25" value="<?= $_GET['client_id'] ?>" disabled>
        </div>
        <div class="row">
            <label for="client_firstname" class="mx-sm-3">Client First Name</label>
            <input type="text"  id="client_firstname" name="client_firstname" class="form-control-sm mx-sm-4 mb-2 w-25" value="<?= $client->client_firstname ?>" disabled>
        </div>
        <div class="row">
            <label for="client_lastname" class="mx-sm-3">Client Last Name</label>
            <input type="text"  id="client_lastname" name="client_lastname" class="form-control-sm mx-sm-4 mb-2 w-25" value="<?= $client->client_lastname ?>" disabled>
        </div>
        <div class="row">
            <label for="client_address" class="mx-sm-3">Client Address</label>
            <input type="text"  id="client_address" name="client_address" class="form-control-sm mx-sm-4 mb-2 w-25" value="<?= $client->client_address ?>" disabled>
        </div>
        <div class="row">
            <label for="client_phone" class="mx-sm-3">Client Phone</label>
            <input type="text" id="client_phone" name="client_phone" class="form-control-sm mx-sm-4 mb-2 w-25" value="<?= $client->client_phone ?>" disabled>
        </div>
        <div class="row">
            <label for="client_email" class="mx-sm-3">Client Email</label>
            <input type="text" id="client_email" name="client_email" class="form-control-sm mx-sm-4 mb-2 w-25" value="<?= $client->client_email ?>" disabled>
        </div>
        <div class="row">
            <label for="client_subscribed" class="mx-sm-3">Client Subscribed</label>
            <input type="text" id="client_subscribed" name="client_subscribed" class="form-control-sm mx-sm-4 mb-2 w-25" value="<?= $client->client_subscribed ?>" disabled>
        </div>
        <div class="row">
            <label for="client_other_information" class="mx-sm-3">Client Other Information</label>
            <textarea type="text" id="client_other_information" name="client_other_information" class="form-control-sm mx-sm-4 mb-2 w-25" rows="5" value="<?= $client->client_other_information ?>" disabled></textarea>
        </div>
        <div class="row">
            <button type="button" class="btn btn-outline-success w-25 mx-sm-4 mb-2" onclick="window.location='temp.php?client_id=<?= $_GET['client_id'] ?>'">Print</button>

        </div>
        <div class="row">
            <button type="button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" onclick="window.location='client.php'">Back to Client list</button>
        </div>
    </div>
</form>
<?php require("footer.php"); ?>

