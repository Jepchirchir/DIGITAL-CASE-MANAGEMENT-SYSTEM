<?php
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
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (first_name, last_name, email, password, role) VALUES ('$first_name', '$last_name', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "New user registered successfully";
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            background-image: url('images/Court\ interpreters\ lost\ in\ translation.jpg'); /* Replace 'your_background_image.jpg' with your image path */
            background-size: cover;
            background-repeat: no-repeat;
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
            background-color: rgba(255, 255, 255, 0.7); /* Add transparency to the container */
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
        .container form select,
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
        <h1>Register</h1>
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php elseif ($error_message): ?>
            <div class="alert alert-error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="police">Police</option>
                <option value="lawyer">Lawyer</option>
                <option value="court">Court</option>
            </select>
            <button type="submit">Register</button>
            <p>Already a user? <a style="color: chocolate; " href="login.php">Login.</a> </p>
        </form>
    </div>
</body>
</html>
