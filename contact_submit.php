<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $service    = mysqli_real_escape_string($conn, $_POST['service']);
    $message    = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages 
    (first_name, last_name, email, phone, service, message)
    VALUES
    ('$first_name', '$last_name', '$email', '$phone', '$service', '$message')";

    if (mysqli_query($conn, $sql)) {

        echo "
        <script>
            alert('Message Sent Successfully!');
            window.location.href='contact.html';
        </script>
        ";

    } else {

        echo "Error: " . mysqli_error($conn);

    }

}

?>