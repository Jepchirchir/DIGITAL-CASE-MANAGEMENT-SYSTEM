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

// Count total users by role
$sqlUsers = "SELECT role, COUNT(*) as total FROM users GROUP BY role";
$resultUsers = $conn->query($sqlUsers);

// Count total felons
$sqlFelons = "SELECT COUNT(*) as total FROM felons";
$resultFelons = $conn->query($sqlFelons);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Dashboard</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background: url('images/Court\ interpreters\ lost\ in\ translation.jpg') no-repeat center center fixed; 
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 1em 0;
            text-align: center;
            transition: color 0.3s;
        }
        header h1 {
            margin: 0;
        }
        header:hover {
            color: chocolate;
        }
        nav {
            background-color: #444;
            color: #fff;
            padding: 0.5em;
            text-align: center;
        }
        nav a {
            color: #fff;
            margin: 0 1em;
            text-decoration: none;
            transition: color 0.3s, text-decoration 0.3s;
        }
        nav a:hover {
            color: chocolate;
        }
        nav a.active {
            color: chocolate;
            text-decoration: underline;
        }
        .tile {
            width: 200px;
            height: 100px;
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            float: left;
        }
    </style>
</head>
<body>
<header>
        <h1>THE JUDICIARY</h1>
    </header>
    <nav>
        <a href="#home" class="active">Home</a>
        <a href="#about">About</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </nav>
    <main>
    <h1>Admin Dashboard</h1>
    
    <h2>Registered Users</h2>
    <?php
    if ($resultUsers->num_rows > 0) {
        while($row = $resultUsers->fetch_assoc()) {
            echo "<div class='tile'>";
            echo "<p><strong>{$row['role']}</strong></p>";
            echo "<p>Total: {$row['total']}</p>";
            echo "</div>";
        }
    } else {
        echo "No registered users.";
    }
    ?>

    <h2>Registered Felons</h2>
    <?php
    if ($resultFelons->num_rows > 0) {
        $row = $resultFelons->fetch_assoc();
        echo "<div class='tile'>";
        echo "<p>Total Felons: {$row['total']}</p>";
        echo "</div>";
    } else {
        echo "No registered felons.";
    }
    ?>
</body>
</html>





<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'lawyer') {
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
    <title>Lawyer - Registered Felons</title>
</head>
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
