<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "courtApp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $felonId = intval($_GET['id']);
    $sql = "SELECT * FROM felons WHERE id = $felonId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $felon = $result->fetch_assoc();
        echo json_encode($felon);
    } else {
        echo json_encode(['error' => 'Felon not found.']);
    }
} else {
    echo json_encode(['error' => 'Felon ID not provided.']);
}

$conn->close();
?>
