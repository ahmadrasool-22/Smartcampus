<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

$sql = "
SELECT 
    teachers.id,
    users.name,
    users.email,
    departments.department_name
FROM teachers
JOIN users ON teachers.user_id = users.id
LEFT JOIN departments ON teachers.department_id = departments.id
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Teachers</h3>

<a href="create.php" class="btn btn-primary mb-3">
    Add Teacher
</a>

<table class="table table-bordered table-hover">

<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Department</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php foreach ($teachers as $row): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td>
        <?= $row['department_name'] ?? 'Not Assigned' ?>
    </td>
    <td>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
            Edit
        </a>

        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Delete this teacher?')">
            Delete
        </a>
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<?php require_once "../../includes/footer.php"; ?>