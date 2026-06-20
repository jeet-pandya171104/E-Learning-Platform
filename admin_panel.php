<?php include 'includes/header.php'; ?>
<?php
include 'db/conn.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle course deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM courses WHERE id=$id");
    header("Location: admin_panel.php");
}
?>

<h2 style="text-align:center; margin-top: 20px;">Admin Panel - Manage Courses</h2>
<div style="text-align:center; margin-bottom: 15px;">
    <a href="add_course.php" class="btn">+ Add New Course</a>
</div>

<div class="course-list">
<?php
$result = mysqli_query($conn, "SELECT * FROM courses ORDER BY id DESC");
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="course-card">';
    echo '<img src="uploads/thumbnails/' . $row['thumbnail'] . '" alt="' . $row['name'] . '">';
    echo '<h3>' . $row['name'] . '</h3>';
    echo '<p>' . $row['duration'] . '</p>';
    echo '<a href="?delete=' . $row['id'] . '" onclick="return confirm(\'Delete this course?\')" style="background:#e74c3c;">Delete</a>';
    echo '</div>';
}
?>
</div>
<?php include 'includes/footer.php'; ?>

</body>
</html>
