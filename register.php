<?php
require 'phpqrcode/qrlib.php'; // Generate QR codes
require 'vendor/autoload.php'; // Load PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conference";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $organization = $_POST['institution'];
    $session = $_POST['session'];

    // Generate QR Code with attendance URL (heroku or deployment site link)
    $qrData = "http://localhost/web/mark_attendance.php?name=$name&session=$session";
    $qrFilePath = 'qrcodes/' . $name . '_' . $session . '.png';
    QRcode::png($qrData, $qrFilePath);

    // Insert data into database for each session
    $sql = "INSERT INTO participants (name, email, phone, organization, QR_code, sessions_registered)
            VALUES ('$name', '$email', '$phone', '$organization', '$qrFilePath', $session)";

    if ($conn->query($sql) === TRUE) {
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'anjulac2006@gmail.com';
            $mail->Password = 'rabi unfm xegs telf';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email settings
            $mail->setFrom('conference@domain.com', 'Organizing Team (IRC - 2024)');
            $mail->addAddress($email, $name);

            // Attach QR code
            $mail->addAttachment($qrFilePath);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Conference Registration Confirmation';
             $mail->Body = "Dear $name,<br><br>Thank you for registering International Research conference 2024.<br> Please find your QR code attached.Your QR code is the pass for IRC 2024.<br>Please show that organizing team at Door.<br><br>Best regards,<br>Organizing Team<br>IRC - 2024<br><br><b>Note: The QR code can scan only one time.So, don't scan by your self</b>";

            $mail->send();
            echo "<script>alert('Registration successful! QR code has been sent to your email.'); window.location.href = 'http://localhost/a/user_dashboard.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }
}

$conn->close();
?>
