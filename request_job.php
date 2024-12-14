<?php
error_reporting();

require 'database_connection.php'; // Include your PDO database connection


$message = '';
$success = '';
if (isset($_POST['submit'])) {
    // List of required fields
    $required_fields = ['first_name', 'last_name', 'phone', 'email', 'university_name', 'course', 'level', 'job_id'];


    // Retrieve POST variables and sanitize input
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $university_name = trim($_POST['university_name']);
    $course = trim($_POST['course']);
    $level = trim($_POST['level']);
    $job_id = trim($_POST['job_id']); // Get job_id from hidden field

    // Check if the job_id exists in the job table

    if (empty($first_name)) {
       $message .= "FirstName Is required";
    }
    elseif (empty($last_name)) {
         $message .= "LastName Is required";
    }
    elseif (empty($phone)) {
         $message .= "Phone Is required";
    }
    elseif (empty($email)) {
         $message .= "Email Is required";
    }
    
    elseif (empty($university_name)) {
         $message .= "University Name Is required";
    }
    elseif (empty($course)) {
         $message .= "Course Is required";
    }
    elseif (empty($level)) {
         $message .= "Level Is required";
    }
    elseif (empty($job_id)) {
         $message .= "Missing Job ID";
    }
    else{
         $stmt = $connect->prepare("SELECT COUNT(*) FROM job WHERE job_id = ?");
    $stmt->execute([$job_id]);
    $job_exists = $stmt->fetchColumn();

    if ($job_exists) {
        // Check if the PDF file is uploaded
        if (isset($_FILES['pdf_document']) && $_FILES['pdf_document']['error'] === UPLOAD_ERR_OK) {
            $pdf_name = $_FILES['pdf_document']['name'];
            $pdf_tmp_name = $_FILES['pdf_document']['tmp_name'];
            $pdf_size = $_FILES['pdf_document']['size'];
            $pdf_ext = pathinfo($pdf_name, PATHINFO_EXTENSION);
            $allowed_ext = array('pdf');

            if (in_array($pdf_ext, $allowed_ext) && $pdf_size <= 5000000) { // Limit file size to 5MB
                $pdf_new_name = uniqid() . '_' . $pdf_name;
                $pdf_path = 'uploads/'.$pdf_new_name;

                // Move the uploaded file to the desired directory
                if (move_uploaded_file($pdf_tmp_name, $pdf_path)) {
                    // Check if a similar request already exists
                    $stmt = $connect->prepare("SELECT COUNT(*) FROM request WHERE first_name = ? AND last_name = ? AND email = ? AND job_id = ?");
                    $stmt->execute([$first_name, $last_name, $email, $job_id]);
                    $existing_request = $stmt->fetchColumn();

                    if ($existing_request == 0) {
                        // Insert the request details into the request table
                        $stmt = $connect->prepare("INSERT INTO request (first_name, last_name, phone, email, university_name, course, level, pdf_path, job_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$first_name, $last_name, $phone, $email, $university_name, $course, $level, $pdf_new_name, $job_id]);

                        $success .="Your request has been submitted successfully";
                    } else {
                        $message .="A request with the same details already exists";
                    }
                } else {
                    $message .="Failed to upload the PDF document. Please try again";
                }
            } else {
                $message .="Invalid file type or size. Please upload a PDF file not exceeding 5MB";
            }
        } else {
           $message .= 'Please upload a PDF document';
        }
    }
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Job</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Request Job</h2>
        <?php 
            if($message != ''){
                echo '<div class="alert alert-danger">'.$message.'</div>';
            }
            else if($success != ''){
                echo '<div class="alert alert-success">'.$success.'</div>';
            }
            else{
                echo '';
            }
        ?>
        <?php 
            require 'database_connection.php';
            $select = $connect->prepare("SELECT * FROM job WHERE job_id = :job_id");
            $select->bindParam(':job_id',$_GET['job_id'],PDO::PARAM_STR);
            $select->execute();
            $show_all = $select->fetchAll(PDO::FETCH_OBJ);
            if ($select->rowCount() > 0) {
                foreach ($show_all as $row) {
                    
               ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($_GET['job_id']); ?>"> <!-- Ensure job_id is passed correctly -->
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" >
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" >
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" >
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" >
            </div>
            <div class="form-group">
                <label for="university_name">University Name</label>
                <input type="text" name="university_name" id="university_name" class="form-control" >
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <input type="text" name="course" id="course" class="form-control" >
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select name="level" id="level" class="form-control" >
                    <option value="Degree">Degree</option>
                    <option value="Diploma">Diploma</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pdf_document">Upload PDF Document</label>
                <input type="file" name="pdf_document" id="pdf_document" class="form-control-file" accept=".pdf" >
            </div>
            <a href="requests.php" class="btn btn-primary mt-3">Previous</a>
            <button type="submit" class="btn btn-primary mt-3" name="submit">Submit Request</button>
        </form>
    </div>
        <?php
        }
    }
?>
</body>
</html>
