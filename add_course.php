<?php
include 'includes/header.php';
include 'db/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape special characters to prevent SQL errors
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $prerequisites = mysqli_real_escape_string($conn, $_POST['prerequisites']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    // Handle uploaded thumbnail
    $thumbnail = $_FILES['thumbnail']['name'];
    $thumb_tmp = $_FILES['thumbnail']['tmp_name'];
    move_uploaded_file($thumb_tmp, "uploads/thumbnails/" . $thumbnail);

    // Handle uploaded video
    $video = $_FILES['video']['name'];
    $video_tmp = $_FILES['video']['tmp_name'];
    move_uploaded_file($video_tmp, "uploads/videos/" . $video);

    // Insert into DB
    $insert = "INSERT INTO courses (name, description, prerequisites, duration, thumbnail, video, type)
               VALUES ('$name', '$description', '$prerequisites', '$duration', '$thumbnail', '$video', '$type')";

    if (mysqli_query($conn, $insert)) {
        echo "<script>alert('Course added successfully!'); window.location.href='admin_panel.php';</script>";
    } else {
        echo "<p style='color:red; text-align:center;'>Failed to add course.</p>";
    }
}
?>

<!-- Course Add Form -->
<h2 style="text-align:center; margin-top: 20px;">Add New Course</h2>
<form method="POST" enctype="multipart/form-data" style="max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 10px;">
    <input type="text" name="name" placeholder="Course Name" required>
    <textarea name="description" placeholder="Course Description" required></textarea>
    <textarea name="prerequisites" placeholder="Prerequisites" required></textarea>
    <input type="text" name="duration" placeholder="Duration (e.g., 3h 30m)" required>

    <label>Course Type:</label>
    <select name="type" required>
        <option value="type-1">Engineering</option>
        <option value="type-2">Development</option>
        <option value="type-3">Management</option>
        <option value="type-4">Social</option>
    </select>

    <label>Thumbnail Image:</label>
    <input type="file" name="thumbnail" accept="image/*" required>

    <label>Course Video:</label>
    <input type="file" name="video" accept="video/*" required>

    <button type="submit">Add Course</button>
</form>
