<?php include 'includes/header.php'; ?>
<?php include 'db/conn.php'; ?>

<h2 style="text-align:center; margin-top: 20px;">Search Results</h2>

<div class="course-list">
<?php
if (!empty($_GET['q'])) {
    $search = mysqli_real_escape_string($conn, $_GET['q']);
    $query = "SELECT * FROM courses WHERE name LIKE '%$search%' OR description LIKE '%$search%'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="course-card">';
            echo '<img src="uploads/thumbnails/' . $row['thumbnail'] . '" alt="Course">';
            echo '<h3>' . $row['name'] . '</h3>';
            echo '<p style="margin: 5px 0;">⭐ ' . number_format($row['rating'], 1) . ' (' . $row['total_ratings'] . ' ratings)</p>';
            echo '<a href="course.php?id=' . $row['id'] . '">View Course</a>';
            echo '</div>';
        }
    } else {
        echo "<p style='text-align:center;'>No courses found matching your search.</p>";
    }
} else {
    echo "<p style='text-align:center;'>Please enter a search term.</p>";
}
?>
</div>

<?php include 'includes/footer.php'; ?>
