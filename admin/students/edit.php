<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

$id = $_GET['id'];

// Fetch data
$sql = "SELECT students.*, users.name, users.email 
        FROM students 
        JOIN users ON students.user_id = users.id
        WHERE students.id = :id";

$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $roll = $_POST['roll_no'];
    $dept = $_POST['department'];
    $sem = $_POST['semester'];

    // Update users
    $sql1 = "UPDATE users SET name=:name, email=:email WHERE id=:uid";
    $conn->prepare($sql1)->execute([
        ':name'=>$name,
        ':email'=>$email,
        ':uid'=>$data['user_id']
    ]);

    // Update students
    $sql2 = "UPDATE students SET roll_no=:roll, department=:dept, semester=:sem WHERE id=:id";
    $conn->prepare($sql2)->execute([
        ':roll'=>$roll,
        ':dept'=>$dept,
        ':sem'=>$sem,
        ':id'=>$id
    ]);

    header("Location: view.php");
    exit();
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Edit Student</h3>

<form method="POST">
    <input name="name" value="<?= $data['name'] ?>" class="form-control mb-2">
    <input name="email" value="<?= $data['email'] ?>" class="form-control mb-2">
    <input name="roll_no" value="<?= $data['roll_no'] ?>" class="form-control mb-2">
    <input name="department" value="<?= $data['department'] ?>" class="form-control mb-2">
    <input name="semester" value="<?= $data['semester'] ?>" class="form-control mb-2">

    <button class="btn btn-primary">Update</button>
</form>

<?php require_once "../../includes/footer.php"; ?>