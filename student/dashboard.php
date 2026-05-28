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

// Total subjects
$totalSubjects = $conn->query("SELECT COUNT(*) as total FROM subjects")
                      ->fetch(PDO::FETCH_ASSOC)['total'];

// Attendance %
$att = $conn->prepare("
    SELECT 
        SUM(CASE WHEN status='present' THEN 1 ELSE 0 END) as present_count,
        COUNT(*) as total
    FROM attendance
    WHERE student_id=:sid
");

$att->execute([':sid'=>$student_id]);
$data = $att->fetch(PDO::FETCH_ASSOC);

$percentage = 0;
if ($data['total'] > 0) {
    $percentage = ($data['present_count'] / $data['total']) * 100;
}
?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<?php require_once "../includes/sidebar.php"; ?>

<!-- PAGE HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Student Dashboard</h3>
    <span class="text-muted">Welcome, <?= $_SESSION['name'] ?></span>
</div>

<!-- STATS CARDS -->
<div class="row g-4">

    <!-- Attendance -->
    <div class="col-md-4">
        <div class="card hover-card shadow-sm text-center p-4">
            
            <div class="icon-circle bg-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <h6 class="text-muted">Attendance</h6>
            <h2 class="fw-bold"><?= round($percentage, 2) ?>%</h2>
        </div>
    </div>

    <!-- Subjects -->
    <div class="col-md-4">
        <div class="card hover-card shadow-sm text-center p-4">
            
            <div class="icon-circle bg-primary">
                <i class="bi bi-book-fill"></i>
            </div>

            <h6 class="text-muted">Total Subjects</h6>
            <h2 class="fw-bold"><?= $totalSubjects ?></h2>
        </div>
    </div>

    <!-- Exam Slip -->
    <div class="col-md-4">
        <div class="card hover-card shadow-sm text-center p-4">
            
            <div class="icon-circle bg-warning">
                <i class="bi bi-file-earmark-text-fill"></i>
            </div>

            <h6 class="text-muted">Exam Slip</h6>
            <a href="roll_slip.php" class="btn btn-dark btn-sm mt-2">
                View Slip
            </a>
        </div>
    </div>

</div>

<!-- QUICK ACTION CARDS -->
<div class="row g-4 mt-4">

    <div class="col-md-3">
        <a href="attendance.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-success">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <p class="mb-0 fw-semibold">Attendance</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="results.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-danger">
                    <i class="bi bi-bar-chart-fill"></i>
                </div>
                <p class="mb-0 fw-semibold">Results</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="materials.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-primary">
                    <i class="bi bi-folder-fill"></i>
                </div>
                <p class="mb-0 fw-semibold">Materials</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="notices.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-warning">
                    <i class="bi bi-megaphone-fill"></i>
                </div>
                <p class="mb-0 fw-semibold">Notices</p>
            </div>
        </a>
    </div>

</div>

<?php require_once "../includes/footer.php"; ?>