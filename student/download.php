<?php
require_once "../includes/auth_check.php";
checkRole('student');

if (!isset($_GET['file'])) {
    die("No file specified");
}

$file = basename($_GET['file']);

$path = "../assets/uploads/materials/" . $file;

if (!file_exists($path)) {
    die("File not found");
}

// Force download headers
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Length: ' . filesize($path));

readfile($path);
exit;
?>