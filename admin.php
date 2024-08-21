<?php
session_start(); // Start the session at the beginning of the script
include './includes/db.php'; // Include the database connection

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input values
    $date = $connection->real_escape_string($_POST['date']);
    $time = $connection->real_escape_string($_POST['time']);
    $name = $connection->real_escape_string($_POST['name']);
    $email = $connection->real_escape_string($_POST['email']);
    $service = $connection->real_escape_string($_POST['service']);
    $message = $connection->real_escape_string($_POST['message']);

    // Insert the booking into the database
    $sql = "INSERT INTO bookings (name, email, phone, service, date, time, message) 
            VALUES ('$name', '$email', '', '$service', '$date', '$time', '$message')";

    if ($connection->query($sql) === TRUE) {
        $_SESSION['booking_success'] = true; // Set a session variable for success message
        header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page to avoid form resubmission
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

include './includes/header.php';
?>

<div class="container">
    <?php
    // Display success message if booking was successful
    if (isset($_SESSION['booking_success']) && $_SESSION['booking_success']) {
        echo '<div class="alert alert-success mt-3">
                <strong>&#10004; Booking successful!</strong> Thank you for choosing our service.
              </div>';
        // Remove the session variable
        unset($_SESSION['booking_success']);
        
        // Redirect to home page after 3 seconds
        echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php"; // Replace "index.php" with your home page
                }, 3000); // 3 seconds delay
              </script>';
    }
    ?>

    <!-- Your booking table or other content goes here -->
</div>

<?php
include './includes/footer.php';
$connection->close();
?>
