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

// Get marks
$sql = "SELECT marks.*, subjects.subject_name, subjects.subject_code
        FROM marks
        JOIN subjects ON marks.subject_id = subjects.id
        WHERE marks.student_id = :sid";

$stmt = $conn->prepare($sql);
$stmt->execute([':sid'=>$student_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<?php require_once "../includes/sidebar.php"; ?>

<h3>My Results</h3>

<table class="table table-bordered">
<tr>
    <th>Subject</th>
    <th>Code</th>
    <th>Marks</th>
</tr>

<?php if ($data): ?>
    <?php foreach ($data as $row): ?>
    <tr>
        <td><?= $row['subject_name'] ?></td>
        <td><?= $row['subject_code'] ?></td>
        <td>
            <?php if ($row['marks'] >= 50): ?>
                <span class="text-success"><?= $row['marks'] ?></span>
            <?php else: ?>
                <span class="text-danger"><?= $row['marks'] ?></span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="3">No results found</td>
    </tr>
<?php endif; ?>
</table>

<?php require_once "../includes/footer.php"; ?>