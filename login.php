
<?php 

//index.php

include 'database_connection.php';

$message = '';

if(isset($_POST["login_button"]))
{
    $formdata = array();

    if(empty($_POST["user_email"]))
    {
        $message .= '<li>Email Address is required</li>';
    }
    else
    {
        if(!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL))
        {
            $message .= '<li>Invalid Email Address</li>';
        }
        else
        {
            $formdata['user_email'] = $_POST['user_email'];
        }
    }

    if(empty($_POST['user_password']))
    {
        $message .= '<li>Password is required</li>';
    }
    else
    {
        $formdata['user_password'] = $_POST['user_password'];
    }

    if($message == '')
    {
        $data = array(
            ':user_email'       =>  $formdata['user_email']
        );

        $query = "
        SELECT * FROM user_login 
        WHERE user_email = :user_email 
        ";

        $statement = $connect->prepare($query);

        $statement->execute($data);

        if($statement->rowCount() > 0)
        {
            foreach($statement->fetchAll() as $row)
            {
                if(password_hash($row['user_password'], PASSWORD_DEFAULT))
                {
                    session_start();

                    if ($row['role_as'] == '1') {
                        session_regenerate_id();

                        $user_session_id = session_id();

                        $query = "UPDATE user_login SET user_session_id = '".$user_session_id."' 
                        WHERE user_id = '".$row['user_id']."'
                        ";

                        $connect->query($query);

                        $_SESSION['user_id'] = $row['user_id'];

                        $_SESSION['user_session_id'] = $user_session_id;

                        header('location:Admin/index.php');
                    }else if ($row['role_as'] == '2') {
                        session_regenerate_id();

                        $user_session_id = session_id();

                        $query = "UPDATE user_login SET user_session_id = '".$user_session_id."' 
                        WHERE user_id = '".$row['user_id']."'
                        ";

                        $connect->query($query);

                        $_SESSION['user_id'] = $row['user_id'];

                        $_SESSION['user_session_id'] = $user_session_id;

                        header('location:Manager/index.php');
                    }else if ($row['role_as'] == '3') {
                        session_regenerate_id();

                        $user_session_id = session_id();

                        $query = "UPDATE user_login SET user_session_id = '".$user_session_id."' 
                        WHERE user_id = '".$row['user_id']."'
                        ";

                        $connect->query($query);

                        $_SESSION['user_id'] = $row['user_id'];

                        $_SESSION['user_session_id'] = $user_session_id;

                        header('location:Supervisor/index.php');
                    }else if ($row['role_as'] == '0') {
                        session_regenerate_id();

                        $user_session_id = session_id();

                        $query = "UPDATE user_login SET user_session_id = '".$user_session_id."' 
                        WHERE user_id = '".$row['user_id']."'
                        ";

                        $connect->query($query);

                        $_SESSION['user_id'] = $row['user_id'];

                        $_SESSION['user_session_id'] = $user_session_id;

                        header('location:Student/indexx.php');
                    }
                    else{
                         $message = '<li>Incorrect Login</li>';
                    }

                    
                }
                else
                {
                    $message = '<li>Wrong Password</li>';
                }
            }
        }
        else
        {
            $message = '<li>Wrong Email Address</li>';
        }
    }
}

?>

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="bootstrap.min.css" rel="stylesheet">

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
    <link rel="stylesheet"  type="text/css" href="../assets/extra-libs/multicheck/multicheck.css" />
    <link  href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   
        <title>TERA </title>
        <style>
             a:link, a:visited {
            background-color: light-blue;
            padding: 14px 25px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            }

            a:hover, a:active {
            background-color: blue;
            }
            .hm{
                border-radius: 50%;
            }
        </style>

    </head>
    <body>

        <div class="container">
            <h1 class="mt-5 mb-5 text-center text-primary">IPTS- LOGIN</h1>
            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                <div class="col-md-6">
                    <?php 
                    if($message != '')
                    {
                        echo '<div class="alert alert-danger"><ul>'.$message.'</ul></div>';
                    }
                    ?>
                    <div class="card"><center>
                        <div class="card-header">LOGIN</div></center>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Email address</label>
                                    <input type="text" name="user_email" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="user_password" class="form-control" />
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <input type="submit" name="login_button" value="Login" class="btn btn-primary" />
                                   <div class="hm"> <a href="index.php" target="_blank">Home</a></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
    </body>
</html>













