<?php
ob_start();
/** @var $dbh PDO */
require("header.php");
?>
<title>Update photo_shoot #<?= $_GET['photo_shoot_name'] ?></title>
<h3 class="mx-sm-3">Update photo_shoot #<?= $_GET['photo_shoot_name'] ?></h3>
<body>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if (!empty($_POST)) {
    $query = "UPDATE `photo_shoot` SET `client_id`=:client_id, `photo_shoot_description`=:photo_shoot_description, `photo_shoot_date`=:photo_shoot_date,
      `photo_shoot_quote`=:photo_shoot_quote, `photo_shoot_other_information`=:photo_shoot_other_information WHERE `photo_shoot_name`=:photo_shoot_name;";
    $stmt = $dbh->prepare($query);
    $parameters = [
        'client_id'=>$_POST['client_id'],
        'photo_shoot_name'=>$_GET['photo_shoot_name'],
        'photo_shoot_description'=>$_POST['photo_shoot_description'],
        'photo_shoot_date'=>$_POST['photo_shoot_date'],
        'photo_shoot_quote'=>$_POST['photo_shoot_quote'],
        'photo_shoot_other_information'=>$_POST['photo_shoot_other_information'],
    ];
    if ($stmt->execute($parameters)) {
        header("Location: photoshoot.php");
    } else {
        echo friendlyError($stmt->errorInfo()[2]);
        echo "<div class=\"center row\"><button onclick=\"window.history.back()\">Back to previous page</button></div>";
        die();
    }
} else {
    $query = "SELECT * FROM `photo_shoot` WHERE `photo_shoot_name`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['photo_shoot_name']])) {
        if ($stmt->rowCount() > 0) {
            $record = $stmt->fetchObject(); ?>
            <form method="post">
                <div class="form-group">
                    <div class="row">
                        <?php $client_stmt = $dbh->prepare("SELECT * FROM `client` ORDER BY `client_id`");
                        if ($client_stmt->execute() && $client_stmt->rowCount() > 0) { ?>
                            <label for="client_id" class="mx-sm-3">Client</label>
                            <select name="client_id" id="client_id" class="form-control-sm mx-sm-4 mb-2 w-25">
                                <?php while ($row = $client_stmt->fetchObject()): ?>
                                    <option value="<?= $row->client_id ?>"><?= $row->client_firstname?><pre>  </pre> <?= $row->client_lastname ?></option>
                                <?php endwhile; ?>
                            </select>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <label for="photo_shoot_name" class="mx-sm-3">Name</label>
                        <input type="text" id="photo_shoot_name" name="photo_shoot_name" class="form-control-sm mx-sm-4 mb-2 w-25" required value="<?= $record->photo_shoot_name ?>" />
                    </div>
                    <div class="row">
                        <label for="photo_shoot_description" class="mx-sm-3">Description</label>
                        <input type="text" id="photo_shoot_description" name="photo_shoot_description" class="form-control-sm mx-sm-4 mb-2 w-25" required value="<?= $record->photo_shoot_description ?>" />
                    </div>
                    <div class="row">
                        <label for="photo_shoot_date" class="mx-sm-3">Date</label>
                        <input type="date" id="photo_shoot_date" name="photo_shoot_date" class="form-control-sm mx-sm-4 mb-2 w-25" required value="<?= $record->photo_shoot_date ?>" />
                    </div>
                    <div class="row">
                        <label for="photo_shoot_quote" class="mx-sm-3">Quote</label>
                        <input type="text" id="photo_shoot_quote" name="photo_shoot_quote" class="form-control-sm mx-sm-4 mb-2 w-25" required value="<?= $record->photo_shoot_quote ?>" />
                    </div>
                    <div class="row">
                        <label for="photo_shoot_other_information" class="mx-sm-3">Other Information</label>
                        <textarea type="text" id="photo_shoot_other_information" name="photo_shoot_other_information" class="form-control-sm mx-sm-4 mb-2 w-25" rows="5" value="<?= $record->photo_shoot_other_information ?>"></textarea></>
                    </div>
                </div>
                <div class="row">
                    <input type="submit" class="btn btn-outline-success w-25 mx-sm-4 mb-2" value="Update"/>
                </div>
                <div class="row">
                    <button type="button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" onclick="window.location='photoshoot.php';return false;">Cancel</button>
                </div>
            </form>
        <?php } else {
            header("Location: photoshoot.php");
        }
    } else {
        die(friendlyError($stmt->errorInfo()[2]));
    }
}
require("footer.php");
?>


