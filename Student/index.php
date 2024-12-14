<?php 

//home.php

session_start();

if(!isset($_SESSION['user_session_id']))
{
    header('location:index.php');
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
            
            <h2>Welcome Student</h2>
            <p><a href="logout.php">Logout</a></p>
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

