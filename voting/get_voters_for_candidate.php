<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once 'config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Get the candidate code from query parameter
$candidateCode = isset($_GET['candidate']) ? strtoupper(trim($_GET['candidate'])) : '';

if (empty($candidateCode)) {
    die(json_encode(["error" => "Candidate code is required"]));
}

// Get voters who voted for this candidate from the temporary table
$sql = "SELECT 
          v.voterID,
          v.firstName,
          v.lastName,
          v.contactNumber
        FROM voter v
        JOIN temp_voter_details t ON v.contactNumber = t.sender
        WHERE t.candidate_code = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $candidateCode);
$stmt->execute();
$result = $stmt->get_result();

$voters = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $voters[] = [
            'voterID' => $row['voterID'],
            'firstName' => $row['firstName'],
            'lastName' => $row['lastName'],
            'contactNumber' => $row['contactNumber']
        ];
    }
}

$conn->close();
echo json_encode($voters);
?>