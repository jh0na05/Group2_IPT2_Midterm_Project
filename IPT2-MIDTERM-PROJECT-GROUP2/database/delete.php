<?php
session_start();
include('database.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM movies WHERE id = $id";

    if(mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Movie deleted successfully';
    } else {
        $_SESSION['error'] = 'Something went wrong. ' . $conn->error;
    }
    mysqli_close($conn);
    header("Location: ../index.php");
    exit();
}

?>