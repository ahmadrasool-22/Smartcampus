<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $desc = $_POST['description'];

    $sql = "INSERT INTO notices (title, description) VALUES (:title, :desc)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':title' => $title,
        ':desc' => $desc
    ]);

    header("Location: view.php");
    exit();
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Add Notice</h3>

<form method="POST">
    <input name="title" class="form-control mb-2" placeholder="Title" required>
    <textarea name="description" class="form-control mb-2" placeholder="Description" required></textarea>

    <button class="btn btn-success">Post Notice</button>
</form>

<?php require_once "../../includes/footer.php"; ?>