<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'court') {
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
    <title>COURT</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background: url('images/login.jpg') no-repeat center center fixed; 
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
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .felon-tile {
            width: 200px;
            height: 200px;
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            float: left;
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.7);
        }
        .felon-tile:hover {
            background-color: chocolate;
            color: white;
        }
        h1{
            text-align: center;
            text-decoration: underline;
            color: chocolate;
        }
    </style>
</head>
<body>
<header>
        <h1>THE JUDICIARY</h1>
    </header>
    <nav>
        <a href="court.php" class="active">Open Cases</a>
        <a href="#about">Closed Cases</a>
        <a href="index.html">Logout</a>
    </nav>
    <main>
    <h1>CASES</h1>
    <div class="container">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='felon-tile' onclick='showVerdictForm({$row['id']})'>
                    <h3>{$row['first_name']} {$row['last_name']}</h3>
                    <p>ID: {$row['id_number']}</p>
                    <p>Case Description: {$row['case_description']}</p>
                 </div>";
        }
    } else {
        echo "No felons registered by police.";
    }
    ?>
</main>
    <script>
        function showVerdictForm(felonId) {
            window.location.href = "verdict_form.php?id=" + felonId;
        }
    </script>
</body>
</html>
