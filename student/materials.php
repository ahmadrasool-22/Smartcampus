<?php
require_once "../config/db.php";
require_once "../includes/auth_check.php";
checkRole('student');

// Get student id
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id FROM students WHERE user_id=:uid");
$stmt->execute([':uid'=>$user_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
$student_id = $student['id'];

// Get all materials
$sql = "SELECT materials.*, subjects.subject_name
        FROM materials
        JOIN subjects ON materials.subject_id = subjects.id
        ORDER BY uploaded_at DESC";

$data = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<?php require_once "../includes/sidebar.php"; ?>

<h3>Course Materials</h3>

<table class="table table-bordered">
<tr>
    <th>Subject</th>
    <th>File</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php foreach ($data as $row): ?>
<tr>
    <td><?= $row['subject_name'] ?></td>
    <td><?= $row['file_name'] ?></td>
    <td><?= $row['uploaded_at'] ?></td>
    <td>
        <a href="download.php?file=<?= $row['file_name'] ?>" 
           class="btn btn-success btn-sm">
           Download
        </a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php require_once "../includes/footer.php"; ?>