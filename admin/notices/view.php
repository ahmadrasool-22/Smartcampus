<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

// Fetch notices
$stmt = $conn->query("SELECT * FROM notices ORDER BY created_at DESC");
$notices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Notices</h3>
<a href="create.php" class="btn btn-primary mb-3">Add Notice</a>

<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php foreach ($notices as $n): ?>
<tr>
    <td><?= $n['id'] ?></td>
    <td><?= $n['title'] ?></td>
    <td><?= $n['description'] ?></td>
    <td><?= $n['created_at'] ?></td>
    <td>
        <a href="delete.php?id=<?= $n['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php require_once "../../includes/footer.php"; ?>