<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

// Fetch departments
$departments = $conn->query("SELECT * FROM departments ORDER BY department_name")
                    ->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dept_id = $_POST['department_id'];

    // Insert into users table
    $sql1 = "INSERT INTO users (name, email, password, role) 
             VALUES (:name, :email, :password, 'teacher')";

    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $password
    ]);

    $user_id = $conn->lastInsertId();

    // Insert into teachers table
    $sql2 = "INSERT INTO teachers (user_id, department_id)
             VALUES (:user_id, :dept_id)";

    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([
        ':user_id' => $user_id,
        ':dept_id' => $dept_id
    ]);

    header("Location: view.php");
    exit();
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Add Teacher</h3>

<form method="POST" class="card p-3 shadow-sm">

    <input name="name" class="form-control mb-2" placeholder="Name" required>
    <input name="email" class="form-control mb-2" placeholder="Email" required>
    <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>

    <!-- DEPARTMENT DROPDOWN -->
    <label class="form-label">Select Department</label>
    <select name="department_id" class="form-control mb-3" required>
        <option value="">-- Select Department --</option>

        <?php foreach ($departments as $d): ?>
            <option value="<?= $d['id'] ?>">
                <?= htmlspecialchars($d['department_name']) ?>
            </option>
        <?php endforeach; ?>

    </select>

    <button class="btn btn-success">Save Teacher</button>
</form>

<?php require_once "../../includes/footer.php"; ?>