<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

if ($_POST) {
    $name = trim($_POST['department_name']);

    $stmt = $conn->prepare("INSERT INTO departments (department_name) VALUES (:name)");
    $stmt->execute([':name' => $name]);

    header("Location: view.php");
    exit();
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Create Department</h3>

<form method="POST" class="card p-3 shadow-sm">

    <label class="form-label">Department Name</label>
    <input type="text" name="department_name" class="form-control mb-3" required>

    <button class="btn btn-success">Save Department</button>
    <a href="view.php" class="btn btn-secondary">Back</a>

</form>

<?php require_once "../../includes/footer.php"; ?>