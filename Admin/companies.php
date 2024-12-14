<?php
include 'database_connection.php';

// Fetch company data from the company table
$company_data = [];
$query = "SELECT * FROM company";
$stmt = $connect->prepare($query);
$stmt->execute();
$company_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>View Companies</title>
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
                        <h4 class="page-title">Company List</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Companies</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Company Details</h5>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Company Email</th>
                                            <th>Company Phone</th>
                                            <th>Company Address</th>
                                            <th>Company Location</th>
                                            <th>User ID</th>
                                            <th>User Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($company_data) > 0): ?>
                                            <?php foreach ($company_data as $company): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($company['company_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($company['company_email']); ?></td>
                                                    <td><?php echo htmlspecialchars($company['company_phone']); ?></td>
                                                    <td><?php echo htmlspecialchars($company['company_address']); ?></td>
                                                    <td><?php echo htmlspecialchars($company['company_location']); ?></td>
                                                    <td><?php echo htmlspecialchars($company['user_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($company['user_name']); ?></td>
                                                    <td>
                                                    <a href="edit_company.php?user_upd='.$rows['user_id'].'"  class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fa fa-edit">Edit</i></a>
                                                    <a href="edit_company.php?user_upd='.$rows['user_id'].'"  class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fa fa-delete">Delete</i></a>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center">No companies found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
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
