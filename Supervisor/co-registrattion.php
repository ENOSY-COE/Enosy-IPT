<?php 
// home.php

session_start();

if(!isset($_SESSION['user_session_id'])) {
    header('location:index.php');
    exit();
}

header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 

include 'database_connection.php';

$message = '';
$success = '';

// Fetch company names for the dropdown
$companies = [];
$query = $connect->prepare("SELECT company_name FROM company");
$query->execute();
if ($query->rowCount() > 0) {
    $companies = $query->fetchAll(PDO::FETCH_ASSOC);
}

if(isset($_POST["signup_button"])) {
    $user_id = md5($_POST['user_fullname']);

    if(empty($_POST['user_fullname'])) {
        $message .= 'Fullname is required';
    } else if(empty($_POST['user_name'])) {
        $message .= 'UserName is required</li>';
    } else if(empty($_POST["user_email"])) {
        $message .= 'Email Address is required';
    } else if(!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) {
        $message .= 'Invalid Email Address';
    } else if(empty($_POST['user_password'])) {
        $message .= 'Password is required';
    } else if(empty($_POST['role_as'])) {
        $message .= 'Role_as is required';
    } else if(empty($_POST['company'])) {
        $message .= 'Company name is required';
    } else {
        $query = $connect->prepare("SELECT * FROM user_login WHERE user_name = :user_name");
        $query->bindParam(':user_name', $_POST['user_name'], PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $message .= 'Username is already taken. Try another';
        }

        $query = $connect->prepare("SELECT * FROM user_login WHERE user_email = :user_email");
        $query->bindParam(':user_email', $_POST['user_email'], PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $message .= 'Email is already taken. Try another>';
        } else {
            $insert_user = $connect->prepare("INSERT INTO user_login (user_fullname, user_name, company, user_email, user_password, role_as, user_session_id) 
                VALUES (:user_fullname, :user_name, :company, :user_email, :user_password, :role_as, :user_session_id)");
            $insert_user->bindParam(':user_fullname', $_POST['user_fullname'], PDO::PARAM_STR);
            $insert_user->bindParam(':user_name', $_POST['user_name'], PDO::PARAM_STR);
            $insert_user->bindParam(':company', $_POST['company'], PDO::PARAM_STR);
            $insert_user->bindParam(':user_email', $_POST['user_email'], PDO::PARAM_STR);
            $insert_user->bindParam(':user_password', password_hash($_POST['user_password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $insert_user->bindParam(':user_session_id', $user_id, PDO::PARAM_STR);
            $insert_user->bindParam(':role_as', $_POST['role_as'], PDO::PARAM_STR);
            $insert_user->execute();

            if ($insert_user) {
                $success .= "New user account created successfully.";
            } else {
                $message .= 'Failed to create new user account.</li>';
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
    <meta name="keywords" content="admin dashboard, html css dashboard, bootstrap 5 admin" />
    <meta name="description" content="Matrix Admin Lite Free Version is a powerful and clean admin dashboard template, inspired by Bootstrap Framework" />
    <meta name="robots" content="noindex,nofollow" />
    <title>TERA</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/TERA.jpeg" />
    <link href="../assets/libs/flot/css/float-chart.css" rel="stylesheet" />
    <link href="../dist/css/style.min.css" rel="stylesheet" />
</head>
<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <?php include('header.php'); ?>
        <?php include('sidebar.php'); ?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Form Basic</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
          <!-- ============================================================== -->
          <!-- Sales Cards  -->
          <!-- ============================================================== -->
          <div class="row">
            <div class="col-md-12">
                <?php 
                    if($message != '') {
                        echo '<div class="alert alert-danger">'.$message.'</div>';
                    }
                    if($success != '') {
                        echo '<div class="alert alert-success"><strong>Congratulations! </strong>'.$success.'</div>';
                    }
                ?>
              <div class="card">
                <form class="form-horizontal" method="POST">
                  <div class="card-body">
                    <h4 class="card-title">Personal Info</h4>
                    <div class="form-group row">
                      <label
                        for="fname"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Full Name</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          name="user_fullname"
                          placeholder="First Name Here"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="lname"
                        class="col-sm-3 text-end control-label col-form-label"
                        >User Name</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          name="user_name"
                          placeholder="User Name Here"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="lname"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Password</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="password"
                          class="form-control"
                          name="user_password"
                          placeholder="User Password Here"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="lname"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Personal Email Address</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="email"
                          class="form-control"
                          name="user_email"
                          placeholder="User email Here"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="lname"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Company Name</label
                      >
                      <div class="col-sm-9">
                        <select
                        class="select2 form-select shadow-none"
                        style="width: 100%; height: 36px" name="company" id="company_select" required>
                        <option value="">Select Company</option>
                        <?php foreach ($companies as $company): ?>
                            <option value="<?php echo htmlspecialchars($company['company_name']); ?>">
                                <?php echo htmlspecialchars($company['company_name']); ?>
                            </option>
                        <?php endforeach; ?>
                      </select>
                      </div>
                    </div>

                    <!-- <div class="form-group row">
                      <label
                        for="email1"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Department</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control" name="department"
                          placeholder="Department Name Here"
                        />
                      </div>
                    </div> -->
                    <div class="form-group row">
                      <label
                        for="lname"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Role As</label
                      >
                      <div class="col-sm-9">
                        <select
                        class="select2 form-select shadow-none"
                        style="width: 100%; height: 36px" name="role_as" required>
                            <option value="">Select role</option>
                            <option value="2">Company Manager</option>
                            <option value="3">Supervisor</option>
                            <option value="0">Student</option>
                      </select>
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" name="signup_button" class="btn btn-primary">
                        REGISTER
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              
            </div>
          </div>
          
        </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <script src="../dist/js/waves.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <script src="../dist/js/custom.min.js"></script>
    <script src="../assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="../dist/js/pages/mask/mask.init.js"></script>
    <script src="../assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="../assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="../assets/libs/jquery-asColor/dist/jquery-asColor.min.js"></script>
    <script src="../assets/libs/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="../assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js"></script>
    <script src="../assets/libs/jquery-minicolors/jquery.minicolors.min.js"></script>
    <script src="../assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="../assets/libs/quill/dist/quill.min.js"></script>
    <script>
    function check_session_id() {
        var session_id = "<?php echo $_SESSION['user_session_id']; ?>";
        fetch('check_login.php').then(function(response) {
            return response.json();
        }).then(function(responseData) {
            if(responseData.output == 'logout') {
                window.location.href = 'logout.php';
            }
        });
    }

    setInterval(function() {
        check_session_id();
    }, 10000);
    </script>
</body>
</html>
