<?php

session_start();

include("config.php");

$username = $password = "";
$error = ["uname" => "", "pass" => ""];

if (isset($_POST["submit"])) {

    if (empty($_POST["username"])) {
        $error["uname"] = "Please enter your username or mobile number!";
    } else {
        $username = trim($_POST["username"]); // Trim the input

        // Check if the input is a phone number or username
        if (is_numeric($username)) {
            // Input is a phone number
            if (strlen($username) !== 10) {
                $error["uname"] = "Please enter a valid 10-digit phone number!";
            }
        } else {
            // Input is a username
            if (strlen($username) < 3) {
                $error["uname"] = "Username should be at least 3 characters long!";
            }
        }
    }

    if (empty($_POST["password"])) {
        $error["pass"] = "Please enter your password!";
    } else {
        $password = $_POST["password"];
    }

    // Check if there are errors in the form
    if (array_filter($error)) {
        // Display the errors or handle them accordingly
        // For example, you can assign the errors to session variables and redirect back to the sign-in page

        $_SESSION['signin_errors'] = $error;
        $_SESSION['username'] = $username; // Retain entered username

        header('Location: sign-in.php');
        exit();
    } else {
        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE (username = ? OR phone = ?)");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password'];

            if (password_verify($password, $hashedPassword)) {
                // Password is correct, log in the user
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['user_role'];

                // Redirect based on user role
                switch ($user['user_role']) {
                    case 'admin':
                        header('Location: admin.php');
                        break;
                    case 'manager':
                        header('Location: manage.php');
                        break;
                    case 'delivery':
                        header('Location: delivery.php');
                        break;
                    case 'cook':
                        header('Location: cook.php');
                        break;
                    case 'customer':
                    default:
                        header('Location: index.php');
                        break;
                }
                exit();
            } else {
                // Password is incorrect
                $error["pass"] = "Invalid password. Please try again.";
            }
        } else {
            // User does not exist
            $error["uname"] = "User does not exist. Please try again.";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
} else {
    // Check if there are any stored username and error values in session
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        unset($_SESSION['username']); // Clear stored username
    }
    if (isset($_SESSION['signin_errors'])) {
        $storedError = $_SESSION['signin_errors'];
        $error["uname"] = $storedError["uname"]; // Retain stored error subject for username
        unset($_SESSION['signin_errors']); // Clear stored errors
    }
}

?>