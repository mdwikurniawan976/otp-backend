<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generateOTP($length = 4) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, $charactersLength - 1)];
    }
    return $otp;
}

function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ezykasir@gmail.com'; // SMTP username
        $mail->Password   = 'yauq xcuc ezaf ienr'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('ezykasir@gmail.com', 'EzyKasir');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is: <b>$otp</b>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log or display the error message
        error_log('Mailer Error: ' . $mail->ErrorInfo);
        error_log('Exception: ' . $e->getMessage());
        echo "Mailer Error: " . $mail->ErrorInfo; // Display error message
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $otp = generateOTP();

    if (sendOTP($email, $otp)) {
        echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP']);
    }
} else {
    // echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Send OTP Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
            line-height: 1.6;
        }
        .code-block {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            font-family: 'Courier New', Courier, monospace;
        }
        .endpoint {
            background-color: #eef;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Send OTP API Documentation</h1>
        <p>Welcome to the Send OTP API documentation. This API allows you to generate and send an OTP (One Time Password) to a specified email address.</p>
        
        <h2>Endpoint</h2>
        <div class='endpoint'>
            <code>POST https://otp-backend-pied.vercel.app/</code>
        </div>

        <h2>Parameters</h2>
        <p>To use this API, make a POST request with the following parameter:</p>
        <ul>
            <li><strong>email</strong> (string): The email address to which the OTP will be sent.</li>
        </ul>

        <h2>Usage</h2>
        <p>Use the following steps to test this API with Postman:</p>
        <ol>
            <li>Open Postman and create a new request.</li>
            <li>Set the request method to <strong>POST</strong>.</li>
            <li>Set the request URL to: <code>https://otp-backend-pied.vercel.app/</code></li>
            <li>In the <strong>Body</strong> tab, select <strong>x-www-form-urlencoded</strong>.</li>
            <li>Add a key <strong>email</strong> with the value set to the recipient's email address.</li>
            <li>Click <strong>Send</strong> to make the request.</li>
        </ol>

        <h2>Example Request</h2>
        <div class='code-block'>
            <pre>
POST https://otp-backend-pied.vercel.app/
Content-Type: application/x-www-form-urlencoded

email=example@example.com
            </pre>
        </div>

        <h2>Responses</h2>
        <p>The API will return a JSON object with the following structure:</p>
        <div class='code-block'>
            <pre>
{
    'status': 'success',
    'message': 'OTP sent successfully'
}
            </pre>
        </div>
        <div class='code-block'>
            <pre>
{
    'status': 'error',
    'message': 'Failed to send OTP'
}
            </pre>
        </div>

        <p>Thank you for using our API!</p>
    </div>
</body>
</html>
";
}

?>
