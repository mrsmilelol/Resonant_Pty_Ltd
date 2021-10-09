<?php
ob_start();
/** @var $dbh PDO */
/** @var $db_name string */
/** @var object $product Product details */

?>
    <!doctype html>
    <html>
    <head>
        <title>Photo-shoot</title>
    </head>
    <body>
    <h1>Details of photo-shoot "<?=$_GET['photo_shoot_name']  ?>"</h1>
    <?php
    $dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
    if (isset($_GET['photo_shoot_name'])) {
        $stmt = $dbh->prepare("SELECT * FROM `photo_shoot` INNER JOIN `client` ON photo_shoot.client_id = client.client_id WHERE photo_shoot_name = ? ORDER BY client_firstname, client_lastname;");
        if ($stmt->execute([$_GET['photo_shoot_name']])) {
            if ($stmt->rowCount() == 1) {
                $photo = $stmt->fetchObject();}

            $photo_fetched = true;
        }
    }

    ?>
    <form method="post">
        <div class="aligned-form">
            <div class="row">
                <label for="client_id">Client ID</label>
                <input type="number" readonly id="client_id" name="client_id" value="<?= $photo->client_id ?>" disabled>
            </div>
            <div class="row">
                <label for="client_firstname">Client First Name</label>
                <input type="text" readonly id="client_firstname" name="client_firstname" value="<?= $photo->client_firstname ?>" disabled>
            </div>
            <div class="row">
                <label for="client_lastname">Client Last Name</label>
                <input type="number" readonly id="client_lastname" name="client_lastname" value="<?= $photo->client_lastname ?>" disabled>
            </div>
            <div class="row">
                <label for="photo_shoot_name">Photo-shoot Name</label>
                <input type="text" readonly id="photo_shoot_name" name="photo_shoot_name" value="<?= $photo->photo_shoot_name ?>" disabled>
            </div>
            <div class="row">
                <label for="photo_shoot_description">Description</label>
                <input type="text" readonly id="photo_shoot_description" name="photo_shoot_description" value="<?= $photo->photo_shoot_description ?>" disabled>
            </div>
            <div class="row">
                <label for="photo_shoot_date">Date</label>
                <input type="date" readonly id="photo_shoot_date" name="photo_shoot_date" value="<?= $photo->photo_shoot_date ?>" disabled>
            </div>
            <div class="row">
                <label for="photo_shoot_quote">Quote</label>
                <input type="text" readonly id="photo_shoot_quote" name="photo_shoot_quote" value="<?= $photo->photo_shoot_quote ?>" disabled>
            </div>
            <div class="row">
                <label for="photo_shoot_other_information">Other Information</label>
                <input type="text" readonly id="photo_shoot_other_information" name="photo_shoot_other_information" value="<?= $photo->photo_shoot_other_information ?>" disabled>
            </div>

        </div>
    </form>
    <?php ?>
    </body>
    </html>
