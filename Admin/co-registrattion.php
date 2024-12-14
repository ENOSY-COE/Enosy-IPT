<?php 

//home.php

session_start();

if(!isset($_SESSION['user_session_id']))
{
    header('location:index.php');
    exit();
}




header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
?>
<?php
include 'database_connection.php';

    

$message = '';
$success = '';
if(isset($_POST["signup_button"]))
{

    
    $cha = "0123456789abcdefghijklmnopqrstuvwxyz";
    $user_id = md5($_POST['user_fullname']);

 
    if(empty($_POST['user_fullname']))
    {
        $message .= '<li>Fullname is required</li>';
    }
    else if(empty($_POST['user_name']))
    {
        $message .= '<li>UserName is required</li>';
    }

    else if(empty($_POST["user_email"]))
    {
        $message .= '<li>Email Address is required</li>';
    }
    else if(!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL))
        {
            $message .= '<li>Invalid Email Address</li>';
        }

    else if(empty($_POST['user_password']))
    {
        $message .= '<li>Password is required</li>';
    }

    else if(empty($_POST['role_as']))
    {
        $message .= '<li>Role_as is required</li>';
    }
    else if(empty($_POST['company']))
    {
        $message .= '<li>Company name is required</li>';
    }

    else{
        $query = $connect->prepare("SELECT * FROM user_login WHERE user_name=:user_name");
        $query->bindParam(':user_name',$_POST['user_name'],PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $message .= '<li>Username Is already Exist. Try Another</li>';
        }

        $query = $connect->prepare("SELECT * FROM user_login WHERE user_email=:user_email");
        $query->bindParam(':user_email', $_POST['user_email'],PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $message .= '<li>Email Is already Exist. Try Another</li>';
        }

        else{
            $insert_user = $connect->prepare("INSERT INTO user_login (user_fullname, user_name,company, user_email, user_password, role_as ,user_session_id) 
                VALUES (:user_fullname, :user_name, :company, :user_email, :user_password, :role_as ,:user_session_id)");
            $insert_user->bindParam(':user_fullname',$_POST['user_fullname'],PDO::PARAM_STR);
            $insert_user->bindParam(':user_name',$_POST['user_name'],PDO::PARAM_STR);
            $insert_user->bindParam(':company',$_POST['company'],PDO::PARAM_STR);
            $insert_user->bindParam(':user_email',$_POST['user_email'],PDO::PARAM_STR);
            $insert_user->bindParam(':user_password',$_POST['user_password'],PDO::PARAM_STR);
            $insert_user->bindParam(':user_session_id',$user_id,PDO::PARAM_STR);
            $insert_user->bindParam(':role_as',$_POST['role_as'],PDO::PARAM_STR);
            $insert_user->execute();

            if ($insert_user) {
                $success .= "New User Account Created successfully";
            }
            else{
                $message .= '<li>Failed to create new user account</li>';
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
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="keywords"
      content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template"
    />
    <meta
      name="description"
      content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework"
    />
    <meta name="robots" content="noindex,nofollow" />
    <title>TERA</title>
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="../assets/images/TERA.jpeg"
    />
    <!-- Custom CSS -->
    <link href="../assets/libs/flot/css/float-chart.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   
  </head>

  <body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
      <?php include('header.php'); ?>
      <!-- ============================================================== -->
      <!-- End Topbar header -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <?php include('sidebar.php'); ?>
      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper  -->
      <!-- ============================================================== -->
      <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Form Basic</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Library
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container">
          
            <h3 class="mt-5 mb-5 text-center text-primary">Add New User</h3>
            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                <div class="col-md-6">
                    <?php 
                    if($message != '' )
                    {
                        echo '<div class="alert alert-danger"><ul>'.$message.'</ul></div>';
                    }
                    if($success != '' )
                    {
                        echo '<div class="alert alert-success"><ul><strong>Congratulation! </strong>'.$success.'</ul></div>';
                    }
                    ?>
                    <div class="card">
                        <div class="card-header">Add New User</div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">FullName</label>
                                    <input type="text" name="user_fullname" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">UserName</label>
                                    <input type="text" name="user_name" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Personal Email address</label>
                                    <input type="text" name="user_email" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" name="company" class="form-control" required/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="user_password" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">User Role</label>
                                    <select name="role_as" class="form-control" >
                                        <option>Select Here</option>
                                        <option value="1">Administrator</option>
                                        <option value="2">Manager</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <input type="submit" name="signup_button" value="create account" class="btn btn-primary" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <?php include ('footer.php'); ?>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!-- This Page JS -->
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
   
  </body>
</html>
<script>

function check_session_id()
{
    var session_id = "<?php echo $_SESSION['user_session_id']; ?>";

    fetch('check_login.php').then(function(response){

        return response.json();

    }).then(function(responseData){

        if(responseData.output == 'logout')
        {
            window.location.href = 'logout.php';
        }

    });
}

setInterval(function(){

    check_session_id();
    
}, 10000);

</script>