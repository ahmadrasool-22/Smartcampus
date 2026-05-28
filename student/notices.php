<?php
require_once "../config/db.php";
require_once "../includes/auth_check.php";
checkRole('student');

// Get all notices
$sql = "SELECT * FROM notices ORDER BY created_at DESC";
$data = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../includes/header.php"; ?>
<?php require_once "../includes/navbar.php"; ?>
<?php require_once "../includes/sidebar.php"; ?>

<h3>Notices</h3>

<?php if ($data): ?>
    <?php foreach ($data as $row): ?>
        <div class="card mb-3 p-3">
            <h5><?= $row['title'] ?></h5>
            <p><?= $row['description'] ?></p>
            <small class="text-muted">
                <?= $row['created_at'] ?>
            </small>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No notices available</p>
<?php endif; ?>

<?php require_once "../includes/footer.php"; ?>