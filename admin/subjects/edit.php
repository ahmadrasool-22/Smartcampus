<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

$id = $_GET['id'];

// Fetch subject
$subject = $conn->prepare("SELECT * FROM subjects WHERE id=:id");
$subject->execute([':id'=>$id]);
$data = $subject->fetch(PDO::FETCH_ASSOC);

// Fetch teachers
$teachers = $conn->query("
    SELECT teachers.id, users.name 
    FROM teachers 
    JOIN users ON teachers.user_id = users.id
")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn->prepare("UPDATE subjects SET subject_name=:name, subject_code=:code, teacher_id=:teacher WHERE id=:id")
         ->execute([
             ':name'=>$_POST['subject_name'],
             ':code'=>$_POST['subject_code'],
             ':teacher'=>$_POST['teacher_id'],
             ':id'=>$id
         ]);

    header("Location: view.php");
    exit();
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Edit Subject</h3>

<form method="POST">
    <input name="subject_name" value="<?= $data['subject_name'] ?>" class="form-control mb-2">
    <input name="subject_code" value="<?= $data['subject_code'] ?>" class="form-control mb-2">

    <select name="teacher_id" class="form-control mb-2">
        <?php foreach ($teachers as $t): ?>
            <option value="<?= $t['id'] ?>" <?= $t['id']==$data['teacher_id']?'selected':'' ?>>
                <?= $t['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button class="btn btn-primary">Update</button>
</form>

<?php require_once "../../includes/footer.php"; ?>