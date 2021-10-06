<?php
/** @var $dbh PDO */
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if (!isset($_GET['category_id'])) {
    header("Location: category.php");
    die();
}
?>
<html
<head>
</head>
<body>
<h1>Delete client</h1>
<?php
include("connection.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    $query = "DELETE FROM `category` WHERE `category_id`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['category_id']])) {
        echo "Category #" . $_GET['category_id'] . " has been deleted. ";
        echo "<button onclick=\"window.location='category.php'\">Back to the category list</button>";
    } else {
        echo friendlyError($stmt->errorInfo()[2]);
        echo "<button onclick=\"window.history.back()\">Back to previous page</button>";
        die();
    }
} else {
    $query = "SELECT * FROM `category` WHERE `category_id`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['category_id']])) {
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetchObject(); ?>
            <form method="post">
                <label for="id">ID</label>
                <input type="number" id="id" value="<?= $row->category_id ?>" disabled/><br>
                <label for="firstname">Name</label>
                <input type="text" id="name" value="<?= $row->category_name ?>" disabled/><br>
                <input type="submit" name="action" id="delete-button" value="Delete"/>
                <button type="button" onclick="window.location='category.php';return false;">Cancel</button>
            </form>
        <?php } else {
            header("Location: category.php");
        }
    } else {
        die(friendlyError($stmt->errorInfo()[2]));
    }
} ?>
</body>
</html>
