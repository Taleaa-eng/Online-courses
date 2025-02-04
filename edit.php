<?php
include 'admin/dbconnect.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM categroies WHERE id = ?";
    $stm = $con->prepare($sql);
    $stm->execute([$id]);
    $category = $stm->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);


        $sql = "UPDATE categories SET name = ?, description = ? WHERE id = ?";
        $stm = $con->prepare($sql);
        $stm->execute([$name, $description, $id]);

        echo "<div class='alert alert-success'>Category updated successfully</div>";

    }
}
?>