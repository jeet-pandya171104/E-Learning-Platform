<?php
session_start();
include 'includes/header.php';
include 'db/conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_course_id'])) {
    $remove_id = intval($_POST['remove_course_id']);
    mysqli_query($conn, "DELETE FROM favorites WHERE user_id = $user_id AND course_id = $remove_id");
}

// Fetch favourite courses
$query = "SELECT courses.* FROM courses 
          JOIN favorites ON courses.id = favorites.course_id 
          WHERE favorites.user_id = $user_id";

$result = mysqli_query($conn, $query);
?>

<h2 style="text-align:center; margin-top: 30px;">My Favourite Courses</h2>

<div class="course-list">
    <?php while ($course = mysqli_fetch_assoc($result)) : ?>
        <div class="course-card">
            <img src="uploads/thumbnails/<?= $course['thumbnail'] ?>" alt="Course Thumbnail">
            <h3><?= $course['name'] ?></h3>

            <!-- Buttons Row -->
            <div style="display: flex; justify-content: space-between; gap: 10px; margin-top: 10px;">
                <a href="course.php?id=<?= $course['id'] ?>" 
                   style="flex: 1; text-align: center; background-color: #3498db; color: white; padding: 8px 0; border-radius: 5px; text-decoration: none;">
                   View Course
                </a>

                <form method="POST" style="flex: 1;">
                    <input type="hidden" name="remove_course_id" value="<?= $course['id'] ?>">
                    <button type="submit" 
                            style="width: 100%; background-color: #e74c3c; color: white; border: none; margin-top:11px; padding: 8px 0; border-radius: 5px; cursor: pointer;">
                        Remove 🗑️
                    </button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</div>
