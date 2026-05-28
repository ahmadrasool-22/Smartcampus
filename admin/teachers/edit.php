<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

$id = $_GET['id'];

$sql = "SELECT teachers.*, users.name, users.email 
        FROM teachers 
        JOIN users ON teachers.user_id = users.id
        WHERE teachers.id = :id";

$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $dept = $_POST['department'];

    // Update users
    $conn->prepare("UPDATE users SET name=:name, email=:email WHERE id=:uid")
         ->execute([
             ':name'=>$name,
             ':email'=>$email,
             ':uid'=>$data['user_id']
         ]);

    // Update teachers
    $conn->prepare("UPDATE teachers SET department=:dept WHERE id=:id")
         ->execute([
             ':dept'=>$dept,
             ':id'=>$id
         ]);

    header("Location: view.php");
    exit();
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Edit Teacher</h3>

<form method="POST">
    <input name="name" value="<?= $data['name'] ?>" class="form-control mb-2">
    <input name="email" value="<?= $data['email'] ?>" class="form-control mb-2">
    <input name="department" value="<?= $data['department'] ?>" class="form-control mb-2">

    <button class="btn btn-primary">Update</button>
</form>

<?php require_once "../../includes/footer.php"; ?>