<!DOCTYPE html>
<html dir="ltr" lang="en">
<?php
include 'database_connection.php';

session_start();
$db = mysqli_connect("localhost", "root","", "testing"); // connecting 

$page_title = " TERA | Update Users";
if(isset($_SESSION["user_id"]) && isset($_SESSION["user_name"]) && isset($_SESSION["user_name"]))
{

if(isset($_POST['submit'] ))
{
    if(empty($_POST['user_name']) ||
   	    empty($_POST['user_fullname'])|| 
		empty($_POST['user_email']) ||  
		empty($_POST['user_password'])||
		empty($_POST['company']))
		{
			$error = '<div class="alert alert-danger alert-dismissible fade show">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>All fields Required!</strong>
															</div>';
		}
	else
	{
		

	
	
    if(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) // Validate email address
    {
       	$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>invalid email!</strong>
															</div>';
    }
	
	elseif(strlen($_POST['user_name']) < 10)
	{
		$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>invalid phone!</strong>
															</div>';
	}
	
	else{
       
	
	$mql = "update user_login set user_name='$_POST[uname]', user_fullname='$_POST[fname]', l_name='$_POST[lname]',user_email='$_POST[email]',company='$_POST[company]' where user_id='$_GET[user_upd]' ";
	mysqli_query($db, $mql);
			$success = 	'<div class="alert alert-success alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>User Updated!</strong></div>';
	
    }
	}

}

?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="logo/agriculture_farming.ico" type="image/x-icon">
    <title><?php echo $page_title;?></title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header">
    <div id="main-wrapper">
 
         <?php include("header.php");?>
      
        <?php include("sidebar.php");?>
   
        <div class="page-wrapper" style="height:1200px;">
       
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Administrator Dashboard</h3> </div>
               
            </div>
         
            <div class="container-fluid">
            
                     <div class="row">
                   
                   
					
					 <div class="container-fluid">
              
                  
									
									<?php  
									        echo $error;
									        echo $success; 
											
											
											
											?>
									
									
								
								
					    <div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Update Users</h4>
                            </div>
                            <div class="card-body">
							  <?php $ssql ="select * from user_login where user_id='$_GET[user_id]'";
													$res=mysqli_query($db, $ssql); 
													$newrow=mysqli_fetch_array($res);?>
                                <form action='update_user.php' method='post'  >
                                    <div class="form-body">
                                      
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Username</label>
                                                    <input type="text" name="uname" class="form-control" value="<?php  echo $newrow['user_name']; ?>" placeholder="username">
                                                   </div>
                                            </div>
                                     
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">full name</label>
                                                    <input type="text" name="fname" class="form-control form-control-danger"  value="<?php  echo $newrow['user_fullname'];  ?>" placeholder="jon">
                                                    </div>
                                            </div>
                                      
                                        </div>
                                    
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">password </label>
                                                    <input type="text" name="lname" class="form-control" placeholder="doe"  value="<?php  echo $newrow['user_password']; ?>">
                                                   </div>
                                            </div>
                                     
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Email</label>
                                                    <input type="text" name="email" class="form-control form-control-danger"  value="<?php  echo $newrow['user_email'];  ?>" placeholder="example@gmail.com">
                                                    </div>
                                            </div>
                                        
                                        </div>
                                   
										 <div class="row">
                                        
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">company name</label>
                                                    <input type="text" name="text" class="form-control form-control-danger"   value="<?php  echo $newrow['company'];  ?>" placeholder="company name">
                                                    </div>
                                                </div>
                                            </div>
                                 
                                            
                                      
                                        
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="submit" name="submit" class="btn btn-primary" value="Save"> 
                                        <a href="all_users.php" class="btn btn-inverse">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
					
					
					
					
					
					
					
					
					
					
					
					
                </div>
       
            </div>
      
            <?php include("footer.php");?>
        
        </div>
      
    </div>
   
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>

</body>

</html>
<?php
} else echo 'error';


?>