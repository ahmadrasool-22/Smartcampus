<?php
require_once "../config/db.php";
require_once "../includes/auth_check.php";
checkRole('student');

$user_id = $_SESSION['user_id'];

// Get student id
$stmt = $conn->prepare("SELECT id FROM students WHERE user_id=:uid");
$stmt->execute([':uid'=>$user_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

$student_id = $student['id'];

// Get attendance records
$sql = "SELECT attendance.*, subjects.subject_name
        FROM attendance
        JOIN subjects ON attendance.subject_id = subjects.id
        WHERE attendance.student_id = :sid
        ORDER BY attendance_date DESC";

$stmt = $conn->prepare($sql);
$stmt->execute([':sid'=>$student_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<?php require_once "../includes/sidebar.php"; ?>

<h3>My Attendance</h3>

<table class="table table-bordered">
<tr>
    <th>Subject</th>
    <th>Status</th>
    <th>Date</th>
</tr>

<?php if ($data): ?>
    <?php foreach ($data as $row): ?>
    <tr>
        <td><?= $row['subject_name'] ?></td>
        <td>
            <?php if ($row['status'] == 'present'): ?>
                <span class="text-success">Present</span>
            <?php else: ?>
                <span class="text-danger">Absent</span>
            <?php endif; ?>
        </td>
        <td><?= $row['attendance_date'] ?></td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="3">No attendance records found</td>
    </tr>
<?php endif; ?>
</table>

<?php require_once "../includes/footer.php"; ?>