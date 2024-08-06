<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "courtApp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM felons";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Registered Felons</title>
</head>
<body>
    <h1>Registered Felons</h1>
    <table border="1">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>ID Number</th>
            <th>Marital Status</th>
            <th>Next of Kin Title</th>
            <th>Next of Kin Contact</th>
            <th>Case Description</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['first_name']}</td>
                        <td>{$row['last_name']}</td>
                        <td>{$row['id_number']}</td>
                        <td>{$row['marital_status']}</td>
                        <td>{$row['next_of_kin_title']}</td>
                        <td>{$row['next_of_kin_contact']}</td>
                        <td>{$row['case_description']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No felons found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
