<?php
ob_start();
/** @var $dbh PDO */
/** @var $db_name string */
include("connection.php")
?>
<!doctype html>
<html>
<head>
    <title>Add new category</title>
</head>
<body>
<h1>Add new category</h1>
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
                            <label for="id">ID</label>
                            <input type="number" id="id" value="<?= $record->category_id ?>" disabled/>
                        </div>
                        <div class="row">
                            <label for="firstname">Name</label>
                            <input type="text" id="name" value="<?= $record->category_name ?>" disabled/>
                        </div>
                    </div>
                </form>
                <div class="center row">
                    <button onclick="window.location='category.php'">Back to the client list</button>
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
    $query = "SELECT AUTO_INCREMENT FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME='category'";
    $stmt = $dbh->prepare($query);
    $nextId = ($stmt->execute() || $stmt->rowCount() > 0) ? $stmt->fetchObject()->AUTO_INCREMENT : "Not available";
    ?>
    <form method="post">
        <div class="aligned-form">
            <div class="row">
                <label for="category_id">ID</label>
                <input type="number" id="category_id" value="<?= $nextId ?>" disabled/>
            </div>
            <div class="row">
                <label for="category_name">Name</label>
                <input type="text" id="category_name" name="category_name"/>
            </div>
        </div>
        <div class="row center">
            <input type="submit" value="Add"/>
            <button type="button" onclick="window.location='category.php';return false;">Cancel</button>
        </div>
    </form>
<?php } ?>
</body>
</html>