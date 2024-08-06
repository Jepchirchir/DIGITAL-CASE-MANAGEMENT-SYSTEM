<!DOCTYPE html>
<html>
<head>
    <title>Taken Cases</title>
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
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 800px;
            margin: 20px auto;
        }
        .felon-tile {
            width: 200px;
            height: 250px;
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.7);
        }
        .felon-tile h3 {
            margin: 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
            text-align: center;
            
        }
        .felon-tile p {
            margin: 5px 0;
        }
        h1{
            text-align: center;
            color: chocolate;
        }
    </style>
</head>
<body>
<header>
        <h1>THE JUDICIARY</h1>
    </header>
    <nav>
        <a href="lawyer.php" >Home</a>
        <a href="taken_cases.php" class="active">My Cases</a>
        <a href="index.html">Logout</a>
    </nav>
    <main>
    <h1>Taken Cases</h1>
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
                // Display felon information in a tile
                echo "
                    <div class='felon-tile'>
                        <h3>{$felon['first_name']} {$felon['last_name']}</h3>
                        <p>ID: {$felon['id_number']}</p>
                        <p>Marital Status: {$felon['marital_status']}</p>
                        <p>Next of Kin Title: {$felon['next_of_kin_title']}</p>
                        <p>Next of Kin Contact: {$felon['next_of_kin_contact']}</p>
                        <p>Case Description: {$felon['case_description']}</p>
                    </div>
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
</body>
</html>
