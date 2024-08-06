<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Location: closed_cases.php");
    exit();
}

$savedVerdict = '';
$savedInformation = '';


if (isset($_GET['id'])) {
    $felonId = $_GET['id'];


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "courtApp";


    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "SELECT * FROM felons WHERE id = $felonId";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        $felon = $result->fetch_assoc();
        
        $savedInformation = "
            <h2>Felon Information</h2>
            <p><strong>Name:</strong> {$felon['first_name']} {$felon['last_name']}</p>
            <p><strong>ID Number:</strong> {$felon['id_number']}</p>
            <p><strong>Marital Status:</strong> {$felon['marital_status']}</p>
            <p><strong>Next of Kin Title:</strong> {$felon['next_of_kin_title']}</p>
            <p><strong>Next of Kin Contact:</strong> {$felon['next_of_kin_contact']}</p>
            <p><strong>Case Description:</strong> {$felon['case_description']}</p>
        ";
    } else {
        $savedInformation = "Felon not found.";
    }

    
    $conn->close();
} else {
    $savedInformation = "Felon ID not provided.";
}


if (isset($_POST['verdict'])) {
    $savedVerdict = $_POST['verdict'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verdict Form</title>
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
            max-width: 600px;
            margin: 100px auto; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.7); 
        }
        .container h1, .container h2 {
            text-align: center;
            color: chocolate;
        }
        .container form {
            display: flex;
            flex-direction: column;
            align-items: center;
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
<header>
        <h1>THE JUDICIARY</h1>
    </header>
    <nav>
        <a href="court.php">Home</a>
        <a href="verdict_form.php" class='active'>Verdicts</a>
        <a href="index.html">Logout</a>
    </nav>
    <main>
    <div class="container">
        <h1>Verdict Form</h1>
        <?php echo $savedInformation; ?>

        <?php if ($savedVerdict): ?>
            <div class="alert alert-success">
                <h2>Saved Verdict</h2>
                <p><strong>Verdict:</strong> <?php echo $savedVerdict; ?></p>
                
            </div>
        <?php else: ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="verdict">Verdict:</label>
                <select name="verdict" id="verdict">
                    <option value="bail">Bail</option>
                    <option value="jail">Jail</option>
                    <option value="freed">Freed</option>
                </select>
                <div id="bail" style="display: none;">
                    <label for="bail_amount">Bail Amount (Ksh):</label>
                    <input type="number" name="bail_amount" id="bail_amount" >
                </div>
                <div id="jail" style="display: none;">
                    <label for="jail_term">Jail Term (Months):</label>
                    <input type="number" name="jail_term" id="jail_term" >
                </div>
                <div id="freed" style="display: none;">
                    <label for="freed_reason">Reason for Freed:</label>
                    <textarea name="freed_reason" id="freed_reason" rows="4" cols="50"></textarea>
                </div>
                <button type="submit">Save Verdict</button>
            </form>
            <script>
                document.getElementById('verdict').addEventListener('change', function() {
                    var verdict = this.value;
                    document.getElementById('bail').style.display = (verdict === 'bail') ? 'block' : 'none';
                    document.getElementById('jail').style.display = (verdict === 'jail') ? 'block' : 'none';
                    document.getElementById('freed').style.display = (verdict === 'freed') ? 'block' : 'none';
                });
            </script>
            
        <?php endif; ?>

        <?php if ($savedVerdict): ?>
            <script>
                
                var form = document.querySelector('form');
                var inputs = form.querySelectorAll('input, select, textarea, button');
                inputs.forEach(function(input) {
                    input.disabled = true;
                });
                
                window.location.href = "closed_cases.php";
            </script>
        <?php endif; ?>
    </div>
</body>
</html>
