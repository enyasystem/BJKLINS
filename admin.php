<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cleaning_service";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Bookings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Cleaning Service Bookings</h1>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['service']}</td>
                                <td>{$row['date']}</td>
                                <td>{$row['time']}</td>
                                <td>{$row['message']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No bookings found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
