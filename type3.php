<?php include 'includes/header.php'; ?>
<?php include 'db/conn.php'; ?>

<h2 style="text-align:center; margin-top: 20px;">Management Courses</h2>

<div class="course-list">
<?php
$result = mysqli_query($conn, "SELECT * FROM courses WHERE type = 'type-3'");
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="course-card">';
    echo '<img src="uploads/thumbnails/' . $row['thumbnail'] . '" alt="' . $row['name'] . '">';
    echo '<h3>' . $row['name'] . '</h3>';
    echo '<a href="course.php?id=' . $row['id'] . '">View Course</a>';
    echo '</div>';
}
?>
</div>

<?php include 'includes/footer.php'; ?>
