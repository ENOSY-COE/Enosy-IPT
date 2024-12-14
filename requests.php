<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>TERATECH</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/TERA.jpeg" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
<style>
  .sitename{
    border-style: solid;
    font-size: 20px;
    border-color: red;
  }
</style>

<body class="projects-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="index.html" class="logo d-flex align-items-center">
         
         <img src="assets/img/TERA.jpeg" alt="">
      
         <h1 class="sitename">TERA-IPTS </h1>
         
       </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Projects</a></li>
          <li><a href="requests.php">IPT POSITION</a></li>
          
          <li><a href="#">Contact</a></li>
          <li class="dropdown"><a href="#"><span>IPT Request</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
           
           <li class="nav-item"> <a class="nav-link active" href="login.php">IPTS-Login <span class="sr-only"></span></a> </li>
           </ul>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/page-title-bg.jpg);">
      <div class="container position-relative">
        <h1>IPT POSITION</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Positions Request</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Projects Section -->
    <section id="projects" class="projects section">

      <div class="container">
      <?php
require 'database_connection.php'; // Include your PDO database connection

try {
    // Prepare the SQL query to fetch job details
    $stmt = $connect->prepare("SELECT * FROM job");
    
    // Execute the query
    $stmt->execute();
    
    // Fetch all the results
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any jobs
    if ($jobs) {
        echo "<div class='container mt-5'>";
        echo "<div class='row'>";
        foreach ($jobs as $job) {
            echo "<div class='col-md-4 mb-4'>";
            echo "<div class='card h-100'>";
            echo "<img src='Manager/uploads/" . htmlspecialchars($job['image_path']) . "' class='card-img-top' alt='Job Image'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . htmlspecialchars($job['job_title']) . "</h5>";
            echo "<p class='card-text'><strong>Description:</strong> " . htmlspecialchars($job['job_description']) . "</p>";
            echo "<p class='card-text'><strong>Location:</strong> " . htmlspecialchars($job['job_location']) . "</p>";
            echo "<p class='card-text'><strong>Job Type:</strong> " . htmlspecialchars($job['job_type']) . "</p>";
            echo "<p class='card-text'><strong>Department:</strong> " . htmlspecialchars($job['department']) . "</p>";
            echo "<p class='card-text'><strong>Date Posted:</strong> " . htmlspecialchars($job['date_posted']) . "</p>";
            echo "</div>";
            echo "<div class='card-footer text-center'>";
            echo "<form method='POST' action='request_job.php'>";
            echo "<input type='hidden' name='job_id' value='" . $job['job_id'] . "'>";
            echo "<button type='submit' class='btn btn-primary'><a href='request_job.php?job_id=".$job['job_id']."'>Request Job</a></button>";
            echo "</form>";
            echo "</div>";
            echo "</div>"; // Close card
            echo "</div>"; // Close col-md-4
        }
        echo "</div>"; // Close row
        echo "</div>"; // Close container
    } else {
        echo "<div class='container mt-5'>";
        echo "<p class='text-center'>No jobs available.</p>";
        echo "</div>";
    }
} catch (PDOException $e) {
    // Handle any errors
    echo "<div class='container mt-5'>";
    echo "<p class='text-center text-danger'>Error: " . $e->getMessage() . "</p>";
    echo "</div>";
}
?>

      

       </div>
    </section><!-- /Projects Section -->

  </main>

  <footer>
    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="sitenam">teratech</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
      
        Designed by <a href="#">teratech.co.tz</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>



  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>



</body>

</html>