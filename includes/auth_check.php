<?php
require_once "session.php";

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: /student-portal/login.php");
    exit();
}

// Optional: role check
function checkRole($role) {
    if ($_SESSION['role'] !== $role) {
        header("Location: /student-portal/login.php");
        exit();
    }
}
?>