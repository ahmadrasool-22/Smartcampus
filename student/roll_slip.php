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

// Get ONLY latest slip
$stmt = $conn->prepare("
    SELECT roll_slips.*, departments.department_name
    FROM roll_slips
    LEFT JOIN departments 
        ON roll_slips.department_id = departments.id
    WHERE roll_slips.student_id = :sid
    ORDER BY roll_slips.id DESC
    LIMIT 1
");

$stmt->execute([':sid'=>$student_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$slip = $row ? json_decode($row['slip_data'], true) : null;
?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<?php require_once "../includes/sidebar.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">My Roll Slip</h3>

    <a href="download_slip.php" class="btn btn-success">
        Download PDF
    </a>
</div>

<?php if ($row && $slip): ?>

<div class="card shadow p-4">

    <!-- Header -->
    <div class="text-center mb-3">
        <h4>📄 Exam Roll Slip</h4>
        <hr>
    </div>

    <!-- Basic Info -->
    <div class="row mb-3">
        <div class="col-md-4">
            <b>Department:</b> <?= htmlspecialchars($row['department_name']) ?>
        </div>

        <div class="col-md-4">
            <b>Semester:</b> <?= htmlspecialchars($row['semester']) ?>
        </div>
    </div>

    <!-- Student Info -->
    <div class="mb-3">
        <b>Student ID:</b> <?= htmlspecialchars($slip['student_name']) ?>
    </div>

    <!-- Subjects Table -->
    <h5 class="mt-4">Exam Schedule</h5>

    <table class="table table-bordered table-striped mt-2">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Subject</th>
                <th>Exam Date</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($slip['subjects'] as $index => $sub): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($sub['subject_name']) ?></td>
                    <td><?= htmlspecialchars($sub['exam_date']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php else: ?>
    <div class="alert alert-warning">
        No roll slip found.
    </div>
<?php endif; ?>

<?php require_once "../includes/footer.php"; ?>