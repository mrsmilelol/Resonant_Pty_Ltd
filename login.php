<?php
ob_start(); // To allow setting header when there's already page contents rendered
$PAGE_ID = "login";
$dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2','fit2104','fit2104');

// Database connection
require('connection.php');
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        //Run some SQL query here to find that user
        $stmt = $dbh->prepare("SELECT * FROM `user` WHERE `username` = ? AND `password` = ?");
        if ($stmt->execute([
                $_POST['username'],
                hash('sha256', $_POST['password'])
            ]) && $stmt->rowCount() == 1) {
            $row = $stmt->fetchObject();
            $_SESSION['user_id'] = $row->id;
            //Successfully logged in, redirect user to referer, or index page
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
    <title>Login</title>
</head>
<body>
<h1>Please Login</h1>
<h2>Please enter your username and password</h2>
<form class="user" method="post">
    <div>
        <input type="text" id="loginUsername" name="username" placeholder="Username">
    </div>
    <div>
        <input type="password" id="loginUserPassword" name="password" placeholder="Password">
    </div>
    <button type="submit" >Login</button>
</form>
</body>
