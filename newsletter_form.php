<?php 

$email = $_POST["email"];

$host = "localhost";
$dbname = "newsletter_db";
$username = "root";
$password = "";

$conn = mysqli_connect(hostname: $host,
username: $username, password: $password, database: $dbname);

if(mysqli_connect_errno()){
    die("Connection error: " . mysqli_connect_errno());
}

$sql = "INSERT INTO newsletter(email)
        VALUES (?)";

$stmt = mysqli_stmt_init($conn);

if( ! mysqli_stmt_prepare($stmt, $sql)){
    die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $email);

mysqli_stmt_execute($stmt);

echo "Record saved.";


