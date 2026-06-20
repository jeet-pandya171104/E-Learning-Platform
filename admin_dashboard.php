<?php
include 'includes/header.php';
?>

<h2 style="text-align: center; margin-top: 30px;">Admin Dashboard</h2>

<div style="display: flex; justify-content: center; gap: 40px; margin-top: 50px;">
    <!-- Course Management -->
    <div style="border: 1px solid #ccc; border-radius: 12px; padding: 20px; width: 250px; text-align: center;">
        <h3>Course Management</h3>
        <p>Add or delete courses</p>
        <a href="add_course.php" style="padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 6px;">Go</a>
    </div>

    <!-- Poster Management -->
    <div style="border: 1px solid #ccc; border-radius: 12px; padding: 20px; width: 250px; text-align: center;">
        <h3>Poster Management</h3>
        <p>Add or delete homepage posters</p>
        <a href="admin_manage_posters.php" style="padding: 10px 20px; background-color: #2ecc71; color: white; text-decoration: none; border-radius: 6px;">Go</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
