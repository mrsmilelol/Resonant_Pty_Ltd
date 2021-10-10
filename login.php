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
<h1>Please Login</h1>
<h2>Please enter your username and password</h2>
<form class="user" method="post" >
    <div class="mb-3">
        <input type="text" id="loginUsername" name="username" placeholder="Username">
    </div>
    <div>
        <input type="password" id="loginUserPassword" name="password" placeholder="Password">
    </div>
    <button type="submit" >Login</button>
</form>
</body>
</html>
