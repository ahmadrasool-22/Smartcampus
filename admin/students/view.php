<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

$sql = "
SELECT 
    students.id,
    students.roll_no,
    students.semester,
    users.name,
    users.email,
    departments.department_name
FROM students
JOIN users ON students.user_id = users.id
LEFT JOIN departments ON students.department_id = departments.id
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Students</h3>

<a href="create.php" class="btn btn-primary mb-3">
    Add Student
</a>

<table class="table table-bordered table-hover">

<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Roll No</th>
    <th>Department</th>
    <th>Semester</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php foreach ($students as $row): ?>
<tr>
    <td><?= $row['id'] ?></td>

    <td><?= htmlspecialchars($row['name']) ?></td>

    <td><?= htmlspecialchars($row['email']) ?></td>

    <td><?= htmlspecialchars($row['roll_no']) ?></td>

    <td>
        <span class="badge bg-primary">
            <?= $row['department_name'] ?? 'N/A' ?>
        </span>
    </td>

    <td>
        <span class="badge bg-secondary">
            Semester <?= $row['semester'] ?>
        </span>
    </td>

    <td>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
            Edit
        </a>

        <a href="delete.php?id=<?= $row['id'] ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Delete this student?')">
            Delete
        </a>
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<?php require_once "../../includes/footer.php"; ?>