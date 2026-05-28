<?php
require_once "../config/db.php";
require_once "../includes/auth_check.php";
checkRole('teacher');

// Get logged-in teacher user id
$user_id = $_SESSION['user_id'];

// Get teacher ID
$stmt = $conn->prepare("SELECT id FROM teachers WHERE user_id = :uid");
$stmt->execute([':uid' => $user_id]);
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);

$teacher_id = $teacher['id'] ?? 0;

// Get assigned subjects
$stmt = $conn->prepare("SELECT * FROM subjects WHERE teacher_id = :tid");
$stmt->execute([':tid' => $teacher_id]);
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalSubjects = count($subjects);
?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<?php require_once "../includes/sidebar.php"; ?>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Teacher Dashboard</h3>
    <span class="text-muted">Welcome, <?= $_SESSION['name'] ?></span>
</div>

<!-- STATS CARDS -->
<div class="row g-4">

    <!-- Subjects -->
    <div class="col-md-4">
        <div class="card hover-card shadow-sm text-center p-4">
            <div class="icon-circle bg-primary">
                <i class="bi bi-book-fill"></i>
            </div>
            <h6 class="text-muted">Assigned Subjects</h6>
            <h2 class="fw-bold"><?= $totalSubjects ?></h2>
        </div>
    </div>

    <!-- Attendance Shortcut -->
    <div class="col-md-4">
        <div class="card hover-card shadow-sm text-center p-4">
            <div class="icon-circle bg-success">
                <i class="bi bi-calendar-check-fill"></i>
            </div>
            <h6 class="text-muted">Attendance</h6>
            <a href="attendance/mark.php" class="btn btn-sm btn-outline-dark mt-2">
                Mark Attendance
            </a>
        </div>
    </div>

    <!-- Marks Shortcut -->
    <div class="col-md-4">
        <div class="card hover-card shadow-sm text-center p-4">
            <div class="icon-circle bg-danger">
                <i class="bi bi-bar-chart-fill"></i>
            </div>
            <h6 class="text-muted">Marks</h6>
            <a href="marks/add.php" class="btn btn-sm btn-outline-dark mt-2">
                Add Marks
            </a>
        </div>
    </div>

</div>

<!-- QUICK ACTIONS -->
<div class="row g-4 mt-4">

    <div class="col-md-3">
        <a href="attendance/mark.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-success">
                    <i class="bi bi-calendar-plus"></i>
                </div>
                <p class="mb-0 fw-semibold">Mark Attendance</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="attendance/view.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-info">
                    <i class="bi bi-eye-fill"></i>
                </div>
                <p class="mb-0 fw-semibold">View Attendance</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="marks/add.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-danger">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <p class="mb-0 fw-semibold">Add Marks</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="materials/upload.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-warning">
                    <i class="bi bi-upload"></i>
                </div>
                <p class="mb-0 fw-semibold">Upload Material</p>
            </div>
        </a>
    </div>

</div>

<!-- SUBJECT LIST -->
<div class="card shadow-sm mt-5 p-3">

    <h5 class="mb-3">Your Subjects</h5>

    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Subject Name</th>
                <th>Code</th>
                <th>Semester</th>
                <th>Department</th>
            </tr>
        </thead>

        <tbody>
        <?php if ($subjects): ?>
            <?php foreach ($subjects as $s): ?>
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= $s['subject_name'] ?></td>
                    <td><?= $s['subject_code'] ?></td>
                    <td><?= $s['semester'] ?></td>
                    <td><?= $s['department'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center text-muted">
                    No subjects assigned
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>

<?php require_once "../includes/footer.php"; ?>