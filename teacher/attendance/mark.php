<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('teacher');

$user_id = $_SESSION['user_id'];

// Get teacher ID
$stmt = $conn->prepare("SELECT id FROM teachers WHERE user_id=:uid");
$stmt->execute([':uid'=>$user_id]);
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);
$teacher_id = $teacher['id'];

// Get subjects of this teacher
$subjects = $conn->prepare("SELECT * FROM subjects WHERE teacher_id=:tid");
$subjects->execute([':tid'=>$teacher_id]);
$subjects = $subjects->fetchAll(PDO::FETCH_ASSOC);

$students = [];

// STEP 1: Load students based on subject
if (isset($_POST['load_students'])) {

    $subject_id = $_POST['subject_id'];

    // Get subject info
    $sub = $conn->prepare("SELECT department_id, semester FROM subjects WHERE id=:id");
    $sub->execute([':id'=>$subject_id]);
    $subData = $sub->fetch(PDO::FETCH_ASSOC);

    if ($subData) {

        $dept_id = $subData['department_id'];
        $semester = $subData['semester'];

        // Get students of same dept + semester
        $stmt = $conn->prepare("
            SELECT students.id, users.name 
            FROM students
            JOIN users ON students.user_id = users.id
            WHERE students.department_id = :dept
            AND students.semester = :sem
        ");

        $stmt->execute([
            ':dept' => $dept_id,
            ':sem' => $semester
        ]);

        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// STEP 2: Save attendance
if (isset($_POST['save_attendance'])) {

    $subject_id = $_POST['subject_id'];
    $date = date("Y-m-d");

    foreach ($_POST['attendance'] as $student_id => $status) {

        $sql = "INSERT INTO attendance 
                (student_id, subject_id, status, attendance_date)
                VALUES (:sid, :sub, :status, :date)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':sid' => $student_id,
            ':sub' => $subject_id,
            ':status' => $status,
            ':date' => $date
        ]);
    }

    echo "<div class='alert alert-success'>Attendance Saved!</div>";
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Mark Attendance</h3>

<form method="POST">

    <!-- SUBJECT DROPDOWN -->
    <select name="subject_id" class="form-control mb-2" required>
        <option value="">Select Subject</option>
        <?php foreach ($subjects as $s): ?>
            <option value="<?= $s['id'] ?>">
                <?= htmlspecialchars($s['subject_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- LOAD BUTTON -->
    <button name="load_students" class="btn btn-primary mb-3">
        Load Students
    </button>

    <!-- STUDENT TABLE -->
    <?php if (!empty($students)): ?>

        <table class="table table-bordered">
            <tr>
                <th>Student</th>
                <th>Status</th>
            </tr>

            <?php foreach ($students as $st): ?>
            <tr>
                <td><?= htmlspecialchars($st['name']) ?></td>
                <td>
                    <select name="attendance[<?= $st['id'] ?>]" class="form-control">
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                    </select>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <button name="save_attendance" class="btn btn-success">
            Save Attendance
        </button>

    <?php endif; ?>

</form>

<?php require_once "../../includes/footer.php"; ?>