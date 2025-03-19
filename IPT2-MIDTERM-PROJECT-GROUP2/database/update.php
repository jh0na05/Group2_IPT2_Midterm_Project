<?php
session_start();
include('database.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $movie_title = $_POST['movie_title'];
    $release_date = $_POST['release_date'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];

    $sql = "UPDATE movies SET movie_title = '$movie_title', release_date = '$release_date', genre = '$genre', director = '$director' WHERE id = $id";

    if(mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Movie updated successfully';
        header('Location: ../index.php');
    } else {
        $_SESSION['error'] = 'Something went wrong. ' . $conn->error;
    }
    mysqli_close($conn);
    header("Location: ../index.php");
    exit();
}
?>