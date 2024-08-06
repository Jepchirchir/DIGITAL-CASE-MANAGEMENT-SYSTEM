<?php
session_start();

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

$alert_message = "";
$alert_class = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];

            if ($email == 'admin@court.com' && $password == 'court123') {
                header("Location: admin.php");
                exit();
            } elseif ($row['role'] == 'police') {
                header("Location: police.php");
                exit();
            } elseif ($row['role'] == 'lawyer') {
                header("Location: lawyer.php");
                exit();
            } elseif ($row['role'] == 'court') {
                header("Location: court.php");
                exit();
            }
        } else {
            $alert_message = "Invalid password";
            $alert_class = "alert-error";
        }
    } else {
        $alert_message = "No user found with this email";
        $alert_class = "alert-error";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            background: url('images/Premium\ Photo\ _\ Judge\'s\ gavel\ on\ wooden\ table\ in\ dark.jpg') no-repeat center center fixed; 
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 100px auto; /* Adjust margin for positioning */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.7); /* Add transparency */
        }
        .container h1 {
            text-align: center;
            color: chocolate;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container form input,
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
            color: white;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .alert-success {
            background-color: #4CAF50;
        }
        .alert-error {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if ($alert_message): ?>
            <div class="alert <?php echo $alert_class; ?>">
                <?php echo $alert_message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>New User? <a style="color: chocolate; " href="register.php">Create an account.</a> </p>
        </form>
    </div>
</body>
</html>
