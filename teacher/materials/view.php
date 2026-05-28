<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('teacher');

$sql = "SELECT materials.*, subjects.subject_name
        FROM materials
        JOIN subjects ON materials.subject_id = subjects.id
        ORDER BY uploaded_at DESC";

$data = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Uploaded Materials</h3>

<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>Subject</th>
    <th>File</th>
    <th>Date</th>
</tr>

<?php foreach ($data as $row): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['subject_name'] ?></td>
    <td>
        <a href="/student-portal/assets/uploads/materials/<?= $row['file_name'] ?>" target="_blank">
            see content
        </a>
    </td>
    <td><?= $row['uploaded_at'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php require_once "../../includes/footer.php"; ?>