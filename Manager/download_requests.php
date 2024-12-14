<?php
// Include database connection
include 'database_connection.php';

// Set headers to force download of CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=student_requests.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, array('First Name', 'Last Name', 'Phone', 'Email', 'University Name', 'Course', 'Level', 'PDF Document'));

// Fetch the data
$select = $connect->prepare("SELECT * FROM request");
$select->execute();
$show_all = $select->fetchAll(PDO::FETCH_OBJ);

// Output each row
if ($select->rowCount() > 0) {
    foreach ($show_all as $row) {
        fputcsv($output, array(
            $row->first_name,
            $row->last_name,
            $row->phone,
            $row->email,
            $row->university_name,
            $row->course,
            $row->level,
            $row->pdf_path
        ));
    }
}

// Close output stream
fclose($output);
exit();
?>
