<!DOCTYPE html>
<html>
<head>
    <title>Felon Details</title>
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
            background-color: rgba(255, 255, 255, 0.7);
        }
        textarea, input[type="text"], input[type="date"] {
            width: 100%;
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: chocolate;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }
        button:hover {
            background-color: goldenrod;
        }
    </style>
</head>
<body>
<header>
        <h1>THE JUDICIARY</h1>
    </header>
    <nav>
        <a href="lawyer.php">Open Cases</a>
        <a href="index.html">Logout</a>
    </nav>
    <main><br><br>
    <div class="container">
        <?php
        if(isset($_GET['id'])) {
            $felonId = $_GET['id'];
        
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
        
            // Prepare SQL statement to fetch felon information
            $sql = "SELECT * FROM felons WHERE id = $felonId";
            $result = $conn->query($sql);
        
            // Check if a felon with the given ID exists
            if ($result->num_rows > 0) {
                $felon = $result->fetch_assoc();
                // Display felon information
                echo "
                    <h2>Case Information</h2>
                    <p><strong>Name:</strong> {$felon['first_name']} {$felon['last_name']}</p>
                    <p><strong>ID Number:</strong> {$felon['id_number']}</p>
                    <p><strong>Marital Status:</strong> {$felon['marital_status']}</p>
                    <p><strong>Next of Kin Title:</strong> {$felon['next_of_kin_title']}</p>
                    <p><strong>Next of Kin Contact:</strong> {$felon['next_of_kin_contact']}</p>
                    <p><strong>Case Description:</strong> {$felon['case_description']}</p>
                    <button onclick='redirectToTakenCases()'>Take Case</button>
                ";
            } else {
                echo "Felon not found.";
            }
        
            // Close database connection
            $conn->close();
        } else {
            echo "Felon ID not provided.";
        }
        ?>
    </div>

    </main>
    <script>

        function redirectToTakenCases() {
            window.location.href = "taken_cases.php?id=<?php echo $felonId; ?>";
        }

    </script>
</body>
</html>
