<?php
include 'database_connection.php';

// Get company ID from the URL
$company_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch company data for the given ID
$company = [];
if ($company_id > 0) {
    $query = "SELECT * FROM company WHERE co_id = :company_id";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
    $stmt->execute();
    $company = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission for updating company data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_name = $_POST['company_name'] ?? '';
    $company_email = $_POST['company_email'] ?? '';
    $company_phone = $_POST['company_phone'] ?? '';
    $company_address = $_POST['company_address'] ?? '';
    $company_location = $_POST['company_location'] ?? '';

    $update_query = "UPDATE company SET 
        company_name = :company_name,
        company_email = :company_email,
        company_phone = :company_phone,
        company_address = :company_address,
        company_location = :company_location
        WHERE co_id = :company_id";
        
    $update_stmt = $connect->prepare($update_query);
    $update_stmt->bindParam(':company_name', $company_name);
    $update_stmt->bindParam(':company_email', $company_email);
    $update_stmt->bindParam(':company_phone', $company_phone);
    $update_stmt->bindParam(':company_address', $company_address);
    $update_stmt->bindParam(':company_location', $company_location);
    $update_stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
    
    if ($update_stmt->execute()) {
        header('Location: view_companies.php');
        exit;
    } else {
        $error_message = "Error updating company details.";
    }
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Company</title>
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
                        <h4 class="page-title">Edit Company</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="view_companies.php">Companies</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                                <?php if (isset($error_message)): ?>
                                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                                <?php endif; ?>
                                <form action="edit_company.php?id=<?php echo $company_id; ?>" method="POST">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo htmlspecialchars($company['company_name'] ?? ''); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_email">Company Email</label>
                                        <input type="email" class="form-control" id="company_email" name="company_email" value="<?php echo htmlspecialchars($company['company_email'] ?? ''); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_phone">Company Phone</label>
                                        <input type="tel" class="form-control" id="company_phone" name="company_phone" value="<?php echo htmlspecialchars($company['company_phone'] ?? ''); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_address">Company Address</label>
                                        <input type="text" class="form-control" id="company_address" name="company_address" value="<?php echo htmlspecialchars($company['company_address'] ?? ''); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_location">Company Location</label>
                                        <input type="text" class="form-control" id="company_location" name="company_location" value="<?php echo htmlspecialchars($company['company_location'] ?? ''); ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="companies.php" class="btn btn-secondary">Cancel</a>
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
