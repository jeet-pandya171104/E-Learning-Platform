<?php
include 'includes/header.php';
include 'db/conn.php';

// Delete Poster
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = mysqli_query($conn, "SELECT * FROM posters WHERE id = $id");
    $poster = mysqli_fetch_assoc($result);

    if ($poster) {
        unlink('uploads/posters/' . $poster['filename']);
        mysqli_query($conn, "DELETE FROM posters WHERE id = $id");
        echo "<script>alert('Poster deleted successfully!');</script>";
    }
}

// Add Poster
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['poster'])) {
    $file = $_FILES['poster'];
    $name = basename($file['name']);
    $tmp = $file['tmp_name'];
    $path = 'uploads/posters/' . $name;

    if (move_uploaded_file($tmp, $path)) {
        mysqli_query($conn, "INSERT INTO posters (filename) VALUES ('$name')");
        echo "<script>alert('Poster added successfully!');</script>";
    } else {
        echo "<script>alert('Upload failed.');</script>";
    }
}
?>

<h2 style="text-align:center; margin-top: 30px;">Manage Homepage Posters</h2>

<!-- Poster Upload Form -->
<!-- Poster Upload Form Centered -->
<form method="POST" enctype="multipart/form-data" 
      style="width: 50%; margin: 30px auto; background: #f9f9f9; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    
    <label style="display: block; margin-bottom: 10px; font-weight: bold;">Upload Poster Image:</label>
    <input type="file" name="poster" required style="margin-bottom: 15px;">
    
    <br>
    <button type="submit" 
            style="padding: 8px 16px; background-color: #3498db; color: white; border: none; border-radius: 6px; cursor: pointer;">
        Upload Poster
    </button>
</form>


<!-- Existing Posters List -->
<div class="course-list">
<?php
$result = mysqli_query($conn, "SELECT * FROM posters ORDER BY id DESC");
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="course-card" style="width:300px;">';
    echo '<img src="uploads/posters/' . $row['filename'] . '" style="width:100%; height:auto;">';
    echo '<a href="?delete=' . $row['id'] . '" style="display:block; margin-top:10px; color:red;">Delete Poster</a>';
    echo '</div>';
}
?>
</div>

<?php include 'includes/footer.php'; ?>
