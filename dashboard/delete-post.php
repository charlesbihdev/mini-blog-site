<?php
include '../conn.php';
if (isset($_GET['post_id'])) {
    $get_id = $_GET['post_id'];
    $sql = "DELETE FROM posts WHERE post_id = $get_id";
    $result = mysqli_query($conn, $sql);
    header('Location: ./dashboard.php');
} else {
    // header('Location: ./dashboard.php');
};
