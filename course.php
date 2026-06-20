<?php include 'includes/header.php'; ?>
<?php
include 'db/conn.php';

$course_id = $_GET['id'] ?? 0;
$query = "SELECT * FROM courses WHERE id = $course_id";
$result = mysqli_query($conn, $query);
$course = mysqli_fetch_assoc($result);

if (!$course) {
    echo "<h2 style='text-align:center'>Course not found</h2>";
    exit;
}

$avg_rating = $course['rating'];
$total_ratings = $course['total_ratings'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['rating'])) {
    $new_rating = (int)$_POST['rating'];
    $new_total = $total_ratings + 1;
    $new_avg = (($avg_rating * $total_ratings) + $new_rating) / $new_total;

    $update = "UPDATE courses SET rating = $new_avg, total_ratings = $new_total WHERE id = $course_id";
    mysqli_query($conn, $update);
    $avg_rating = $new_avg;
    $total_ratings = $new_total;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['favourite']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $check = mysqli_query($conn, "SELECT * FROM favorites WHERE user_id=$user_id AND course_id=$course_id");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO favorites (user_id, course_id) VALUES ($user_id, $course_id)");
    }
}
?>

<div class="course-detail">
    <h2><?= $course['name'] ?></h2>

    <video controls>
        <source src="uploads/videos/<?= $course['video'] ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
<!-- Accordion-style Description -->
<div style="width: 100%; margin-top: 20px;">
  <div onclick="toggleDescription()" 
       style="background-color: #eee; padding: 12px 20px; cursor: pointer; font-weight: bold; border-radius: 6px; border: 1px solid #ccc;">
    Description
  </div>

  <div id="descriptionContent" style="max-height: 0; overflow: hidden; transition: max-height 0.4s ease; background-color: #f9f9f9; padding: 0 20px; border: 1px solid #ddd; border-top: none; border-radius: 0 0 6px 6px;">
    <p style="margin: 15px 0;"><?= nl2br($course['description']) ?></p>
  </div>
</div>
    <p><strong>Duration:</strong> <?= $course['duration'] ?></p>
    <p><strong>Prerequisites:</strong> <?= nl2br($course['prerequisites']) ?></p>

    



<div class="rating" style="margin-top: 20px;">
    <form method="POST" style="display: flex; align-items: center; gap: 20px; width:100%; flex-wrap: nowrap; justify-content: center;">
        
        <!-- Stars -->
        <div style="display: flex; gap: 5px;">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <button name="rating" value="<?= $i ?>" 
                        style="background: none; border: none; font-size: 28px; cursor: pointer;">
                    <span style="color: <?= ($i <= round($avg_rating)) ? '#f39c12' : '#ccc' ?>">★</span>
                </button>
            <?php endfor; ?>
        </div>

        <!-- Average -->
        <span style="font-size: 16px; width: 100%; text-align: center; color: #555;">
            Avg: <?= number_format($avg_rating, 1) ?> (<?= $total_ratings ?> ratings)
        </span>

        <!-- Favourite Button -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <button name="favourite" class="favorite"
                    style="padding: 6px 12px; background-color: #3498db; color: white; border: none; border-radius: 6px; cursor: pointer;">
                Add to Favourite 
            </button>
        <?php endif; ?>

    </form>
</div>



</div>
<script>
function toggleDescription() {
  const content = document.getElementById("descriptionContent");

  if (content.style.maxHeight && content.style.maxHeight !== "0px") {
    content.style.maxHeight = "0";
    content.style.paddingTop = "0";
    content.style.paddingBottom = "0";
  } else {
    content.style.maxHeight = content.scrollHeight + "px";
    content.style.paddingTop = "15px";
    content.style.paddingBottom = "15px";
  }
}
</script>
<?php include 'includes/footer.php'; ?>

</body>
</html>
