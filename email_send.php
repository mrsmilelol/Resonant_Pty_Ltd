<?php
$PAGE_ID = "email";
$PAGE_HEADER = "Sending email to users";

include("connection.php");
/** @var PDO $dbh Database connection */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['subject'])) {
        $sendmail_error = true;
        echo "Subject cannot be empty";

    }
    if (empty($_POST['body'])) {
        $sendmail_error = true;
        echo "Message cannot be empty";

    }
    if (empty($_POST['client_ids'])) {
        echo "You much select at least one user";
        $sendmail_error = true;
        echo'You must select at least one user as recipient';
    }

    // Getting emails of selected users
    $query_placeholders = trim(str_repeat("?,", count($_POST['client_ids'])), ",");
    $query = "SELECT * FROM `client` WHERE `client_id` in (" . $query_placeholders . ")";
    $stmt = $dbh->prepare($query);
    if ($stmt->execute($_POST['client_ids'])) {
        if ($stmt->rowCount() != count($_POST['client_ids'])) {
            $sendmail_error = true;
            $sendmail_error_message = 'One of the selected user does not exist';
        } else {
            $email_recipients = [];
            while ($row = $stmt->fetchObject()) $email_recipients[] = $row->client_firstname . " <" . $row->client_email . ">";
            $email_recipients = implode(",", $email_recipients);
            $email_subject = $_POST['subject'];
            // Process email body when necessary (i.e. on Windows server)
            $email_body = $_POST['body'];
            if (stristr(PHP_OS, 'WIN')) $email_body = str_replace("\n.", "\n..", $_POST['body']);
            // Finally, send the email!
                if (!@mail($email_recipients, $email_subject, $email_body)) {
                    $sendmail_error = true;
                    $sendmail_error_message = error_get_last()['message'];
            }
        }
    } else {
        $sendmail_error = true;
        $sendmail_error_message = $stmt->errorInfo()[2];
    }

} else {
    $sendmail_invalid = true;
}

?>

<!-- Begin Page Content -->
<div>

    <!-- Page Heading -->
    <h1>Sending email to users</h1>
    <p>This page allows you to send bulk email to all selected users. </p>

    <?php if (isset($sendmail_invalid) && $sendmail_invalid): ?>
        <div>
            <h6>Invalid request! </h6>
        </div>
        <div>
            <p>It seems the request to send emails is invalid. </p>
            <p>Please fix any issues or contact the administrator for help. </p>
            <p>Click the button below to go back to the previous page. </p>
            <a href="email.php">
                <button onclick=\"window.location='email.php'\">Back to the category list</button>
            </a>
        </div>

    <?php elseif (isset($sendmail_error) && $sendmail_error): ?>
        <div>
            <h6>Emails did not sent correctly! </h6>
        </div>
        <div>
            <p>There was an error during the sending process. Here's the error message: </p>
            <div>
                <code><?= (isset($sendmail_error_message) && !empty($sendmail_error_message)) ? $sendmail_error_message : "Unknown error. Please contact the administrator. " ?></code>
            </div>
            <p>Please fix any issues or contact the administrator for help. </p>
            <p>Click the button below to go back to the previous page. </p>
            <a href="email.php">
                <button onclick=\"window.location='email.php'\">Back to the category list</button>
            </a>
        </div>


    <?php else: ?>
        <div>
            <h6>Emails sent successfully! </h6>
        </div>
        <div>
            <p>Your message has been sent successfully. Click the button below to go back to the previous page. </p>
            <a href="email.php">
                <button onclick=\"window.location='email.php'\">Back to the category list</button>
            </a>
        </div>


    <?php endif; ?>

</div>
