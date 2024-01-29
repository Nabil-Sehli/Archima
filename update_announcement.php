<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // User is not logged in
    echo "User not logged in";
    exit();
}

require("../connexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $announcementId = $_POST['id'];
    $updatedTitle = $_POST['title'];
    $updatedDescription = $_POST['description'];

    // Update the announcement in the database
    $updateSql = "UPDATE annonce SET titre = '$updatedTitle', description = '$updatedDescription' WHERE id_annonce = $announcementId";
    $updateResult = mysqli_query($con, $updateSql);

    if ($updateResult) {
        echo "Announcement updated successfully";
    } else {
        echo "Failed to update the announcement";
    }
} else {
    echo "Invalid request";
}

mysqli_close($con);
?>
