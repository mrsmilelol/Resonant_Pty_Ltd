<?php
ob_start();
/** @var $dbh PDO */
/** @var $db_name string */
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
require("header.php");
?>
<title>Add new photo shoot</title>
<body>
<h3 class="mx-sm-3">Add new photo shoot</h3>
<?php
if(!empty($_POST)){
    $query = "INSERT INTO photo_shoot (client_id, photo_shoot_name, photo_shoot_description,`photo_shoot_date`,`photo_shoot_quote`, photo_shoot_other_information) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $dbh->prepare($query);
    $parameters = [
        $_POST['client_id'],
        $_POST['photo_shoot_name'],
        $_POST['photo_shoot_description'],
        $_POST['photo_shoot_date'],
        $_POST['photo_shoot_quote'],
        $_POST['photo_shoot_other_information']];
    if ($stmt->execute($parameters)) {
        echo "<span class=\"mx-sm-3\"> New photo-shoot is successfully added</span> ";
        echo "<div class=\"row\"><button  class=\"btn btn-outline-info w-25 mx-sm-4 mb-2\"  onclick=\"window.location='photoshoot.php'\">Back to the photo-shoot list</button></div>";
    }
    else {
        die(friendlyError($stmt->errorInfo()[2]));
    }
}
else {
    $query = "SELECT * FROM photo_shoot INNER JOIN client ON photo_shoot.client_id = client.client_id WHERE `client_id`=? ORDER BY client_firstname, client_lastname";
    $stmt = $dbh->prepare($query);
    $record = $stmt->fetchObject();
    ?>
    <form method="post">
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
            <input type="text" id="photo_shoot_name" class="form-control-sm mx-sm-4 mb-2 w-25" name="photo_shoot_name" required/>
        </div>
        <div class="row">
            <label for="photo_shoot_description" class="mx-sm-3">Description</label>
            <input type="text" id="photo_shoot_description" class="form-control-sm mx-sm-4 mb-2 w-25" name="photo_shoot_description" required/>
        </div>
        <div class="row">
            <label for="photo_shoot_date" class="mx-sm-3">Date</label>
            <input type="date" id="photo_shoot_date" class="form-control-sm mx-sm-4 mb-2 w-25" name="photo_shoot_date" required/>
        </div>
        <div class="row">
            <label for="photo_shoot_quote" class="mx-sm-3">Quote</label>
            <input type="text" id="photo_shoot_quote" class="form-control-sm mx-sm-4 mb-2 w-25" name="photo_shoot_quote" required/>
        </div>
        <div class="row">
            <label for="photo_shoot_other_information" class="mx-sm-3">Other Information</label>
            <textarea type="text" id="photo_shoot_other_information" class="form-control-sm mx-sm-4 mb-2 w-25" rows="5" name="photo_shoot_other_information"></textarea>
        </div>
        <div class="row">
            <input type="submit" class="btn btn-outline-success w-25 mx-sm-4 mb-2" value="Add"/>
        </div>
        <div class="row">
            <button type="button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" onclick="window.location='photoshoot.php';return false;">Cancel</button>
        </div>
    </form>
<?php require("footer.php");}?>