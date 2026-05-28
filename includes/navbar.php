<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">SmartCampus</span>

    <div class="text-white">
        Welcome, <?= $_SESSION['name'] ?? 'User' ?> |
        <a href="/student-portal/logout.php" class="text-warning text-decoration-none">Logout</a>
    </div>
</nav>