<?php
include("../mysqli_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Now delete the actual item
    $stmt = $dbcon->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../admin.php");
        exit();
    } else {
        echo "Error deleting user.";
    }
}
?>