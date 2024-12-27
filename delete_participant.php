<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "conference");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['participant_id'])) {
    $participant_id = $_GET['participant_id'];

    // Fetch the session registered for the participant
    $sessionSql = "SELECT sessions_registered FROM participants WHERE participant_id = '$participant_id'";
    $sessionResult = $conn->query($sessionSql);

    if ($sessionResult->num_rows > 0) {
        $sessionRow = $sessionResult->fetch_assoc();
        $session_id = $sessionRow['sessions_registered'];

        // Delete participant from participants table
        $deleteParticipantSql = "DELETE FROM participants WHERE participant_id = '$participant_id'";
        if ($conn->query($deleteParticipantSql) === TRUE) {
            // Delete participant from attendance table
            $deleteAttendanceSql = "DELETE FROM attendance WHERE participant_id = '$participant_id'";
            if ($conn->query($deleteAttendanceSql) === TRUE) {
                // Decrement registered count in sessions table
                $updateSessionSql = "UPDATE sessions SET registered_count = registered_count - 1 WHERE session_id = '$session_id'";
                $conn->query($updateSessionSql);
                echo "<script>alert('Participant Delete Successfully !'); window.location.href = 'http://localhost/web/admin_dashboard.html';</script>";
            } else {
                echo "Error deleting participant from attendance table: " . $conn->error;
            }
        } else {
            echo "Error deleting participant: " . $conn->error;
        }
    }
    $conn->close();
}
?>
