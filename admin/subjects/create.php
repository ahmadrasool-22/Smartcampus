<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

// Fetch teachers
$teachers = $conn->query("
    SELECT teachers.id, users.name 
    FROM teachers 
    JOIN users ON teachers.user_id = users.id
")->fetchAll(PDO::FETCH_ASSOC);

// Fetch departments
$departments = $conn->query("
    SELECT * FROM departments ORDER BY department_name
")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['subject_name'];
    $code = $_POST['subject_code'];
    $teacher = $_POST['teacher_id'];
    $semester = $_POST['semester'];
    $dept_id = $_POST['department_id'];

    $sql = "INSERT INTO subjects 
            (subject_name, subject_code, teacher_id, semester, department_id)
            VALUES 
            (:name, :code, :teacher, :semester, :dept_id)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':code' => $code,
        ':teacher' => $teacher,
        ':semester' => $semester,
        ':dept_id' => $dept_id
    ]);

    header("Location: view.php");
    exit();
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Add Subject</h3>

<form method="POST" class="card p-3 shadow-sm">

    <input name="subject_name" class="form-control mb-2" placeholder="Subject Name" required>

    <input name="subject_code" class="form-control mb-2" placeholder="Subject Code" required>

    <!-- DEPARTMENT DROPDOWN -->
    <label class="form-label">Select Department</label>
    <select name="department_id" class="form-control mb-2" required>
        <option value="">-- Select Department --</option>
        <?php foreach ($departments as $d): ?>
            <option value="<?= $d['id'] ?>">
                <?= htmlspecialchars($d['department_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- SEMESTER -->
    <input name="semester" class="form-control mb-2" placeholder="Semester (e.g. 1, 2, 3)" required>

    <!-- TEACHER -->
    <select name="teacher_id" class="form-control mb-2" required>
        <option value="">Select Teacher</option>
        <?php foreach ($teachers as $t): ?>
            <option value="<?= $t['id'] ?>">
                <?= htmlspecialchars($t['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button class="btn btn-success">Save Subject</button>
</form>

<?php require_once "../../includes/footer.php"; ?>