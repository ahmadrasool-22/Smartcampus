<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

$departments = $conn->query("SELECT * FROM departments ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Departments</h3>
    <a href="create.php" class="btn btn-primary">+ Add Department</a>
</div>

<table class="table table-bordered table-hover">

    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Department Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php if ($departments): ?>
            <?php foreach ($departments as $d): ?>
                <tr>
                    <td><?= $d['id'] ?></td>
                    <td><?= htmlspecialchars($d['department_name']) ?></td>
                    <td>
                        <a href="delete.php?id=<?= $d['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this department?')">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">No departments found</td>
            </tr>
        <?php endif; ?>
    </tbody>

</table>

<?php require_once "../../includes/footer.php"; ?>