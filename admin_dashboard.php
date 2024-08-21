<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit;
}

// Include database connection
include './includes/db.php';


// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $connection->query("DELETE FROM bookings WHERE id='$id'");
    header("Location: admin-dashboard.php"); // Redirect back to the dashboard after deletion
}

// Fetch booking data for the table
$result = $connection->query("SELECT * FROM bookings");

// Calculate dashboard metrics
$totalBookingsResult = $connection->query("SELECT COUNT(*) AS total FROM bookings");
$totalBookings = $totalBookingsResult->fetch_assoc()['total'];

$completedBookingsResult = $connection->query("SELECT COUNT(*) AS total FROM bookings WHERE status='Completed'");
$completedBookings = $completedBookingsResult->fetch_assoc()['total'];

$pendingBookingsResult = $connection->query("SELECT COUNT(*) AS total FROM bookings WHERE status='Pending'");
$pendingBookings = $pendingBookingsResult->fetch_assoc()['total'];

$cancelledBookingsResult = $connection->query("SELECT COUNT(*) AS total FROM bookings WHERE status='Cancelled'");
$cancelledBookings = $cancelledBookingsResult->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - View Bookings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <style>
        /* Add your existing styles here */
        /* ... */
        /* Admin_Dashboard */
        :root {
            --primary-color: #4e73df;
            --secondary-color: #2e59d9;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
            --text-color: #858796;
            --bg-color: #f8f9fc;
            --sidebar-width: 225px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--bg-color);
        }

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: var(--primary-color);
            color: var(--light-color);
            transition: all 0.3s;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: var(--secondary-color);
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li a {
            padding: 10px 15px;
            font-size: 1rem;
            display: block;
            color: rgba(255, 255, 255, .8);
            text-decoration: none;
            transition: all 0.3s;
        }

        #sidebar ul li a:hover,
        #sidebar ul li a.active {
            color: #fff;
            background: rgba(255, 255, 255, .1);
        }

        #sidebar ul li a i {
            margin-right: 10px;
        }

        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .navbar {
            padding: 15px 10px;
            background: #fff;
            border: none;
            border-radius: 0;
            margin-bottom: 40px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .navbar-btn {
            box-shadow: none;
            outline: none !important;
            border: none;
        }

        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .table-responsive {
            border-radius: 0.35rem;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background: var(--primary-color);
            color: white;
            border: none;
        }

        .table td,
        .table th {
            vertical-align: middle;
            padding: 0.75rem;
            border-top: 1px solid #e3e6f0;
        }

        .btn-circle {
            border-radius: 100%;
            height: 2.5rem;
            width: 2.5rem;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-circle.btn-sm {
            height: 1.8rem;
            width: 1.8rem;
            font-size: 0.75rem;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                margin-left: 0;
            }

            #sidebarCollapse span {
                display: none;
            }

            .card-deck {
                flex-direction: column;
            }

            .card-deck .card {
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin Dashboard</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="active">
            <a href="#"><i class="fas fa-fw fa-tachometer-alt"></i> Dashboard</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-fw fa-calendar-check"></i> Bookings</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-fw fa-broom"></i> Services</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-fw fa-users"></i> Users</a>
        </li>
        <li>
            <a href="#"><i class="fas fa-fw fa-cog"></i> Settings</a>
        </li>
    </ul>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fas fa-align-left"></i>
                </button>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#" aria-label="Messages"><i class="fas fa-envelope fa-fw"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" aria-label="Notifications"><i class="fas fa-bell fa-fw"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" aria-label="Profile"><i class="fas fa-user fa-fw"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
            <div class="row">
                
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Bookings</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalBookings; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed Bookings</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $completedBookings; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Bookings</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pendingBookings; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Cancelled Bookings</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $cancelledBookings; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<br>
<br>
<br>
                <!-- Bookings Table -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Bookings</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="bookingsTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Customer Name</th>
                                        <th>Service</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= $row['id']; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['service']; ?></td>
                                            <td><?= $row['date']; ?></td>
                                            <td><?= $row['service']; ?></td>
                                            <td>
                                                <a href="admin_dashboard.php?delete=<?= $row['id']; ?>" class="btn btn-danger btn-circle btn-sm" title="Delete"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#bookingsTable').DataTable();

            // Sidebar toggle
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });
        });
    </script>
</body>

</html>

<?php $connection->close(); ?>
