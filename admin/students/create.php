<?php
require_once "../../config/db.php";
require_once "../../includes/auth_check.php";
checkRole('admin');

// Fetch departments
$departments = $conn->query("
    SELECT * FROM departments ORDER BY department_name
")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $roll = $_POST['roll_no'];
    $dept_id = $_POST['department_id'];
    $sem = $_POST['semester'];

    // Insert into users
    $sql1 = "INSERT INTO users (name, email, password, role) 
             VALUES (:name, :email, :password, 'student')";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $password
    ]);

    $user_id = $conn->lastInsertId();

    // Insert into students
    $sql2 = "INSERT INTO students (user_id, roll_no, department_id, semester)
             VALUES (:user_id, :roll, :dept_id, :sem)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([
        ':user_id' => $user_id,
        ':roll' => $roll,
        ':dept_id' => $dept_id,
        ':sem' => $sem
    ]);

    header("Location: view.php");
    exit();
}
?>

<?php require_once "../../includes/header.php"; ?>
<?php require_once "../../includes/navbar.php"; ?>
<?php require_once "../../includes/sidebar.php"; ?>

<h3>Add Student</h3>

<form method="POST" class="card p-3 shadow-sm">

    <input name="name" class="form-control mb-2" placeholder="Name" required>

    <input name="email" class="form-control mb-2" placeholder="Email" required>

    <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>

    <input name="roll_no" class="form-control mb-2" placeholder="Roll No" required>

    <!-- DEPARTMENT DROPDOWN -->
    <label class="form-label">Select Department</label>
    <select name="department_id" class="form-control mb-2" required>
        <option value="">-- Select Department --</option>
        <?php foreach ($departments as $d): ?>
            <option value="<?= $d['id'] ?>">
                <?= htmlspecialchars($d['department_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input name="semester" class="form-control mb-2" placeholder="Semester" required>

    <button class="btn btn-success">Save Student</button>
</form>

<?php require_once "../../includes/footer.php"; ?>