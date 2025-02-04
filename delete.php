<?php
require 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM categories WHERE id = ?";
    $stm = $con->prepare($sql);
    $stm->execute([$id]);
    header("Location: index.php"); // Redirect back to the categories page
}
?>