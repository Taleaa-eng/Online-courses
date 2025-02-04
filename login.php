<?php
include 'header.php';
require 'admin/dbconnect.php';

// Define variables
$name = $email = $pass = "";
$nameError = $emailError = $passError = "";

// Process POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Validate name
    if (empty($_POST["name"])) {
        $nameError = "*This field is required.";
        $isValid = false;
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailError = "*This field is required.";
        $isValid = false;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format.";
        $isValid = false;
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passError = "*This field is required.";
        $isValid = false;
    } elseif (strlen($_POST["password"]) < 6) {
        $passError = "Password must be at least 6 characters long.";
        $isValid = false;
    } else {
        $pass = htmlspecialchars($_POST["password"]);
    }

    // If valid, check if the email exists
    if ($isValid) {
        // Check if the email already exists
        $stmt = $con->prepare("SELECT * FROM users WHERE email = :email AND status = 1");
        $stmt->execute(["email" => $email]);

        if ($stmt->rowCount()) {
            $row = $stmt->fetch();
            // Store user info in session
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['user_info'] = $row;
            $_SESSION['user_info']['password'] = ""; // Clear password from session

            // Redirect based on role
            if ($_SESSION['user_info']['role'] == "User") {
                header("Location: index.php");
            } else {
                header("Location: admin/index.php");
            }
            exit();
        } else {
            // Email does not exist, register new user
            $passwordHash = password_hash($pass, PASSWORD_DEFAULT); // Hash the password
            $role = 'User'; // Set default role to 'user'
            $stmt = $con->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            
            if ($stmt->execute([$name, $email, $passwordHash, $role])) {
                echo "<div class='alert alert-success'>User registered successfully!</div>";
                $_SESSION['name'] = $name; // Store name in session
                $_SESSION['user_id'] = $con->lastInsertId(); // Store the new user's ID
                header("Location: index.php"); // Redirect to user page
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error registering user.</div>";
            }
        }
    }
}
?>

<div class="btn-login">
    <button id="login">Login</button>
</div>
<div class="popup">
    <div class="btn-close">&times;</div>
    <div class="form">
        <h2 class="h2form">Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-element">
                <label for="username">Username:</label><br>
                <input type="text" id="username" placeholder="Username" class="input-field" name="name" value="<?php echo $name; ?>">
                <span class="error"><?php echo $nameError; ?></span>
            </div>

            <div class="form-element">
                <label for="em">Email:</label><br>
                <input type="text" id="em" placeholder="Email" class="input-field" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailError; ?></span>
            </div>

            <div class="form-element">
                <label for="pass">Password:</label><br>
                <input type="password" id="pass" placeholder="Password" class="input-field" name="password">
                <span class="error"><?php echo $passError; ?></span>
            </div>

            <div class="form-element">
                <div class="forgot-password"><a href="#">Forgot your password?</a></div>
            </div>
            <div class="form-element">
                <button class="butn3" type="submit" value="login">Login</button>
            </div>
        </form>
    </div>
</div>

<div class="loader"></div>

<script src="js.js"></script>