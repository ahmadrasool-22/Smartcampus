<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('teacher');

$sql = "SELECT attendance.*, users.name, subjects.subject_name
        FROM attendance
        JOIN students ON attendance.student_id = students.id
        JOIN users ON students.user_id = users.id
        JOIN subjects ON attendance.subject_id = subjects.id
        ORDER BY attendance_date DESC";

$data = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Attendance Records</h3>

<table class="table table-bordered">
<tr>
    <th>Student</th>
    <th>Subject</th>
    <th>Status</th>
    <th>Date</th>
</tr>

<?php foreach ($data as $row): ?>
<tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['subject_name'] ?></td>
    <td><?= $row['status'] ?></td>
    <td><?= $row['attendance_date'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php require_once "../../includes/footer.php"; ?>