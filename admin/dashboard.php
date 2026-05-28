<?php
require_once "../config/db.php";
require_once "../includes/auth_check.php";
checkRole('admin');

// TOTALS
$totalStudents = $conn->query("SELECT COUNT(*) as c FROM students")->fetch()['c'];
$totalTeachers = $conn->query("SELECT COUNT(*) as c FROM teachers")->fetch()['c'];
$totalSubjects = $conn->query("SELECT COUNT(*) as c FROM subjects")->fetch()['c'];
$totalDepartments  = $conn->query("SELECT COUNT(*) as c FROM departments")->fetch()['c'];
$totalNotices  = $conn->query("SELECT COUNT(*) as c FROM notices")->fetch()['c'];
?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<?php require_once "../includes/sidebar.php"; ?>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Admin Dashboard</h3>
    <span class="text-muted">System Control Panel</span>
</div>

<!-- STATS CARDS -->
<div class="row g-4">

    <!-- Students -->
    <div class="col-md-3">
        <div class="card hover-card text-center p-4 shadow-sm">
            <div class="icon-circle bg-primary">
                <i class="bi bi-people-fill"></i>
            </div>
            <h6 class="text-muted">Students</h6>
            <h2 class="fw-bold"><?= $totalStudents ?></h2>
        </div>
    </div>

    <!-- Teachers -->
    <div class="col-md-3">
        <div class="card hover-card text-center p-4 shadow-sm">
            <div class="icon-circle bg-success">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <h6 class="text-muted">Teachers</h6>
            <h2 class="fw-bold"><?= $totalTeachers ?></h2>
        </div>
    </div>

     <!-- Departments -->
    <div class="col-md-3">
        <div class="card hover-card text-center p-4 shadow-sm">
            <div class="icon-circle bg-warning">
                <i class="bi bi-people-fill"></i>
            </div>
            <h6 class="text-muted">Departments</h6>
            <h2 class="fw-bold"><?= $totalDepartments ?></h2>
        </div>
    </div>

    <!-- Subjects -->
   

    <!-- Notices -->
    <div class="col-md-3">
        <div class="card hover-card text-center p-4 shadow-sm">
            <div class="icon-circle bg-danger">
                <i class="bi bi-megaphone-fill"></i>
            </div>
            <h6 class="text-muted">Notices</h6>
            <h2 class="fw-bold"><?= $totalNotices ?></h2>
        </div>
    </div>

</div>

<!-- QUICK ACTIONS -->
<div class="row g-4 mt-4">

    <div class="col-md-3">
        <a href="students/view.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-primary">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <p class="mb-0 fw-semibold">Manage Students</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="teachers/view.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-success">
                    <i class="bi bi-person-workspace"></i>
                </div>
                <p class="mb-0 fw-semibold">Manage Teachers</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="department/view.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-warning">
                    <i class="bi bi-journal-text"></i>
                </div>
                <p class="mb-0 fw-semibold">Manage Department</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="roll_slips/generate.php" class="text-decoration-none">
            <div class="card hover-card text-center p-4">
                <div class="icon-circle bg-danger">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <p class="mb-0 fw-semibold">Roll Slips</p>
            </div>
        </a>
    </div>

</div>

<?php require_once "../includes/footer.php"; ?>