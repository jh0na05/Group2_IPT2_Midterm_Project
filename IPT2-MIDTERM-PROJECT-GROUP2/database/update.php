<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id']; // Get the movie ID
    $movie_title = $_POST['movie_title'];
    $release_date = $_POST['release_date'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];

    // Corrected SQL query with placeholders
    $sql = "UPDATE movie_list
            SET movie_title = ?, release_date = ?, genre = ?, director = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Corrected bind_param with appropriate data types
        $stmt->bind_param('ssssi', $movie_title, $release_date, $genre, $director, $id);

        if ($stmt->execute()) {
            $_SESSION['status'] = 'updated';
        } else {
            $_SESSION['status'] = 'error';
            error_log("Update Error: " . $stmt->error);
        }
        $stmt->close();
    } else {
        $_SESSION['status'] = 'error';
        error_log("Prepare Error: " . $conn->error);
    }

    header('Location: ../index.php');
    exit();
}
?>
