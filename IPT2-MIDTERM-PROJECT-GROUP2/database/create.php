<?php
session_start();
include('database.php'); // Ensure this file correctly establishes $conn

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input
    $movie_title = $_POST['movie_title'];
    $release_date = $_POST['release_date'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];

    // Prepare an SQL statement
    $sql = "INSERT INTO movie_list (movie_title, release_date, genre, director) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters (all are strings)
        $stmt->bind_param("ssss", $movie_title, $release_date, $genre, $director);

        if ($stmt->execute()) {
            $_SESSION['status'] = "created";

            // Get the total number of records
            $total_records_sql = "SELECT COUNT(*) AS total FROM movie_list";
            $total_records_result = $conn->query($total_records_sql);
            $total_records = $total_records_result->fetch_assoc()['total'];

            // Calculate the total number of pages
            $records_per_page = 10;
            $total_pages = ceil($total_records / $records_per_page);

            // Redirect to the last page
            header("Location: ../index.php?page=$total_pages");
            exit();
        } else {
            $_SESSION['status'] = "error";
            error_log("Insert Error: " . $stmt->error); // Log error
        }
        $stmt->close();
    } else {
        $_SESSION['status'] = "error";
        error_log("Prepare Error: " . $conn->error); // Log error
    }

    // Redirect in case of failure
    header("Location: ../index.php");
    exit();
}
?>
