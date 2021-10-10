<?php
ob_start();
$PAGE_ID = "login";
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');
require("start.php");
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $stmt = $dbh->prepare("SELECT * FROM `user` WHERE `username` = ? AND `password` = ?");
        if ($stmt->execute([
                $_POST['username'],
                hash('sha256', $_POST['password'])
            ]) && $stmt->rowCount() == 1) {
            $row = $stmt->fetchObject();
            $_SESSION['id'] = $row->id;
            if (empty($_SESSION['referer'])) {
                header("Location: index.php");
            } else {
                header("Location: " . $_SESSION['referer']);
            }
        } else {
            header("Location: login.php?action=error&message=" . urlencode('Your username and/or password is incorrect. Please try again!'));
        }
        exit();
    } else {
        header("Location: login.php?action=error&message=" . urlencode('Please enter both username and password to login!'));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
<div class="row justify-content-center">
    <div class="col-xl-5 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Please login</h1>
                            <form class="user" method="post" >
                                <div class="mb-3 text-center">
                                    <label class="form-label">Username</label>
                                    <input type="text" id="loginUsername" class="form-control " name="username" placeholder="Username">
                                </div>
                                <div class="mb-3 text-center">
                                    <label class="form-label">Password</label>
                                    <input type="password" id="loginUserPassword" class="form-control" name="password" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-secondary" >Login</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</body>
</html>
