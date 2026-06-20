<?php include 'includes/header.php'; ?>
<?php include 'db/conn.php'; ?>
<div style="background:#dddddd; padding: 10px; display: flex; justify-content: center; gap: 15px;">
  |<a href="type1.php" style="color: black; text-decoration: none; font-weight: bold;"> Engineering </a>|
  <a href="type2.php" style="color: black; text-decoration: none; font-weight: bold;"> Development </a>|
  <a href="type3.php" style="color: black; text-decoration: none; font-weight: bold;"> Management </a>|
  <a href="type4.php" style="color: black; text-decoration: none; font-weight: bold;"> Social </a>|
</div>

<!-- === Poster Slider Start === -->
<!-- Poster Slider Section -->
<div class="poster-slider" style="position: relative; width: 90%; max-width: 900px; margin: 20px auto; overflow: hidden; border-radius: 10px;">
  <div class="slides" id="posterSlides" style="display: flex; transition: transform 0.5s ease;">
    <?php
    $posterQuery = mysqli_query($conn, "SELECT * FROM posters");
    while ($poster = mysqli_fetch_assoc($posterQuery)) {
        echo '<img src="uploads/posters/' . $poster['filename'] . '" style="width:100%; flex-shrink: 0;">';
    }
    ?>
  </div>

  <!-- Arrows Inside -->
  <button onclick="nextSlide()" style="position:absolute; top:50%; left:45%; transform:translateY(-50%); background:none; border:none; font-size:26px; color:white; cursor:pointer;">❯</button>
  <button onclick="prevSlide()" style="position:absolute; top:50%; right:45%; transform:translateY(-50%); background:none; border:none; font-size:26px; color:white; cursor:pointer;">❮</button>
  <!-- Dots Inside -->
  <div id="dots" style="position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px;">
    <?php
    $posterCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM posters"));
    for ($i = 0; $i < $posterCount; $i++) {
        echo '<span class="dot" onclick="goToSlide('.$i.')" style="width: 10px; height: 10px; border-radius: 50%; background: white; opacity: 0.6; cursor: pointer;"></span>';
    }
    ?>
  </div>
</div>

<!-- Poster Script -->
<script>
let currentSlide = 0;
const slides = document.getElementById("posterSlides");
const dots = document.querySelectorAll(".dot");
const totalSlides = slides.children.length;

function updateSlider() {
    slides.style.transform = `translateX(-${currentSlide * 100}%)`;
    dots.forEach((dot, index) => {
        dot.style.opacity = index === currentSlide ? "1" : "0.4";
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateSlider();
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateSlider();
}

function goToSlide(index) {
    currentSlide = index;
    updateSlider();
}

setInterval(nextSlide, 4000);
updateSlider();
</script>

<!-- === Poster Slider End === -->


<form action="search.php" method="get" style="text-align:center; margin-top: 20px;">
  <input type="text" name="q" placeholder="Search all courses...                                🔍 " 
         style="padding: 8px; width: 280px; border-radius: 20px; border: 1px solid #ccc;">
</form>

<h2 style="text-align:center; margin-top: 40px;">Top Rated Courses</h2>
<script>
function clearSearch() {
  document.getElementById('searchInput').value = '';
}

// Redirect as user types
document.getElementById('searchInput').addEventListener('input', function () {
  const query = this.value.trim();
  if (query.length >= 2) {
    window.location.href = 'search.php?q=' + encodeURIComponent(query);
  }
});
</script>


</div>

<script src="js/search.js"></script>


<div class="course-list">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM courses ORDER BY rating DESC, total_ratings DESC LIMIT 4");
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="course-card">';
        echo '<img src="uploads/thumbnails/' . $row['thumbnail'] . '" alt="' . $row['name'] . '">';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p style="margin: 5px 0;">⭐ ' . number_format($row['rating'], 1) . ' (' . $row['total_ratings'] . ' ratings)</p>';
        echo '<a href="course.php?id=' . $row['id'] . '">View Course</a>';
        echo '</div>';
    }
    ?>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
