<?php
ob_start();
/** @var $dbh PDO */


?>
<html
<head>
    <title>Update photo_shoot #<?= $_GET['photo_shoot_name'] ?></title>
</head>
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
                <div class="aligned-form">
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
                        <input type="text" id="photo_shoot_name" name="photo_shoot_name" value="<?= $record->photo_shoot_name ?>" />
                    </div>
                    <div class="row">
                        <label for="photo_shoot_description">Description</label>
                        <input type="text" id="photo_shoot_description" name="photo_shoot_description" value="<?= $record->photo_shoot_description ?>" />
                    </div>
                    <div class="row">
                        <label for="photo_shoot_date">Date</label>
                        <input type="date" id="photo_shoot_date" name="photo_shoot_date" value="<?= $record->photo_shoot_date ?>" />
                    </div>
                    <div class="row">
                        <label for="photo_shoot_quote">Quote</label>
                        <input type="text" id="photo_shoot_quote" name="photo_shoot_quote" value="<?= $record->photo_shoot_quote ?>" />
                    </div>
                    <div class="row">
                        <label for="photo_shoot_other_information">Other Information</label>
                        <input type="text" id="photo_shoot_other_information" name="photo_shoot_other_information" value="<?= $record->photo_shoot_other_information ?>" />
                    </div>
                </div>
                <div class="row center">
                    <input type="submit" value="Update"/>
                    <button type="button" onclick="window.location='photoshoot.php';return false;">Cancel</button>
                </div>
            </form>
        <?php } else {
            header("Location: photoshoot.php");
        }
    } else {
        die(friendlyError($stmt->errorInfo()[2]));
    }
}
?>
</body>
</html>
