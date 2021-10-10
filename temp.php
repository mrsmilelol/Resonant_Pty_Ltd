<?php
require_once __DIR__ . '/vendor/autoload.php';
include("connection.php");

use Mpdf\Mpdf;


try {
    // Setup mPDF parameters
    $mpdf = new Mpdf([
        'margin_left' => 20,
        'margin_right' => 15,
        'margin_top' => 48,
        'margin_bottom' => 25,
        'margin_header' => 10,
        'margin_footer' => 10
    ]);
    // SetProtection – Encrypts and sets the PDF document permissions https://mpdf.github.io/reference/mpdf-functions/setprotection.html
    $mpdf->SetProtection(['print']);

    // Set some basic document metadata https://mpdf.github.io/reference/mpdf-functions/settitle.html
    $mpdf->SetTitle("Client info");
    $mpdf->SetAuthor("User");

    // Set a watermark https://mpdf.github.io/reference/mpdf-functions/setwatermarktext.html
    $mpdf->SetWatermarkText("View");
    $mpdf->showWatermarkText = true;
    $mpdf->watermarkTextAlpha = 0.1;

    // SetDisplayMode – Specify the initial Display Mode when the PDF file is opened in Adobe Reader https://mpdf.github.io/reference/mpdf-functions/setdisplaymode.html
    $mpdf->SetDisplayMode('fullpage');

    // Set up headers and footers - https://mpdf.github.io/headers-footers/method-4.html
    // Note: For this demo, the headers and footers are set up in the HTML file instead, from line 53

    // Get the actual contents from a file - in this case, it's an HTML file https://mpdf.github.io/reference/mpdf-functions/writehtml.html
    // In reality, you'll likely need to somehow modify the template so the data is properly inserted

    $dbh = new PDO('mysql:host=localhost;dbname=fit2104_ass2', 'fit2104', 'fit2104');
    if (isset($_GET['client_id'])) {
        $query = "SELECT * FROM `client` WHERE `client_id` = ?";
        $stmt = $dbh->prepare($query);
        if ($stmt->execute([$_GET['client_id']])) {
            if ($stmt->rowCount() == 1) {
                $client = $stmt->fetchObject();
            }

        }
    }
    $ID = $_GET['client_id'];
    $fname = $client->client_firstname;
    $lname = $client->client_lastname;
    $address = $client->client_address;
    $phone = $client->client_phone;
    $email = $client->client_email;
    $subscribed = $client->client_subscribed;
    $other_information = $client->client_other_information;

    $mpdf = new \Mpdf\Mpdf();

    $data = '';
    $data.='<h1>Client Details</h1>';

    $data.='<strong>ID: </strong>'.$ID.'<br/>';
    $data.='<strong>First Name: </strong>'.$fname.'<br/>';
    $data.='<strong>Last Name: </strong>'.$lname.'<br/>';
    $data.='<strong>Address: </strong>'.$address.'<br/>';
    $data.='<strong>Phone: </strong>'.$phone.'<br/>';
    $data.='<strong>Email: </strong>'.$email.'<br/>';
    $data.='<strong>Subscribed: </strong>'.$subscribed.'<br/>';
    $data.='<strong>Other Information: </strong>'.$other_information.'<br/>';

    $mpdf->WriteHTML($data);

    // Output – Finalise the document and send it to specified destination https://mpdf.github.io/reference/mpdf-functions/output.html
    $mpdf->Output();
} catch (\Mpdf\MpdfException $e) {
    var_dump($e);
}

?>