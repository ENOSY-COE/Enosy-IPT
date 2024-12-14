<?php
include 'database_connection.php';

// Initialize variables for messages
$success_message = $error_message = '';

// Fetch job postings from the database
$jobs = [];
$query = "SELECT job_id, job_title, job_description, job_location, company_id, job_type, department, date_posted, image_path FROM job";
$stmt = $connect->prepare($query);
$stmt->execute();
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>View Jobs</title>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Job Postings</h5>
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

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Description</th>
                                        <th>Location</th>
                                        <th>Company</th>
                                        <th>Type</th>
                                        <th>department</th>
                                        <th>Date Posted</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($jobs) > 0): ?>
                                        <?php foreach ($jobs as $job): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($job['job_title']); ?></td>
                                                <td><?php echo htmlspecialchars($job['job_description']); ?></td>
                                                <td><?php echo htmlspecialchars($job['job_location']); ?></td>
                                                <td>
                                                    <?php
                                                    // Fetch company name from the company table
                                                    $company_query = "SELECT company_name FROM company WHERE co_id = :company_id";
                                                    $company_stmt = $connect->prepare($company_query);
                                                    $company_stmt->bindParam(':company_id', $job['company_id']);
                                                    $company_stmt->execute();
                                                    $company = $company_stmt->fetch(PDO::FETCH_ASSOC);
                                                    echo htmlspecialchars($company['company_name']);
                                                    ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($job['job_type']); ?></td>
                                                <td><?php echo htmlspecialchars($job['department']); ?></td>
                                                <td><?php echo htmlspecialchars($job['date_posted']); ?></td>
                                                <td>
                                                    <?php if ($job['image_path']): ?>
                                                        <img src="<?php echo htmlspecialchars($job['image_path']); ?>" alt="Job Image" width="100">
                                                    <?php else: ?>
                                                        No Image
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No job postings found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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
