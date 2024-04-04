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
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Check if the user exists in the database
        $check_query = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $check_query->execute([$email]);
        $result = $check_query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Verify password
            if ($password === $result['password']) { // Compare passwords directly
                // Set session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $email;
                
                // Redirect to home page or desired location
                header("location: home.html");
                exit;
            } else {
                // Invalid password
                $login_error = "Invalid email or password";
            }
        } else {
            // User not found
            $login_error = "User not found";
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
    <title>Login Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            background-image: url('bg5wp.jpg'); /* Specify the path to your background image */
            background-size: cover;
            background-position: center;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for the form */
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

        .error {
            color: red;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        .registration-link {
            text-align: center;
        }

        .registration-link a {
            color: #863f3f;
            text-decoration: none;
        }

        .registration-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <?php if (isset($login_error)) { ?>
                <p class="error"><?php echo $login_error; ?></p>
            <?php } ?>
            <button type="submit">Login</button>
        </form>
        <div class="registration-link">
            <p>Not registered yet? <a href="registration.php">Register here</a></p>
        </div>
    </div>
</body>
</html>

