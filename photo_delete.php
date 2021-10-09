<?php
/** @var $dbh PDO */
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');

?>
    <html
    <head>
    </head>
    <body>
    <h1>Delete Photoshoot</h1>
    <?php
    include("connection.php");
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
        $query = "DELETE FROM `photo_shoot` WHERE `photo_shoot_name`=?";
        $stmt = $dbh->prepare($query);
        if ($stmt->execute([$_GET['photo_shoot_name']])) {
            echo "Photo-shoot #" . $_GET['photo_shoot_name'] . " has been deleted. ";
            echo "<button onclick=\"window.location='photoshoot.php'\">Back to the photo-shoot list</button>";
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
                    <div>
                        <label for="id">ID</label>
                        <input type="number" id="id" value="<?= $row->client_id ?>" disabled/>
                    </div>
                    <div>
                        <label for="name">Name</label>
                        <input type="text" id="name" value="<?= $row->photo_shoot_name ?>" disabled/>
                    </div>
                    <div>
                        <label for="description">Description</label>
                        <input type="text" id="description" value="<?= $row->photo_shoot_description ?>" disabled/>
                    </div>
                    <div>
                        <label for="date">Date</label>
                        <input type="date" id="date" value="<?= $row->photo_shoot_date ?>" disabled/>
                    </div>
                    <div>
                        <label for="quote">Quote</label>
                        <input type="text" id="quote" value="<?= $row->photo_shoot_quote ?>" disabled/>
                    </div>
                    <div>
                        <label for="other_information">Other Information</label>
                        <input type="text" id="other_information" value="<?= $row->photo_shoot_other_information ?>" disabled/><br>
                    </div>
                    <input type="submit" name="action" id="delete-button" value="Delete"/>
                    <button type="button" onclick="window.location='photoshoot.php';return false;">Cancel</button>
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
<?php
