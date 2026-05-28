<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

$id = $_GET['id'];

$conn->prepare("DELETE FROM subjects WHERE id=:id")
     ->execute([':id'=>$id]);

header("Location: view.php");
exit();
?>