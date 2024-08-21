<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    $created_at = $conn->real_escape_string($_POST['created_at']);

    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message','created_at')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    header("Location: index.php");

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
       echo ('error');
    }

    $conn->close();
} else {
    header("Location: index.php");
    exit();
}


?>
