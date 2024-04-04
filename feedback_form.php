<?php

$name = $_POST["name"];
$email = $_POST["email"];
$feedback = $_POST["feedback"];

$host = "localhost";
$dbname = "feedback_db";
$username = "root";
$password = "";

$conn = mysqli_connect(hostname: $host,
username: $username, password: $password, database: $dbname);

if(mysqli_connect_errno()){
    die("Connection error: " . mysqli_connect_errno());
}

$sql = "INSERT INTO feedback(name, email, feedback)
        VALUES (?,?,?)";

$stmt = mysqli_stmt_init($conn);

if( ! mysqli_stmt_prepare($stmt, $sql)){
    die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "sss", $name, $email, $feedback);

mysqli_stmt_execute($stmt);

echo "Feedback saved.";


