<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conference"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Start a session and store user data
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['full_name'];
            $_SESSION['user_email'] = $row['email'];

            echo "<script>alert('Login successful!'); window.location.href='user_dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid email or password!');window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('No user found with that email!');window.location.href='index.html';</script>";
    }

    $conn->close();
}
?>
