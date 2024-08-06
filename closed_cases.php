<?php
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "courtApp";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to fetch felons with a verdict
$sql = "SELECT * FROM felons WHERE verdict IS NOT NULL";
$result = $conn->query($sql);

// Check if any felons with a verdict exist
$felons = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $felons[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Closed Cases</title>
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
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .tile {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .tile h2 {
            margin-top: 0;
        }
        .tile p {
            margin: 5px 0;
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
    <div class="container">
        <h1>Closed Cases</h1>
        <?php if (!empty($felons)): ?>
            <?php foreach ($felons as $felon): ?>
                <div class="tile">
                    <h2><?php echo $felon['first_name'] . ' ' . $felon['last_name']; ?></h2>
                    <p><strong>ID Number:</strong> <?php echo $felon['id_number']; ?></p>
                    <p><strong>Marital Status:</strong> <?php echo $felon['marital_status']; ?></p>
                    <p><strong>Next of Kin Title:</strong> <?php echo $felon['next_of_kin_title']; ?></p>
                    <p><strong>Next of Kin Contact:</strong> <?php echo $felon['next_of_kin_contact']; ?></p>
                    <p><strong>Case Description:</strong> <?php echo $felon['case_description']; ?></p>
                    <p><strong>Verdict:</strong> <?php echo $felon['verdict']; ?></p>
                    <?php if ($felon['verdict'] == 'bail'): ?>
                        <p><strong>Bail Amount:</strong> <?php echo $felon['bail_amount']; ?></p>
                    <?php elseif ($felon['verdict'] == 'jail'): ?>
                        <p><strong>Jail Term:</strong> <?php echo $felon['jail_term']; ?> months</p>
                    <?php elseif ($felon['verdict'] == 'freed'): ?>
                        <p><strong>Reason for Freed:</strong> <?php echo $felon['freed_reason']; ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No closed cases found.</p>
        <?php endif; ?>
    </div>
    </main>
</body>
</html>
