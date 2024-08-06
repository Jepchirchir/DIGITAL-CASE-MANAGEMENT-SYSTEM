<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'police') {
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

$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $id_number = $_POST['id_number'];
    $marital_status = $_POST['marital_status'];
    $next_of_kin_title = $_POST['next_of_kin_title'];
    $next_of_kin_contact = $_POST['next_of_kin_contact'];
    $case_description = $_POST['case_description'];
    $created_by = $_SESSION['user_id'];

    $sql = "INSERT INTO felons (first_name, last_name, id_number, marital_status, next_of_kin_title, next_of_kin_contact, case_description, created_by) 
            VALUES ('$first_name', '$last_name', '$id_number', '$marital_status', '$next_of_kin_title', '$next_of_kin_contact', '$case_description', '$created_by')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "New felon registered successfully";
    } else {
        $success_message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register a Felon</title>
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
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.7);
        }
        .container h1 {
            text-align: center;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container form input,
        .container form select,
        .container form textarea,
        .container form button {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
        }
        .container form button {
            background-color: chocolate;
            color: white;
            border: none;
            cursor: pointer;
        }
        .container form button:hover {
            background-color: goldenrod;
        }
        .alert {
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
<header>
        <h1>THE JUDICIARY</h1>
    </header>
    <nav>
        <a href="police.php" class="active">New Case</a>
        <a href="open_cases.php">Open Cases</a>
        <a href="index.html">Logout</a>
    </nav>
    <main>
        <br><br>
    <div class="container">
        <h1>Register a Case</h1>
        <?php if ($success_message): ?>
            <div class="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="police.php">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="text" name="id_number" placeholder="ID Number" required>
            <select name="marital_status" required>
                <option value="single">Single</option>
                <option value="married">Married</option>
                <option value="divorced">Divorced</option>
                <option value="widowed">Widowed</option>
            </select>
            <input type="text" name="next_of_kin_title" placeholder="Next of Kin Title" required>
            <input type="text" name="next_of_kin_contact" placeholder="Next of Kin Contact" required>
            <textarea name="case_description" placeholder="Case Description" required></textarea>
            <button type="submit">Save Case</button>
        </form>
    </div>
    </main>
</body>
</html>
