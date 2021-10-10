<?php
ob_start();
/** @var $dbh PDO */
/** @var $db_name string */
/** @var object $product Product details */
require("header.php");
?>

<title>Photo-shoot</title>
<body>
<h2 class="mx-sm-3">Details of photo-shoot "<?=$_GET['photo_shoot_name']  ?>"</h2>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if (isset($_GET['photo_shoot_name'])) {
    $stmt = $dbh->prepare("SELECT * FROM `photo_shoot` INNER JOIN `client` ON photo_shoot.client_id = client.client_id WHERE photo_shoot_name = ? ORDER BY client_firstname, client_lastname;");
    if ($stmt->execute([$_GET['photo_shoot_name']])) {
        if ($stmt->rowCount()>0) {
            $photo = $stmt->fetchObject();}
    }
}
?>
<form method="post">
    <div class="form-group">
        <div class="row">
            <label for="client_id" class="mx-sm-3">Client ID</label>
            <input type="number" id="client_id" name="client_id" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $photo->client_id ?>" >
        </div>
        <div class="row">
            <label for="client_firstname" class="mx-sm-3">Client First Name</label>
            <input type="text" id="client_firstname" name="client_firstname" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $photo->client_firstname ?>" >
        </div>
        <div class="row">
            <label for="client_lastname" class="mx-sm-3">Client Last Name</label>
            <input type="text" id="client_lastname" name="client_lastname" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $photo->client_lastname ?>" >
        </div>
        <div class="row">
            <label for="photo_shoot_name" class="mx-sm-3">Photo-shoot Name</label>
            <input type="text" id="photo_shoot_name" name="photo_shoot_name" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $photo->photo_shoot_name ?>" >
        </div>
        <div class="row">
            <label for="photo_shoot_description" class="mx-sm-3">Description</label>
            <input type="text" id="photo_shoot_description" name="photo_shoot_description" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $photo->photo_shoot_description ?>" >
        </div>
        <div class="row">
            <label for="photo_shoot_date" class="mx-sm-3">Date</label>
            <input type="date" id="photo_shoot_date" name="photo_shoot_date" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $photo->photo_shoot_date ?>" >
        </div>
        <div class="row">
            <label for="photo_shoot_quote" class="mx-sm-3">Quote</label>
            <input type="text" id="photo_shoot_quote" name="photo_shoot_quote" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $photo->photo_shoot_quote ?>" >
        </div>
        <div class="row">
            <label for="photo_shoot_other_information" class="mx-sm-3">Other Information</label>
            <textarea type="text" id="photo_shoot_other_information" name="photo_shoot_other_information" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $photo->photo_shoot_other_information ?>" ></textarea>
        </div>

    </div>
</form>
<?php require("footer.php");?>

