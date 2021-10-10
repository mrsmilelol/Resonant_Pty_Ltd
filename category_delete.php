<?php
/** @var $dbh PDO */
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
require("header.php");
if (!isset($_GET['category_id'])) {
    header("Location: category.php");
    die();
}
?>
<title>Delete client</title>
<body>
<h3 class="mx-sm-3">Delete client</h3>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    $query = "DELETE FROM `category` WHERE `category_id`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['category_id']])) {
        header("Location:category.php");
        exit();
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
                <div class="row">
                    <label for="id" class="mx-sm-3">ID</label>
                    <input type="number" id="id" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $row->category_id ?>"/>
                </div>
                <div class="row">
                    <label for="category_name" class="mx-sm-3">Name</label>
                    <input type="text" id="name" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $row->category_name ?>"/>
                </div>
                </div>
                <div class="row">
                    <input type="submit" name="action" id="delete-button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" value="Delete"/>
                </div>
                <div class="row">
                    <button type="button" class="btn btn-outline-info w-25 mx-sm-4 mb-2" onclick="window.location='category.php';return false;">Cancel</button>
                </div>
            </form>
        <?php } else {
            header("Location: category.php");
        }
    } else {
        die(friendlyError($stmt->errorInfo()[2]));
    }
} ?>
<?php require("footer.php"); ?>