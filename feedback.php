<?php

$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "conference";    

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['nameform']) ? $_POST['nameform'] : '';
    $session = isset($_POST['sessionf']) ? $_POST['sessionf'] : '';
    $feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';

	$stmt = $conn->prepare("INSERT INTO feedback (name, session, feedback) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $name, $session, $feedback);

	if ($stmt->execute()) {
		echo "<script>alert('Feedback submitted successfully!'); window.location.href = 'http://localhost/web/dashboard.html';</script>";
		exit();
	} else {
		echo "Error: " . $stmt->error;
	}

	$stmt->close();
}

$conn->close();
?>
