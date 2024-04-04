<?php

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$message = $_POST["message"];

$host = "localhost";
$dbname = "contact_db";
$username = "root";
$password = "";

$conn = mysqli_connect(hostname: $host,
username: $username, password: $password, database: $dbname);

if(mysqli_connect_errno()){
    die("Connection error: " . mysqli_connect_errno());
}

$sql = "INSERT INTO contact(name, email, phone, address, message)
        VALUES (?,?,?,?,?)";

$stmt = mysqli_stmt_init($conn);

if( ! mysqli_stmt_prepare($stmt, $sql)){
    die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $address, $message);

mysqli_stmt_execute($stmt);

echo "Record saved.";






