<?php
/** @var $dbh PDO */
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
require("header.php");
?>
<title>Delete Photo-shoot</title>
    <body>
    <h3 class="mx-sm-3">Delete Photo-shoot</h3>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
        $query = "DELETE FROM `photo_shoot` WHERE `photo_shoot_name`=?";
        $stmt = $dbh->prepare($query);
        if ($stmt->execute([$_GET['photo_shoot_name']])) {
            echo "<span class=\"mx-sm-3\"> Photo-shoot is successfully deleted</span> ";
            echo "<div class=\"row\"><button  class=\"btn btn-outline-info w-25 mx-sm-4 mb-2\"  onclick=\"window.location='photoshoot.php'\">Back to the photo-shoot list</button></div>";
        } else {
            echo friendlyError($stmt->errorInfo()[2]);
            echo "<button onclick=\"window.history.back()\">Back to previous page</button>";
            die();
        }
    } else {
        $query = "SELECT * FROM `photo_shoot` WHERE `photo_shoot_name`=?";
        $stmt = $dbh->prepare($query);
        if ($stmt->execute([$_GET['photo_shoot_name']])) {
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetchObject(); ?>
                <form method="post">
                    <div class="row">
                        <label for="id" class="mx-sm-3">Client ID</label>
                        <input type="number" id="id" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $row->client_id ?>"/>
                    </div>
                    <div class="row">
                        <label for="name" class="mx-sm-3">Name</label>
                        <input type="text" id="name" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $row->photo_shoot_name ?>" />
                    </div>
                    <div class="row">
                        <label for="description" class="mx-sm-3">Description</label>
                        <input type="text" id="description" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $row->photo_shoot_description ?>" />
                    </div>
                    <div class="row">
                        <label for="date" class="mx-sm-3">Date</label>
                        <input type="date" id="date" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $row->photo_shoot_date ?>" />
                    </div>
                    <div class="row">
                        <label for="quote" class="mx-sm-3">Quote</label>
                        <input type="text" id="quote" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $row->photo_shoot_quote ?>" />
                    </div>
                    <div class="row">
                        <label for="other_information" class="mx-sm-3">Other Information</label>
                        <textarea type="text" id="other_information" class="form-control-sm mx-sm-4 mb-2 w-25" readonly value="<?= $row->photo_shoot_other_information ?>"></textarea>                    </div>
                    <div class="row">
                        <input type="submit" name="action" id="delete-button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" value="Delete"/>
                    </div>
                    <div class="row">
                        <button type="button" class="btn btn-outline-info w-25 mx-sm-4 mb-2" onclick="window.location='photoshoot.php';return false;">Cancel</button>
                    </div>
                </form>
            <?php } else {
                header("Location: photoshoot.php");
            }
        } else {
            die(friendlyError($stmt->errorInfo()[2]));
        }
    } ?>
    </body>
    </html>
<?php require("footer.php") ?>
