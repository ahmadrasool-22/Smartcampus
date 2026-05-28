<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('teacher');

$user_id = $_SESSION['user_id'];

// Get teacher id
$stmt = $conn->prepare("SELECT id FROM teachers WHERE user_id=:uid");
$stmt->execute([':uid'=>$user_id]);
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);
$teacher_id = $teacher['id'];

// Get teacher subjects
$subjects = $conn->prepare("SELECT * FROM subjects WHERE teacher_id=:tid");
$subjects->execute([':tid'=>$teacher_id]);
$subjects = $subjects->fetchAll(PDO::FETCH_ASSOC);

// Get students
$students = $conn->query("
    SELECT students.id, users.name 
    FROM students 
    JOIN users ON students.user_id = users.id
")->fetchAll(PDO::FETCH_ASSOC);

// Save marks
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_id = $_POST['subject_id'];

    foreach ($_POST['marks'] as $student_id => $marks) {

        // Check if already exists
        $check = $conn->prepare("
            SELECT id FROM marks 
            WHERE student_id=:sid AND subject_id=:sub
        ");
        $check->execute([
            ':sid'=>$student_id,
            ':sub'=>$subject_id
        ]);

        if ($check->rowCount() > 0) {
            // Update
            $conn->prepare("
                UPDATE marks 
                SET marks=:marks 
                WHERE student_id=:sid AND subject_id=:sub
            ")->execute([
                ':marks'=>$marks,
                ':sid'=>$student_id,
                ':sub'=>$subject_id
            ]);
        } else {
            // Insert
            $conn->prepare("
                INSERT INTO marks (student_id, subject_id, marks)
                VALUES (:sid, :sub, :marks)
            ")->execute([
                ':sid'=>$student_id,
                ':sub'=>$subject_id,
                ':marks'=>$marks
            ]);
        }
    }

    echo "<div class='alert alert-success'>Marks Saved!</div>";
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Add / Update Marks</h3>

<form method="POST">

<select name="subject_id" class="form-control mb-3" required>
    <option value="">Select Subject</option>
    <?php foreach ($subjects as $s): ?>
        <option value="<?= $s['id'] ?>"><?= $s['subject_name'] ?></option>
    <?php endforeach; ?>
</select>

<table class="table table-bordered">
<tr>
    <th>Student</th>
    <th>Marks</th>
</tr>

<?php foreach ($students as $st): ?>
<tr>
    <td><?= $st['name'] ?></td>
    <td>
        <input type="number" name="marks[<?= $st['id'] ?>]" class="form-control" required>
    </td>
</tr>
<?php endforeach; ?>
</table>

<button class="btn btn-success">Save Marks</button>
</form>

<?php require_once "../../includes/footer.php"; ?>