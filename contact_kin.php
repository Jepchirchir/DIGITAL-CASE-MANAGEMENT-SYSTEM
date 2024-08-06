<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Get felon ID and message from POST data
    $felonId = $_POST['felon_id'];
    $message = $_POST['message'];

    // Fetch next of kin contact information
    $sql = "SELECT next_of_kin_contact FROM felons WHERE id = $felonId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $felon = $result->fetch_assoc();
        $nextOfKinContact = $felon['next_of_kin_contact'];

        // Send the message to the next of kin (example: email)
        $to = $nextOfKinContact;
        $subject = "Message from Lawyer Regarding Case";
        $headers = "From: your_email@example.com";

        if (mail($to, $subject, $message, $headers)) {
            $_SESSION['message'] = "Message sent successfully to the next of kin.";
        } else {
            $_SESSION['message'] = "Failed to send the message.";
        }
    } else {
        $_SESSION['message'] = "Next of kin contact not found.";
    }

    $conn->close();

    // Redirect back to lawyer.php with a message
    header("Location: felon_details.php");
    exit();
}
?>
