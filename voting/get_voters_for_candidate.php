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

// Get voters who voted for this candidate
$sql = "SELECT 
          v.userId,
          v.firstName,
          v.lastName,
          v.contactNumber
        FROM voters v
        JOIN ozekimessagein m ON v.contactNumber = m.sender
        WHERE m.Remarks = 'VALID' 
        AND UPPER(TRIM(REPLACE(REPLACE(m.msg, 'VOTE ', ''), 'VOTED ', ''))) LIKE CONCAT('%', ?, '%')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $candidateCode);
$stmt->execute();
$result = $stmt->get_result();

$voters = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $voters[] = [
            'userId' => $row['userId'],
            'firstName' => $row['firstName'],
            'lastName' => $row['lastName'],
            'contactNumber' => $row['contactNumber']
        ];
    }
}

$conn->close();
echo json_encode($voters);
?>