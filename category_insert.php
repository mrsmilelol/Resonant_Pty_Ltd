<?php
ob_start();
/** @var $dbh PDO */
/** @var $db_name string */
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
require("header.php");
?>
<title>Add new category</title>
<h3 class="mx-sm-3">Add new category</h3>
<?php
if(!empty($_POST)){
    $query = "INSERT INTO category (`category_name`) VALUES (?)";
    $stmt = $dbh->prepare($query);
    $parameters = [
        $_POST['category_name']];

    if ($stmt->execute($parameters)) {
        $newRecordId = $dbh->lastInsertId();
        $query = "SELECT * FROM category WHERE `category_id`=?";
        $stmt = $dbh->prepare($query);
        if ($stmt->execute([$newRecordId])) {
            if ($stmt->rowCount() > 0) {
                $record = $stmt->fetchObject(); ?>
                <div class="center row">New category has been added.</div>
                <form method="post">
                    <div class="aligned-form">
                        <div class="row">
                            <label for="id" class="mx-sm-3">ID</label>
                            <input type="number" id="id" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $record->category_id ?>" />
                        </div>
                        <div class="row">
                            <label for="category_name" class="mx-sm-3">Name</label>
                            <input type="text" id="name" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $record->category_name ?>" />
                        </div>
                    </div>
                </form>
                <div class="center row">
                    <button class="btn btn-outline-info w-25 mx-sm-4 mb-2" onclick="window.location='category.php'">Back to the client list</button>
                </div>
            <?php } else {
                echo "Weird, the category just added has mysteriously disappeared!? ";
                echo "<div class=\"center row\"><button onclick=\"window.location='category.php'\">Back to the category list</button></div>";
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
    $query = "SELECT AUTO_INCREMENT FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'fit2104_ass2' AND TABLE_NAME='category'";
    $stmt = $dbh->prepare($query);
    $nextId = ($stmt->execute() || $stmt->rowCount() > 0) ? $stmt->fetchObject()->AUTO_INCREMENT : "Not available";
    ?>
    <form method="post">
        <div class="form-group">
            <div class="row">
                <label for="category_id" class="mx-sm-3">ID</label>
                <input type="number" id="category_id" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $nextId ?>"/>
            </div>
            <div class="row">
                <label for="category_name" class="mx-sm-3">Name</label>
                <input type="text" id="category_name" class="form-control-sm mx-sm-4 mb-2 w-25" required name="category_name"/>
            </div>
        </div>
        <div class="row">
            <input type="submit" class="btn btn-outline-success w-25 mx-sm-4 mb-2" value="Add"/>
        </div>
        <div class="row">
            <button type="button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" onclick="window.location='category.php';return false;">Cancel</button>
        </div>
    </form>
<?php } ?>
</body>
</html>