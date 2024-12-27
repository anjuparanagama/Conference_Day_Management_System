<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conference";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_sessions = "SELECT session_id, title, registered_count FROM sessions";
$result_sessions = $conn->query($sql_sessions);

$sql_participants = "
SELECT p.name, p.email, s.title AS session_title, a.participant_id
FROM participants p
JOIN attendance a ON p.participant_id = a.participant_id
JOIN sessions s ON a.session_id = s.session_id
";
$result_participants = $conn->query($sql_participants);

$sql_feedback = "SELECT name, session, feedback FROM feedback";
$result_feedback = $conn->query($sql_feedback);

$data = [
    'sessions' => $result_sessions->fetch_all(MYSQLI_ASSOC),
    'participants' => $result_participants->fetch_all(MYSQLI_ASSOC),
    'feedback' => $result_feedback->fetch_all(MYSQLI_ASSOC),
];

$conn->close();


header('Content-Type: application/json');
echo json_encode($data);
?>
