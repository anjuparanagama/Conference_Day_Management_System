<?php
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

// Get the data from the QR code (name and session)
if (isset($_GET['name']) && isset($_GET['session'])) {
    $name = $_GET['name'];
    $session = $_GET['session'];

    // Fetch participant ID based on the name and session ID
    $sql = "SELECT participant_id FROM participants WHERE name = '$name' AND sessions_registered = '$session'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Get the participant ID
        $row = $result->fetch_assoc();
        $participant_id = $row['participant_id'];

        // Check if the participant has already checked in for this session
        $attendanceCheckSql = "SELECT * FROM attendance WHERE participant_id = '$participant_id' AND session_id = '$session'";
        $attendanceResult = $conn->query($attendanceCheckSql);

        if ($attendanceResult->num_rows > 0) {
            // Participant has already checked in for this session
            echo "You have already checked in for this session.";
        } else {
            // Fetch the session's capacity and registered count
            $sessionCheckSql = "SELECT registered_count, capacity FROM sessions WHERE session_id = '$session'";
            $sessionResult = $conn->query($sessionCheckSql);

            if ($sessionResult->num_rows > 0) {
                $sessionRow = $sessionResult->fetch_assoc();
                $registered_count = $sessionRow['registered_count'];
                $capacity = $sessionRow['capacity'];

                // Check if the session is already full
                if ($registered_count >= $capacity) {
                    echo "This session is full. You cannot check in.";
                } else {
                    // Record the current time for check-in
                    $check_in_time = date('Y-m-d H:i:s');

                    // Insert attendance data into the attendance table
                    $attendanceSql = "INSERT INTO attendance (participant_id, session_id, check_in_time) 
                                     VALUES ('$participant_id', '$session', '$check_in_time')";

                    if ($conn->query($attendanceSql) === TRUE) {
                        // Update the registered_count in the sessions table
                        $updateSessionSql = "UPDATE sessions SET registered_count = registered_count + 1 WHERE session_id = '$session'";

                        if ($conn->query($updateSessionSql) === TRUE) {
                            echo "Attendance marked successfully and session count updated!";
                        } else {
                            echo "Error updating session count: " . $conn->error;
                        }
                    } else {
                        echo "Error marking attendance: " . $conn->error;
                    }
                }
            } else {
                echo "Session not found.";
            }
        }
    } else {
        echo "No participant found for this session.";
    }
} elseif (isset($_GET['delete_participant_id'])) {
    // Deleting participant and updating session registered count
    $participant_id = $_GET['delete_participant_id'];

    // Fetch session id for the participant to decrement the registered_count
    $sessionQuery = "SELECT sessions_registered FROM participants WHERE participant_id = '$participant_id'";
    $sessionResult = $conn->query($sessionQuery);

    if ($sessionResult->num_rows > 0) {
        $sessionRow = $sessionResult->fetch_assoc();
        $session_id = $sessionRow['sessions_registered'];

        // Begin transaction to ensure both delete and update happen atomically
        $conn->begin_transaction();

        try {
            // Delete the participant from the participants table
            $deleteParticipantSql = "DELETE FROM participants WHERE participant_id = '$participant_id'";
            if ($conn->query($deleteParticipantSql) === TRUE) {
                // Decrement the registered_count in the sessions table
                $updateSessionSql = "UPDATE sessions SET registered_count = registered_count - 1 WHERE session_id = '$session_id'";

                if ($conn->query($updateSessionSql) === TRUE) {
                    // Commit transaction
                    $conn->commit();
                    echo "Participant deleted and session count updated successfully!";
                } else {
                    throw new Exception("Error updating session count: " . $conn->error);
                }
            } else {
                throw new Exception("Error deleting participant: " . $conn->error);
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "No participant found with that ID.";
    }
} else {
    echo "Invalid data.";
}

// Close the database connection
$conn->close();
?>
