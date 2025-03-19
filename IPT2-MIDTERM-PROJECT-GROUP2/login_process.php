<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example: Hardcoded credentials (Replace with database verification)
    $valid_username = "admin";
    $valid_password = "admin";

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['user'] = $username; // Store user session
        header("Location: index.php"); // Redirect to the index
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password!";
        header("Location: login.php"); // Redirect back to index.php
        exit();
    }
}
?>