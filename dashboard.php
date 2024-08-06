<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

switch ($role) {
    case 'admin':
        header("Location: admin.php");
        break;
    case 'police':
        header("Location: police.php");
        break;
    case 'lawyer':
        header("Location: lawyer.php");
        break;
    case 'court':
        header("Location: court.php");
        break;
    default:
        header("Location: login.php");
        break;
}
exit();
?>
