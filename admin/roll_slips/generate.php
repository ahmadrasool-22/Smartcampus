<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

// Fetch departments
$departments = $conn->query("
    SELECT * FROM departments ORDER BY department_name
")->fetchAll(PDO::FETCH_ASSOC);

$subjects = [];

// STEP 1: Load subjects
if (isset($_POST['load_subjects'])) {

    $dept_id = $_POST['department_id'];
    $semester = $_POST['semester'];

    $subStmt = $conn->prepare("
        SELECT * FROM subjects 
        WHERE department_id = :dept_id AND semester = :sem
    ");

    $subStmt->execute([
        ':dept_id' => $dept_id,
        ':sem' => $semester
    ]);

    $subjects = $subStmt->fetchAll(PDO::FETCH_ASSOC);
}

// STEP 2: Generate roll slips
if (isset($_POST['generate'])) {

    $dept_id = $_POST['department_id'];
    $semester = $_POST['semester'];

    // Get department name (for display in slip)
    $d = $conn->prepare("SELECT department_name FROM departments WHERE id=:id");
    $d->execute([':id' => $dept_id]);
    $deptData = $d->fetch(PDO::FETCH_ASSOC);
    $dept_name = $deptData['department_name'] ?? '';

    // Get students
    $stmt = $conn->prepare("
        SELECT * FROM students 
        WHERE department_id = :dept_id AND semester = :sem
    ");

    $stmt->execute([
        ':dept_id' => $dept_id,
        ':sem' => $semester
    ]);

    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($students as $st) {

        $subjectData = [];

        foreach ($_POST['subject_date'] as $subject_id => $date) {

            $s = $conn->prepare("SELECT subject_name FROM subjects WHERE id=:id");
            $s->execute([':id' => $subject_id]);
            $sub = $s->fetch(PDO::FETCH_ASSOC);

            $subjectData[] = [
                "subject_name" => $sub['subject_name'],
                "exam_date" => $date
            ];
        }

        $slipContent = json_encode([
            "student_name" => $st['roll_no'],
            "department" => $dept_name,
            "semester" => $semester,
            "subjects" => $subjectData
        ]);

        $sql = "INSERT INTO roll_slips 
                (student_id, department_id, semester, slip_data)
                VALUES (:sid, :dept_id, :sem, :data)";

        $conn->prepare($sql)->execute([
            ':sid' => $st['id'],
            ':dept_id' => $dept_id,
            ':sem' => $semester,
            ':data' => $slipContent
        ]);
    }

    echo "<div class='alert alert-success'>Roll slips generated successfully!</div>";
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Generate Roll Slips</h3>

<form method="POST">

    <!-- Department Dropdown -->
    <label class="form-label">Select Department</label>
    <select name="department_id" class="form-control mb-2" required>
        <option value="">-- Select Department --</option>
        <?php foreach ($departments as $d): ?>
            <option value="<?= $d['id'] ?>">
                <?= htmlspecialchars($d['department_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Semester -->
    <input name="semester" class="form-control mb-2" placeholder="Semester" required>

    <!-- Load Subjects -->
    <button name="load_subjects" class="btn btn-primary mb-3">
        Load Subjects
    </button>

    <!-- SUBJECTS -->
    <?php if (!empty($subjects)): ?>

        <h5>Assign Exam Dates</h5>

        <?php foreach ($subjects as $sub): ?>
            <div class="mb-2">
                <label><b><?= htmlspecialchars($sub['subject_name']) ?></b></label>
                <input type="date"
                       name="subject_date[<?= $sub['id'] ?>]"
                       class="form-control"
                       required>
            </div>
        <?php endforeach; ?>

        <button name="generate" class="btn btn-success mt-3">
            Generate Roll Slips
        </button>

    <?php endif; ?>

</form>