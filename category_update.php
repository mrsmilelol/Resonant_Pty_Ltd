<?php
ob_start();
/** @var $dbh PDO */
require("header.php");
if (!isset($_GET['category_id'])) {
    header("Location:category.php");
    die();
}
?>
<title>Update category #<?= $_GET['category_id'] ?></title>
<h3 class="mx-sm-3">Update category #<?= $_GET['category_id'] ?></h3>
<body>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if (!empty($_POST)) {
    $query = "UPDATE `category` SET `category_name`=:category_name WHERE `category_id`=:category_id;";
    $stmt = $dbh->prepare($query);
    $parameters = [
        'category_name'=>$_POST['category_name'],
        'category_id'=>$_GET['category_id']
    ];
    if ($stmt->execute($parameters)) {
        header("Location: category.php");
    } else {
        echo friendlyError($stmt->errorInfo()[2]);
        echo "<div class=\"center row\"><button onclick=\"window.history.back()\">Back to previous page</button></div>";
        die();
    }
} else {
    $query = "SELECT * FROM `category` WHERE `category_id`=?";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute([$_GET['category_id']])) {
        if ($stmt->rowCount() > 0) {
            $record = $stmt->fetchObject(); ?>
            <form method="post">
                <div class="form-group">
                    <div class="row">
                        <label for="id" class="mx-sm-3">ID</label>
                        <input type="number" id="category_id" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $record->category_id ?>"/>
                    </div>
                    <div class="row">
                        <label for="name" class="mx-sm-3">Name</label>
                        <input type="text" id="category_name" name="category_name" class="form-control-sm mx-sm-4 mb-2 w-25" required value="<?= $record->category_name ?>" />
                    </div>
                </div>
                <div class="row">
                    <input class="btn btn-outline-success w-25 mx-sm-4 mb-2" type="submit" value="Update"/>
                </div>
                <div class="row">
                    <button type="button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" onclick="window.location='category.php';return false;">Cancel</button>
                </div>
            </form>
        <?php } else {
            header("Location: category.php");
        }
    } else {
        die(friendlyError($stmt->errorInfo()[2]));
    }
}
?>
<?php require("footer.php");?>
