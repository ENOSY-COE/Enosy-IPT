<?php
include 'database_connection.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch company names for the logged-in user
$companies = [];
$query = "SELECT company_name FROM company WHERE user_id = :user_id";
$stmt = $connect->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for adding a department
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_name = $_POST['company_name'] ?? '';
    $department_name = $_POST['department_name'] ?? '';
    $supervisor = $_POST['supervisor'] ?? '';
    
    if (!empty($company_name) && !empty($department_name)) {
        // Check if department already exists
        $check_query = "SELECT COUNT(*) FROM department WHERE company_name = :company_name AND department_name = :department_name";
        $check_stmt = $connect->prepare($check_query);
        $check_stmt->bindParam(':company_name', $company_name);
        $check_stmt->bindParam(':department_name', $department_name);
        $check_stmt->execute();
        $exists = $check_stmt->fetchColumn();

        if ($exists) {
            $error_message = "Department already exists for this company.";
        } else {
            $insert_query = "INSERT INTO department (company_name, department_name, supervisor) VALUES (:company_name, :department_name, :supervisor)";
            $insert_stmt = $connect->prepare($insert_query);
            $insert_stmt->bindParam(':company_name', $company_name);
            $insert_stmt->bindParam(':department_name', $department_name);
            $insert_stmt->bindParam(':supervisor', $supervisor);
            
            if ($insert_stmt->execute()) {
                $success_message = "Department successfully added.";
                // Optionally redirect to prevent form resubmission
                // header('Location: add_department.php');
                // exit;
            } else {
                $error_message = "Error adding department.";
            }
        }
    } else {
        $error_message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Department</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/TERA.jpeg" />
    <link href="../assets/libs/flot/css/float-chart.css" rel="stylesheet" />
    <link href="../dist/css/style.min.css" rel="stylesheet" />
</head>

<body>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        
        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>

        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Add Department</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="view_departments.php">Departments</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($success_message)): ?>
                                    <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
                                <?php endif; ?>
                                <?php if (isset($error_message)): ?>
                                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                                <?php endif; ?>
                                <form action="add_department.php" method="POST">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <select class="form-control" id="company_name" name="company_name" required>
                                            <option value="">Select Company</option>
                                            <?php foreach ($companies as $company): ?>
                                                <option value="<?php echo htmlspecialchars($company['company_name']); ?>">
                                                    <?php echo htmlspecialchars($company['company_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="department_name">Department Name</label>
                                        <input type="text" class="form-control" id="department_name" name="department_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="supervisor">Supervosor Name / Engineer</label>
                                        <input type="text" class="form-control" id="supervisor" name="supervisor" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Department</button>
                                    <a href="view_departments.php" class="btn btn-secondary">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('footer.php'); ?>
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
