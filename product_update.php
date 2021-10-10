<?php
ob_start();
/** @var $dbh PDO */
/** @var $db_name string */
/** @var object $product Product details */
/** @var object $product_images Product images */
require("header.php")
?>
<title>Update a product</title>
<body>
<h3 class="mx-sm-3">Update a product</h3>
<?php
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
if (isset($_GET['product_upc'])) {
    $stmt = $dbh->prepare("SELECT * FROM `product` INNER JOIN `category` ON product.category_id = category.category_id WHERE product_upc = ? ORDER BY category_name;");
    if ($stmt->execute([$_GET['product_upc']])) {
        if ($stmt->rowCount() == 1) {
            $product = $stmt->fetchObject();
            $product_images = [];
            $stmt = $dbh->prepare("SELECT * FROM `product_image` WHERE `product_upc` = ?");
            $stmt->execute([$_GET['product_upc']]);
            while ($image = $stmt->fetchObject()) {
                $product_images[] = $image;
            }

            $product_fetched = true;
        }
    }
}
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
        $query = "UPDATE `product` SET `product_name`=:product_name, `product_price`=:product_price,`category_id`=:category_id WHERE `product_upc`=:product_upc;";
        $stmt = $dbh->prepare($query);
        $parameters = [
            'product_name'=>$_POST['product_name'],
            'product_price'=>$_POST['product_price'],
            'category_id'=>$_POST['category_id'],
            'product_upc' => $_GET['product_upc']
        ];
        if ($stmt->execute($parameters)) {
            if (!(isset($_FILES['images']['error'][0]) && $_FILES['images']['error'][0] == 4)) {
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
            if (empty($serverSideErrors)) {
                if (isset($_POST['delete_images']) && !empty($_POST['delete_images'])) {
                    $query_placeholders = trim(str_repeat("?,", count($_POST['delete_images'])), ",");
                    $query = "DELETE FROM `product_image` WHERE `product_image_id` in (" . $query_placeholders . ")";
                    $stmt = $dbh->prepare($query);
                    if (!$stmt->execute($_POST['delete_images'])) {
                        $serverSideErrors[] = $stmt->errorInfo()[2];
                    }
                }
            }
            if (empty($serverSideErrors)) {
                $product_image_filenames = [];
                foreach ($product_images as $image) {
                    $product_image_filenames[$image->product_image_id] = $image->product_image_filename;
                }
                foreach ($_POST['delete_images'] as $delete_image_id) {
                    $fileFullPath = "product_images" . DIRECTORY_SEPARATOR . $product_image_filenames[$delete_image_id];
                    if (!unlink($fileFullPath)) {
                        $serverSideErrors[] = "File '" . $product_image_filenames[$delete_image_id] . "' cannot be deleted";
                        break;
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
<?php if (isset($ERROR)): ?>
    <div class="card mb-4 border-left-danger">
        <div class="card-body">Cannot modify the product due to the following error:<br><code>
                <ul>
                    <li><?= $ERROR ?></li>
                </ul>
            </code></div>
    </div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <div class="row">
            <label for="product_upc" class="mx-sm-3">UPC</label>
            <input type="number" id="product_upc" class="form-control-sm mx-sm-4 mb-2 w-25" name="product_upc" required value="<?= $product->product_upc ?>">
        </div>
        <div class="row">
            <label for="product_name" class="mx-sm-3">Product Name</label>
            <input type="text" id="product_name" class="form-control-sm mx-sm-4 mb-2 w-25" name="product_name" required value="<?= $product->product_name ?>">
        </div>
        <div class="row">
            <label for="product_price" class="mx-sm-3">Product Price</label>
            <input type="number" id="product_price" class="form-control-sm mx-sm-4 mb-2 w-25" name="product_price" required value="<?= $product->product_price ?>">
        </div>
        <div class="row">
            <?php $category_stmt = $dbh->prepare("SELECT * FROM `category` ORDER BY `category_name`");
            if ($category_stmt->execute() && $category_stmt->rowCount() > 0) { ?>
                <label for="category_id" class="mx-sm-3">Category</label>
                <select name="category_id" id="category_id" class=" form-control-sm mx-sm-4 mb-2 w-25">
                    <?php while ($row = $category_stmt->fetchObject()): ?>
                        <option value="<?= $row->category_id ?>"><?= $row->category_name ?></option>
                    <?php endwhile; ?>
                </select>
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="productImage" class="mx-sm-3">Product images</label>
            <div class="custom-file mx-sm-3" >
                <input type="file" class="custom-file-input" id="productProductImages" name="images[]" multiple>
                <label class="custom-file-label" for="customFile"></label>
            </div>
            <div class="form-group mt-2">
            <?php if (empty($product_images)): ?>
                <p class="mx-sm-3">This product has no images</p>
            <?php else: ?>
                <p class="mx-sm-3">Tick the box in front of each image to delete that image</p>
                <?php foreach ($product_images as $image): ?>
                    <div class="form-check form-check-inline mx-sm-4">
                        <input class="form-check-input" type="checkbox" id="productProductImageDelete-<?= $image->product_image_id ?>" name="delete_images[]" value="<?= $image->product_image_id ?>" <?= (isset($_POST['delete_images']) && in_array($image->product_image_id, $_POST['delete_images'])?"checked":"") ?>>
                        <label class="form-check-label" for="productProductImageDelete-<?= $image->product_image_id ?>"><img src="product_images/<?= $image->product_image_filename ?>" width="200" height="200" class="rounded mb-1 product-image-thumbnail" alt="Product Image"></label>
                    </div>
                <?php endforeach;
            endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <input class="btn btn-outline-success w-25 mx-sm-4 mb-2" type="submit" value="Update"/>
    </div>
    <div class="row">
        <button type="button" class="btn btn-outline-danger w-25 mx-sm-4 mb-2" onclick="window.location='product.php';return false;">Cancel</button>
    </div>
</form>
<?php require("footer.php")?>


