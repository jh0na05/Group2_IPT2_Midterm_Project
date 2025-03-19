<?php
session_start();
include ('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movie_title = $_POST['movie_title'];
    $release_date = $_POST['release_date'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];

    $sql = "INSERT INTO movie_list (movie_title, release_date, genre, director) VALUES ('$movie_title', '$release_date', '$genre', '$director')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = 'Created successfully';
    } else {
        $_SESSION['status'] = 'Error creating user: ' . $conn->error;
    }

    mysqli_close($conn);
    header:('Location: /index.php');
    exit();
}

?>