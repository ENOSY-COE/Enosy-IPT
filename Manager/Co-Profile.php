<?php
include 'database_connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $company_name = $_POST['company_name'];
    $company_email = $_POST['company_email'];
    $company_phone = $_POST['company_phone'];
    $company_address = $_POST['company_address'];
    $company_location = $_POST['company_location'];
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];

    // Prepare the SQL query to insert data into the 'company' table
    $query = "INSERT INTO company (company_name, company_email, company_phone, company_address, company_location, user_id, user_name)
              VALUES (:company_name, :company_email, :company_phone, :company_address, :company_location, :user_id, :user_name)";

    // Prepare the statement
    $stmt = $connect->prepare($query);

    // Bind parameters
    $stmt->bindParam(':company_name', $company_name);
    $stmt->bindParam(':company_email', $company_email);
    $stmt->bindParam(':company_phone', $company_phone);
    $stmt->bindParam(':company_address', $company_address);
    $stmt->bindParam(':company_location', $company_location);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':user_name', $user_name);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<p class='text-success'>Company registered successfully.</p>";
    } else {
        echo "<p class='text-danger'>Failed to register company.</p>";
    }
}
// Start the session
session_start();

// Fetch the logged-in user's ID (assuming you store the user_id in session)
$logged_in_user_id = $_SESSION['user_id'];

// Fetch user_name and user_id for the logged-in user from user_login table
$query = "SELECT user_id, user_name FROM user_login WHERE user_id = :user_id";
$statement = $connect->prepare($query);
$statement->execute(['user_id' => $logged_in_user_id]);
$user_data = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Company Registration</title>
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
                        <h4 class="page-title">Company Registration</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Register</li>
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
                                <form action="Co-Profile.php" method="POST">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter company name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_email">Company Email</label>
                                        <input type="email" class="form-control" id="company_email" name="company_email" placeholder="Enter company email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_phone">Company Phone</label>
                                        <input type="tel" class="form-control" id="company_phone" name="company_phone" placeholder="Enter company phone" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_address">Company Address</label>
                                        <input type="text" class="form-control" id="company_address" name="company_address" placeholder="Enter company address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_location">Company Location</label>
                                        <input type="text" class="form-control" id="company_location" name="company_location" placeholder="Enter company location" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_id">Registration Number</label>
                                        <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $user_data['user_id']; ?>" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_name">User Name</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $user_data['user_name']; ?>" readonly required>
                                    </div>
                                    <div class="form-group text-center mt-4">
                                        <button type="submit" class="btn btn-primary">Register Company</button>
                                    </div>
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
