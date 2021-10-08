<?php
ob_start();
/** @var $dbh PDO */
if (!isset($_GET['category_id'])) {
    header("Location:category.php");
    die();
}
?>
<html
<head>
    <title>Update category #<?= $_GET['category_id'] ?></title>
</head>
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
                <div class="aligned-form">
                    <div class="row">
                        <label for="id">ID</label>
                        <input type="number" id="category_id" value="<?= $record->category_id ?>" disabled/>
                    </div>
                    <div class="row">
                        <label for="name">Name</label>
                        <input type="text" id="category_name" name="category_name" value="<?= $record->category_name ?>" />
                    </div>
                </div>
                <div class="row center">
                    <input type="submit" value="Update"/>
                    <button type="button" onclick="window.location='category.php';return false;">Cancel</button>
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
</body>
</html>
