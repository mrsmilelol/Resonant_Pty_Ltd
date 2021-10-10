<?php
ob_start();
/** @var $dbh PDO */
/** @var $db_name string */
/** @var object $client client details */
require("header.php");
?>
<title>Client pdf</title>
<body>
<h1>Details of client ID "<?=$_GET['client_id']  ?>" that you are going to print</h1>
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
    <div class="aligned-form">
        <div class="row">
            <label for="client_id">Client ID</label>
            <input type="number"  id="client_id" name="client_id" value="<?= $_GET['client_id'] ?>" disabled>
        </div>
        <div class="row">
            <label for="client_firstname">Client First Name</label>
            <input type="text"  id="client_firstname" name="client_firstname" value="<?= $client->client_firstname ?>" disabled>
        </div>
        <div class="row">
            <label for="client_lastname">Client Last Name</label>
            <input type="text"  id="client_lastname" name="client_lastname" value="<?= $client->client_lastname ?>" disabled>
        </div>
        <div class="row">
            <label for="client_address">Client Address</label>
            <input type="text"  id="client_address" name="client_address" value="<?= $client->client_address ?>" disabled>
        </div>
        <div class="row">
            <label for="client_phone">Client Phone</label>
            <input type="text" id="client_phone" name="client_phone" value="<?= $client->client_phone ?>" disabled>
        </div>
        <div class="row">
            <label for="client_email">Client Email</label>
            <input type="text" id="client_email" name="client_email" value="<?= $client->client_email ?>" disabled>
        </div>
        <div class="row">
            <label for="client_subscribed">Client Subscribed</label>
            <input type="text" id="client_subscribed" name="client_subscribed" value="<?= $client->client_subscribed ?>" disabled>
        </div>
        <div class="row">
            <label for="client_other_information">Client Other Information</label>
            <input type="text" id="client_other_information" name="client_other_information" value="<?= $client->client_other_information ?>" disabled>
        </div>
        <div>
            <button type="button" onclick="window.location='temp.php?client_id=<?= $_GET['client_id'] ?>'">Print</button>
            <button type="button" onclick="window.location='client.php'">Back to Client list</button>
        </div>
    </div>
</form>
<?php require("footer.php"); ?>

