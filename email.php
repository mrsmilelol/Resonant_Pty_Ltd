<?php
$PAGE_ID = "email";
$PAGE_HEADER = "Sending email to users";
include("connection.php")

/** @var PDO $dbh Database connection */
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1<>>Sending email to clients</h1>
    <p>This page allows you to send bulk email to all selected clients. </p>
    <form method="post" action="email_send.php" id="send-emails">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6>Step 1: Select clients you would like to send emails to</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php $clients_stmt = $dbh->prepare("SELECT * FROM `client` WHERE `client_subscribed`= 'subscribed'");
                    if ($clients_stmt->execute() && $clients_stmt->rowCount() > 0): ?>
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Send?</th>
                                <th>Client First Name</th>
                                <th>Client Last Name</th>
                                <th>Email Address</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($client = $clients_stmt->fetchObject()): ?>
                                <tr>
                                    <td class="table-cell-center">
                                        <input type="checkbox" name="client_ids[]" class="emails-to-send" value="<?php echo $client->client_id; ?>" />
                                    </td>
                                    <td><code><?= $client->client_firstname ?></code></td>
                                    <td><?= $client->client_lastname ?></td>
                                    <td><a href="mailto:<?= $client->client_email ?>"><?= $client->client_email ?></a></td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>

                    <?php else: ?>
                        <p class="mb-4">There's no client in the database. </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card-header py-3">
            <h6>Step 2: Compose the email and send</h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="sendmailSubject">Subject</label>
                <input type="text" class="form-control" id="sendmailSubject" name="subject" placeholder="Latest newsletter!" required>
            </div>
            <div class="form-group">
                <label for="sendmailMessage">Message body</label>
                <textarea class="form-control" id="sendmailMessage" name="body" rows="5" placeholder="Hi, &#10;&#10;...&#10;&#10;Regards" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send email</button>
        </div>
    </form>
</div>
