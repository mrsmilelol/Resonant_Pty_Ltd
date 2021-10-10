<?php
session_start();

$db_name = "fit2104_ass2";
$db_host = "localhost";
$db_username = "fit2104";
$db_passwd = "fit2104";
$dsn = "mysql:host=$db_host;dbname=$db_name";
$dbh = new PDO($dsn, $db_username, $db_passwd);

$PAGE_ALLOWGUEST = isset($PAGE_ALLOWGUEST) ? $PAGE_ALLOWGUEST : false;

if (!isset($PAGE_ID) || $PAGE_ID !== 'login') {
    if (!isset($_SESSION['id'])) {
        $_SESSION['referer'] = $_SERVER['PHP_SELF'];
        if (!$PAGE_ALLOWGUEST) {
            header("Location: login.php");
            exit();
        }
    } else {
        $user_stmt = $dbh->prepare("SELECT * FROM `user` WHERE `id` = ?");
        if ($user_stmt->execute([$_SESSION['id']]) && $user_stmt->rowCount() == 1) {
            $user = $user_stmt->fetchObject();
            $PAGE_USERNAME = $user->username;
        } else {
            session_destroy();
            header("Location: login.php?action=error&message=" . urlencode('It seems your account is being invalidated. Please contact administrator for more information.'));
            exit();
        }
    }
}
