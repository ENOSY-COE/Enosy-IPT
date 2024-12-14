<?php
include 'database_connection.php';
error_reporting(0);

// Initialize variables to store form data
$job_title = $job_description = $job_location = $company_id = $job_type = $salary = $date_posted = $image_path = '';
$success_message = $error_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $job_location = $_POST['job_location'];
    $company_id = $_POST['company_id'];
    $job_type = $_POST['job_type'];
    $salary = $_POST['department'];
    $date_posted = $_POST['date_posted'];

    // Handle file upload
    if (isset($_FILES['job_image']) && $_FILES['job_image']['error'] == 0) {
        $file_name = $_FILES['job_image']['name'];
        $file_tmp = $_FILES['job_image']['tmp_name'];
        $file_size = $_FILES['job_image']['size'];
        $file_error = $_FILES['job_image']['error'];
        $file_type = $_FILES['job_image']['type'];

        $file_ext = strtolower(end(explode('.', $file_name)));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($file_ext, $allowed_ext)) {
            if ($file_size <= 2097152) { // Limit file size to 2MB
                $new_file_name = uniqid('', true) . '.' . $file_ext;
                $file_destination = 'uploads/' . $new_file_name;

                if (move_uploaded_file($file_tmp, $file_destination)) {
                    $image_path = $file_destination;
                } else {
                    $error_message = "Failed to upload image.";
                }
            } else {
                $error_message = "File size must be less than 2MB.";
            }
        } else {
            $error_message = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }

    // Insert job posting into the database
    $query = "INSERT INTO job (job_title, job_description, job_location, company_id, job_type, department, date_posted, image_path) 
              VALUES (:job_title, :job_description, :job_location, :company_id, :job_type, :department, :date_posted, :image_path)";
    
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':job_title', $job_title);
    $stmt->bindParam(':job_description', $job_description);
    $stmt->bindParam(':job_location', $job_location);
    $stmt->bindParam(':company_id', $company_id);
    $stmt->bindParam(':job_type', $job_type);
    $stmt->bindParam(':department', $salary);
    $stmt->bindParam(':date_posted', $date_posted);
    $stmt->bindParam(':image_path', $image_path);

    if ($stmt->execute()) {
        $success_message = "Job posted successfully!";
    } else {
        $error_message = "Failed to post job.";
    }
}

// Fetch company data for the dropdown
$company_data = [];
$query = "SELECT co_id, company_name FROM company";
$stmt = $connect->prepare($query);
$stmt->execute();
$company_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Job Posting Form</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/TERA.jpeg" />
    <link href="../assets/libs/flot/css/float-chart.css" rel="stylesheet" />
    <link href="../dist/css/style.min.css" rel="stylesheet" />
</head>

<body>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        
        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Job Posting Form</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($success_message): ?>
                                <div class="alert alert-success">
                                    <?php echo $success_message; ?>
                                </div>
                            <?php elseif ($error_message): ?>
                                <div class="alert alert-danger">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>
                            <form action="post_job.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="job_title">Job Title</label>
                                    <input type="text" class="form-control" id="job_title" name="job_title" value="<?php echo htmlspecialchars($job_title); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="job_description">Job Description</label>
                                    <textarea class="form-control" id="job_description" name="job_description" rows="4" required><?php echo htmlspecialchars($job_description); ?></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="job_location">Location</label>
                                    <input type="text" class="form-control" id="job_location" name="job_location" value="<?php echo htmlspecialchars($job_location); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="company_id">Company</label>
                                    <select class="form-control" id="company_id" name="company_id" required>
                                        <?php foreach ($company_data as $company): ?>
                                            <option value="<?php echo $company['co_id']; ?>" <?php echo ($company['co_id'] == $company_id) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($company['company_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="job_type">Job Type</label>
                                    <input type="text" class="form-control" id="job_type" name="job_type" value="<?php echo htmlspecialchars($job_type); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="salary">Department</label>
                                    <input type="text" class="form-control" id="department" name="department" value="<?php echo htmlspecialchars($salary); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="date_posted">Date Posted</label>
                                    <input type="date" class="form-control" id="date_posted" name="date_posted" value="<?php echo htmlspecialchars($date_posted); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="job_image">Image</label>
                                    <input type="file" class="form-control" id="job_image" name="job_image" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary">Post Job</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <script src="../dist/js/waves.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <script src="../dist/js/custom.min.js"></script>
</body>
</html>
