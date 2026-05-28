<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

$id = $_GET['id'];

// Delete student (user auto deletes due to FK if configured)
$sql = "DELETE FROM students WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);

header("Location: view.php");
exit();
?>