<div class="d-flex">
    <div class="bg-light border" style="width: 220px; min-height: 100vh;">
        <ul class="nav flex-column p-3">
            <style>
.sidebar-link {
    padding: 10px 12px;
    border-radius: 10px;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: 0.2s;
}

.sidebar-link:hover {
    background: #f1f3f5;
    transform: translateX(4px);
}

.sidebar-link.active {
    background: #0d6efd;
    color: white !important;
}
</style>

    <?php if ($_SESSION['role'] === 'admin'): ?>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/admin/dashboard.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/admin/students/view.php">
        <i class="bi bi-people"></i> Students
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/admin/teachers/view.php">
        <i class="bi bi-person-badge"></i> Teachers
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/admin/department/view.php">
        <i class="bi bi-person-badge"></i> Department
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/admin/subjects/view.php">
        <i class="bi bi-book"></i> Subjects
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/admin/roll_slips/generate.php">
        <i class="bi bi-file-earmark-text"></i> Roll Slips
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/admin/notices/view.php">
        <i class="bi bi-megaphone"></i> Notices
    </a>
</li>

<?php endif; ?>

           <?php if ($_SESSION['role'] === 'teacher'): ?>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/teacher/dashboard.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/teacher/attendance/mark.php">
        <i class="bi bi-calendar-plus"></i> Mark Attendance
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/teacher/attendance/view.php">
        <i class="bi bi-eye"></i> View Attendance
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/teacher/marks/add.php">
        <i class="bi bi-plus-circle"></i> Add Marks
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/teacher/marks/view.php">
        <i class="bi bi-bar-chart"></i> View Marks
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/teacher/materials/upload.php">
        <i class="bi bi-upload"></i> Upload Materials
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/teacher/materials/view.php">
        <i class="bi bi-folder"></i> View Materials
    </a>
</li>

<?php endif; ?>

<?php if ($_SESSION['role'] === 'student'): ?>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/student/dashboard.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/student/attendance.php">
        <i class="bi bi-calendar-check"></i> Attendance
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/student/results.php">
        <i class="bi bi-graph-up"></i> Results
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/student/materials.php">
        <i class="bi bi-folder"></i> Materials
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/student/roll_slip.php">
        <i class="bi bi-file-earmark-text"></i> Roll Slip
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link" href="/student-portal/student/notices.php">
        <i class="bi bi-megaphone"></i> Notices
    </a>
</li>

<?php endif; ?>

        </ul>
    </div>

    <div class="p-4" style="width: 100%;">