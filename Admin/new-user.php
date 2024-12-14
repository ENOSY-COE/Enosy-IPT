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
            $insert_user = $connect->prepare("INSERT INTO user_login (user_fullname, user_name, user_email, user_password, role_as ,user_session_id) 
                VALUES (:user_fullname, :user_name, :user_email, :user_password, :role_as ,:user_session_id)");
            $insert_user->bindParam(':user_fullname',$_POST['user_fullname'],PDO::PARAM_STR);
            $insert_user->bindParam(':user_name',$_POST['user_name'],PDO::PARAM_STR);
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

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="bootstrap.min.css" rel="stylesheet">

        <title>IPT System</title>
    </head>
    <body>

        <div class="container">
            <h1 class="mt-5 mb-5 text-center text-primary">INDUSTRIAL PRACTICAL TRAINING SYSTEM</h1>
        
            <p><a href="logout.php">Logout</a> | <a href="new-user.php">Add New User</a></p>


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
                                    <label class="form-label">Email address</label>
                                    <input type="text" name="user_email" class="form-control" />
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

