<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit();
}

$id = $_GET['id'];

// Optional safety check (recommended)
$stmt = $conn->prepare("DELETE FROM departments WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: view.php");
exit();
?>