<?php
include './includes/header.php';
include './includes/db.php'; // Ensure you have your database connection here

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $service = $_POST['service'];
    $message = $_POST['message'];
    $contact = $_POST['contact']; // Assuming you'll add this field in the form

    // Prepare and execute the query
    $stmt = $connection->prepare("INSERT INTO bookings (name, email, phone, service, date, time, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $contact, $service, $date, $time, $message);

    if ($stmt->execute()) {
        // Set session variable for success message
        $_SESSION['booking_success'] = true;
        
        // Display success message if booking was successful
        if (isset($_SESSION['booking_success']) && $_SESSION['booking_success']) {
            echo '<div class="alert alert-success mt-3">Booking successful! Thank you for choosing our service.</div>';
            // Unset the session variable
            unset($_SESSION['booking_success']);
        }
        
        // Redirect using JavaScript after 3 seconds
        echo '<script>
            setTimeout(function() {
                window.location.href = "index.php";
            }, 3000);
        </script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}
?>
<!-- Booking section -->
<section id="booking" style="background-color: #f8f9fa;">
    <div class="container">
        <h2 class="text-center">Book Your Cleaning Appointment</h2>
       
        <form id="bookingForm" action="" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="date">Select Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="time">Select Time</label>
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Your Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="contact">Your Phone Number</label>
                    <input type="tel" class="form-control" id="contact" name="contact" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="service">Select Service</label>
                    <select class="form-control" id="service" name="service" required>
                        <option value="Regular Cleaning">Regular Cleaning</option>
                        <option value="Deep Cleaning">Deep Cleaning</option>
                        <option value="Move-In/Move-Out Cleaning">Move-In/Move-Out Cleaning</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="message">Additional Message (optional)</label>
                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Book Now</button>
        </form>
    </div>
</section>

<?php include './includes/footer.php'; ?>
