<?php include 'includes/header.php'; ?>
<?php
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SIMPLE hardcoded check for demo
   if ($username === 'admin' && $password === 'admin') {
    $_SESSION['admin'] = true;
    header("Location: admin_dashboard.php");
    exit;
}
 else {
        $error = "Invalid credentials.";
    }
}
?>

<div class="form-container">
    <h2>Admin Login</h2>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Admin Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>

</body>
</html>
