<?php
session_start();

// Database connection settings
$host = "localhost";
$dbname = "contact_db";
$username = "root";
$password = "";

try {
    // Connect to the database using PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set PDO to throw exceptions on errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"]; // Without hashing

        // Check if the email already exists
        $check_query = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $check_query->execute([$email]);
        $result = $check_query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "<script>alert('Email already registered. Please use a different email.');</script>";
        } else {
            // Insert new user into the database
            $insert_query = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $insert_query->execute([$name, $email, $password]); // Store password directly

            // Redirect to the login page after successful registration
            echo "<script>alert('Registration successful. Redirecting to login page...');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
            exit;
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css"> <!-- You can link your CSS file here -->
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f8f8;
        background-image: url('bg3wp.png'); /* Specify the path to your background image */
        background-size: cover;
        background-position: center;
    }

    .container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.8); /* Add transparency to the background color */
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
    }

    .input-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        background-color: #5cdb95;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-family: 'Poppins', sans-serif;

    }

    button[type="submit"]:hover {
        background-color: #863f3f;
    }

    .login-link {
        text-align: center;
    }

    .login-link a {
        color: #863f3f;
        text-decoration: none;
    }

    .login-link a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="container">
        <h2>Registration</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="input-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            <p>Already registered? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>

