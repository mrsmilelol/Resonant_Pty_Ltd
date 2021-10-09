<?php
ob_start();
/** @var $dbh PDO */
/** @var $db_name string */
include("connection.php");
?>
<!doctype html>
<html>
<head>
    <title>Add new photo shoot</title>
</head>
<body>
<h1>Add new photo shoot</h1>
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
        $query = "SELECT * FROM photo_shoot INNER JOIN client ON photo_shoot.client_id = client.client_id WHERE `client_id`=? ORDER BY client_firstname, client_lastname";
        $stmt = $dbh->prepare($query);
        if ($stmt->rowCount() > 0) {
            $record = $stmt->fetchObject(); ?>
            <div class="center row">New photo shoot has been added.</div>
            <form method="post">
                <div class="aligned-form">
                    <div class="row">
                        <label for="id">ID</label>
                        <input type="number" id="id" value="<?= $record->client_id ?>" disabled/>
                    </div>
                    <div class="row">
                        <label for="photo_shoot_name">Name</label>
                        <input type="text" id="photo_shoot_name" value="<?= $record->photo_shoot_name ?>" disabled/>
                    </div>
                    <div class="row">
                        <label for="photo_shoot_description">Description</label>
                        <input type="text" id="photo_shoot_description" value="<?= $record->photo_shoot_description ?>" disabled/>
                    </div>
                    <div class="row">
                        <label for="photo_shoot_date">Date</label>
                        <input type="date" id="photo_shoot_date" value="<?= $record->photo_shoot_date ?>" disabled/>
                    </div>
                    <div class="row">
                        <label for="photo_shoot_quote">Quote</label>
                        <input type="text" id="photo_shoot_quote" value="<?= $record->photo_shoot_quote ?>" disabled/>
                    </div>
                    <div class="row">
                        <label for="photo_shoot_other_information">Other Information</label>
                        <input type="text" id="photo_shoot_other_information" value="<?= $record->photo_shoot_other_information ?>" disabled/>
                    </div>
                </div>
            </form>
            <div class="center row">
                <button onclick="window.location='photoshoot.php'">Back to the photos-hoot list</button>
            </div>
        <?php } else {
            echo " New photo-shoot is successfully added ";
            echo "<div class=\"center row\"><button onclick=\"window.location='photoshoot.php'\">Back to the photo-shoot list</button></div>";
        }
    } else {
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
                <label for="client_id">Client</label>
                <select name="client_id" id="client_id">
                    <?php while ($row = $client_stmt->fetchObject()): ?>
                        <option value="<?= $row->client_id ?>"><?= $row->client_firstname?><pre>  </pre> <?= $row->client_lastname ?></option>
                    <?php endwhile; ?>
                </select>
            <?php } ?>">
        </div>
        <div class="row">
            <label for="photo_shoot_name">Name</label>
            <input type="text" id="photo_shoot_name" name="photo_shoot_name"/>
        </div>
        <div class="row">
            <label for="photo_shoot_description">Description</label>
            <input type="text" id="photo_shoot_description" name="photo_shoot_description" />
        </div>
        <div class="row">
            <label for="photo_shoot_date">Date</label>
            <input type="date" id="photo_shoot_date" name="photo_shoot_date" />
        </div>
        <div class="row">
            <label for="photo_shoot_quote">Quote</label>
            <input type="text" id="photo_shoot_quote" name="photo_shoot_quote" ?>"/>
        </div>
        <div class="row">
            <label for="photo_shoot_other_information">Other Information</label>
            <input type="text" id="photo_shoot_other_information" name="photo_shoot_other_information" />
        </div>
        <div class="row center">
            <input type="submit" value="Add"/>
            <button type="button" onclick="window.location='photoshoot.php';return false;">Cancel</button>
        </div>
    </form>
<?php }?>
</body>
</html>