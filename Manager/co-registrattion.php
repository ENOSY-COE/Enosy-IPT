<?php
session_start();
if (!isset($_SESSION['user_session_id'])) {
    header('location:index.php');
    exit();
}

include 'database_connection.php';

$message = '';
$success = '';

// Fetch company names from the company table
$company_query = $connect->prepare("SELECT company_name FROM company");
$company_query->execute();
$companies = $company_query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["register_user_button"])) {
    $user_fullname = trim($_POST['user_fullname']);
    $user_name = trim($_POST['user_name']);
    $user_email = trim($_POST['user_email']);
    $company = trim($_POST['company']);
    $user_password = trim($_POST['user_password']);
    $role_as = trim($_POST['role_as']);
    $user_session_id = md5($user_name . time()); // Generate session ID based on username and timestamp

    // Validate inputs
    if (empty($user_fullname)) {
        $message .= '<li>Full Name is required</li>';
    }
    if (empty($user_name)) {
        $message .= '<li>Username is required</li>';
    }
    if (empty($user_email)) {
        $message .= '<li>Email Address is required</li>';
    }
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $message .= '<li>Invalid Email Address</li>';
    }
    if (empty($user_password)) {
        $message .= '<li>Password is required</li>';
    }
    if (empty($company)) {
        $message .= '<li>Company is required</li>';
    }

    if ($message == '') {
        // Check if username or email already exists
        $query = $connect->prepare("SELECT * FROM user_login WHERE user_name = :user_name OR user_email = :user_email");
        $query->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $query->bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() > 0) {
            $message .= '<li>Username or Email already exists. Try another.</li>';
        } else {
            // Insert user data
            $insert_user = $connect->prepare("INSERT INTO user_login (user_fullname, user_name, company, user_email, user_password, role_as, user_session_id) 
                VALUES (:user_fullname, :user_name, :company, :user_email, :user_password, :role_as, :user_session_id)");

            // Bind parameters
            $insert_user->bindParam(':user_fullname', $user_fullname, PDO::PARAM_STR);
            $insert_user->bindParam(':user_name', $user_name, PDO::PARAM_STR);
            $insert_user->bindParam(':company', $company, PDO::PARAM_STR);
            $insert_user->bindParam(':user_email', $user_email, PDO::PARAM_STR);
            $insert_user->bindParam(':user_password', $user_password, PDO::PARAM_STR); // No encryption
            $insert_user->bindParam(':role_as', $role_as, PDO::PARAM_STR);
            $insert_user->bindParam(':user_session_id', $user_session_id, PDO::PARAM_STR);

            $result = $insert_user->execute();

            if ($result) {
                $success .= 'User registered successfully!';
            } else {
                $message .= '<li>Failed to register user. Please try again.</li>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TERA</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/TERA.jpeg" />
    <link href="../assets/libs/flot/css/float-chart.css" rel="stylesheet" />
    <link href="../dist/css/style.min.css" rel="stylesheet" />
  </head>

  <body>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
      <?php include('header.php'); ?>
      <?php include('sidebar.php'); ?>
      <div class="page-wrapper">
        <div class="container">
          <h3 class="text-center mt-5">Register New User</h3>

          <?php
          if ($message != '') {
              echo '<div class="alert alert-danger"><ul>' . $message . '</ul></div>';
          }
          if ($success != '') {
              echo '<div class="alert alert-success">' . $success . '</div>';
          }
          ?>
          <form method="POST" action="">
              <div class="mb-3">
                  <label for="user_fullname" class="form-label">Full Name</label>
                  <input type="text" name="user_fullname" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label for="user_name" class="form-label">Username</label>
                  <input type="text" name="user_name" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label for="user_email" class="form-label">Email Address</label>
                  <input type="email" name="user_email" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label for="company" class="form-label">Company</label>
                  <select name="company" class="form-control" required>
                      <option value="">Select Company</option>
                      <?php foreach ($companies as $row): ?>
                          <option value="<?php echo $row['company_name']; ?>"><?php echo $row['company_name']; ?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
              <div class="mb-3">
                  <label for="user_password" class="form-label">Password</label>
                  <input type="password" name="user_password" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label for="role_as" class="form-label">Role</label>
                  <select name="role_as" class="form-control" required>
                      <option value=" ">Select Role</option>
                      <option value="2">Manager</option>
                      <option value="3">Supervisor</option>
                      <option value="0">Student</option>
                  </select>
              </div>
              <button type="submit" name="register_user_button" class="btn btn-primary">Register User</button>
          </form>
        </div>
      </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <script src="../dist/js/waves.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <script src="../dist/js/custom.min.js"></script>
  </body>
</html>
