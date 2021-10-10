<?php
ob_start();
/** @var $dbh PDO */
require("header.php")
?>
<title>Add new product</title>
<h3 class="mx-sm-3">Add new product</h3>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );
    $allowedMIME = array(
        'image/jpeg',
        'image/png',
        'image/gif'
    );
    if(!empty($_POST)){
        $serverSideErrors = [];
        $product_image_filenames = [];
        $dbh->beginTransaction();
        $query = "INSERT INTO `product` (`product_upc`, `product_name`, `product_price`,`category_id`) VALUES (:product_upc, :product_name, :product_price, :category_id)";
        $stmt = $dbh->prepare($query);
        $parameters = [
            'product_upc' => $_POST['product_upc'],
            'product_name'=>$_POST['product_name'],
            'product_price'=>$_POST['product_price'],
            'category_id'=>$_POST['category_id']
        ];
        if ($stmt->execute($parameters)) {
            if (!(isset($_FILES['images']['error'][0]) && $_FILES['images']['error'][0] == 4)) {
                // Check if any of the files has error during upload
                foreach ($_FILES['images']['error'] as $index => $error) {
                    if ($error != 0) {
                        $serverSideErrors[] = "File '" . $_FILES['images']['name'][$index] . "' did not upload because: " . $phpFileUploadErrors[$error];
                        break;
                    }
                }

                foreach ($_FILES['images']['type'] as $index => $type) {
                    if (!empty($type) && !in_array($type, $allowedMIME)) {
                        $serverSideErrors[] = "The type of file '" . $_FILES['images']['name'][$index] . "' (" . $type . ") is not allowed";
                        break;
                    }
                }

                if (empty($serverSideErrors)) {
                    foreach ($_FILES['images']['name'] as $index => $product_image_filename) {
                        $query = "INSERT INTO `product_image`(`product_upc`, `product_image_filename`) VALUES (?, ?)";
                        $stmt = $dbh->prepare($query);
                        $currentFileName = uniqid('product_' . $_POST['product_upc'] . '_', true) . "." . pathinfo($product_image_filename, PATHINFO_EXTENSION);
                        if ($stmt->execute([$_POST['product_upc'], $currentFileName])) {
                            $product_image_filenames[$index] = $currentFileName;
                        } else {
                            $serverSideErrors[] = $stmt->errorInfo()[2];
                            break;
                        }
                    }
                }

                if (empty($serverSideErrors)) {
                    foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
                        if (!move_uploaded_file($tmp_name, "product_images" . DIRECTORY_SEPARATOR . $product_image_filenames[$index])) {
                            $serverSideErrors[] = "Failed to save image files to the filesystem.";
                            break;
                        }
                    }
                }
            }
        } else {
            $serverSideErrors[] = $stmt->errorInfo()[2];
        }

        if (empty($serverSideErrors)) {
            $dbh->commit();
            header("Location: product.php");
            exit();
        } else {
            $dbh->rollBack();
            $ERROR = implode("</li><li>", $serverSideErrors);
        }

    } else {
        $ERROR = "The request is invalid. This may be due to the uploaded files are too large to process.";
    }
}
?>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <div class="row">
            <label for="product_upc" class="mx-sm-3">UPC</label>
            <input type="number" id="product_upc" class="form-control-sm mx-sm-4 mb-2 w-25" name="product_upc" required/>
        </div>
        <div class="row">
            <label for="product_name" class="mx-sm-3">Product Name</label>
            <input type="text" id="product_name" class="form-control-sm mx-sm-4 mb-2 w-25" name="product_name" required>
        </div>
        <div class="row">
            <label for="product_price" class="mx-sm-3">Product Price</label>
            <input type="number" id="product_price" class="form-control-sm mx-sm-4 mb-2 w-25" name="product_price" required>
        </div>
        <div class="row">
            <?php $category_stmt = $dbh->prepare("SELECT * FROM `category` ORDER BY `category_name`");
            if ($category_stmt->execute() && $category_stmt->rowCount() > 0) { ?>
                <label for="category_id" class="mx-sm-3">Category</label>
                <select name="category_id" id="category_id" class="form-control-sm mx-sm-4 mb-2 w-25">
                    <?php while ($row = $category_stmt->fetchObject()): ?>
                        <option value="<?= $row->category_id ?>"><?= $row->category_name ?></option>
                    <?php endwhile; ?>
                </select>
            <?php } ?>
        </div>
        <div class="row">
            <label for="productImage" class="mx-sm-3">Product images</label>
            <div class="custom-file mx-sm-3 mb-2">
                <input type="file" class="custom-file-input" id="productProductImages" name="images[]" multiple>
                <label class="custom-file-label" for="customFile"></label>
            </div>
            <div class="row center">
                <input type="submit" class="btn btn-outline-success w-25 mx-sm-4 mb-2" value="Add"/>
                <button type="button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" onclick="window.location='product.php';return false;">Cancel</button>
            </div>
</form>
<?php require("footer.php")?>
