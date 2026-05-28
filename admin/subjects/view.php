<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

$sql = "
SELECT 
    subjects.id,
    subjects.subject_name,
    subjects.subject_code,
    subjects.semester,
    users.name AS teacher_name,
    departments.department_name
FROM subjects
LEFT JOIN teachers ON subjects.teacher_id = teachers.id
LEFT JOIN users ON teachers.user_id = users.id
LEFT JOIN departments ON subjects.department_id = departments.id
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Subjects</h3>

<a href="create.php" class="btn btn-primary mb-3">
    Add Subject
</a>

<table class="table table-bordered table-hover">

<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Subject Name</th>
    <th>Code</th>
    <th>Department</th>
    <th>Semester</th>
    <th>Teacher</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php foreach ($subjects as $row): ?>
<tr>
    <td><?= $row['id'] ?></td>

    <td><?= htmlspecialchars($row['subject_name']) ?></td>

    <td><?= htmlspecialchars($row['subject_code']) ?></td>

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
        <?= $row['teacher_name'] ?? 'Not Assigned' ?>
    </td>

    <td>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
            Edit
        </a>

        <a href="delete.php?id=<?= $row['id'] ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Delete this subject?')">
            Delete
        </a>
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<?php require_once "../../includes/footer.php"; ?>