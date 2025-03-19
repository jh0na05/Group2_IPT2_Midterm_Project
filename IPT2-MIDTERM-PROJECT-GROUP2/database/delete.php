<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM movie_list WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['status'] = 'deleted';
        } else {
            $_SESSION['status'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['status'] = 'error';
    }

    //  Redirect to the correct page
    header('Location: ../index.php'); 
    exit();
}
?>
