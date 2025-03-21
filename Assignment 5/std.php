<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mentee_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST['t1'];
    $name = $_POST['t2'];
    $email = $_POST['t3'];
    $mobile = $_POST['t4'];
    $address = $_POST['t5'];
    $mentor = $_POST['t6'];
    $certificates = $_POST['t7'];

    $sql = "INSERT INTO mentees (roll_no, name, email, mobile, address, mentor, certificates)
            VALUES ('$roll_no', '$name', '$email', '$mobile', '$address', '$mentor', '$certificates')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
