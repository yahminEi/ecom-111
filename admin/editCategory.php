<?php
require_once 'dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['val'] == 'delete') {
    try {
        $id = $_GET['id'];

        // Delete products that belong to this category
        $sql = "DELETE FROM product WHERE category=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        // Now delete the category
        $sql = "DELETE FROM category WHERE id=?";
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([$id]);

        if ($status) {
            header("Location:viewInfo.php?show=categories");
            exit;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>


