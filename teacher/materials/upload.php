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

// Get subjects
$subjects = $conn->prepare("SELECT * FROM subjects WHERE teacher_id=:tid");
$subjects->execute([':tid'=>$teacher_id]);
$subjects = $subjects->fetchAll(PDO::FETCH_ASSOC);

// Upload logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_id = $_POST['subject_id'];

    if (isset($_FILES['file'])) {

        $file_name = time() . "_" . $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];

        $path = "../../assets/uploads/materials/" . $file_name;

        if (move_uploaded_file($tmp, $path)) {

            $sql = "INSERT INTO materials (subject_id, teacher_id, file_name)
                    VALUES (:sub, :tid, :file)";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':sub' => $subject_id,
                ':tid' => $teacher_id,
                ':file' => $file_name
            ]);

            echo "<div class='alert alert-success'>File Uploaded!</div>";
        } else {
            echo "<div class='alert alert-danger'>Upload Failed!</div>";
        }
    }
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Upload Material</h3>

<form method="POST" enctype="multipart/form-data">

<select name="subject_id" class="form-control mb-3" required>
    <option value="">Select Subject</option>
    <?php foreach ($subjects as $s): ?>
        <option value="<?= $s['id'] ?>"><?= $s['subject_name'] ?></option>
    <?php endforeach; ?>
</select>

<input type="file" name="file" class="form-control mb-3" required>

<button class="btn btn-success">Upload</button>
</form>

<?php require_once "../../includes/footer.php"; ?>