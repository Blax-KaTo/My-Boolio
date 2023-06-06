<?php

session_start();

include('config.php');

$firstname = $lastname = $username = $phone = $password = "";
$error = ["fname" => "", "lname" => "", "uname" => "", "phon" => "", "pass" => ""];

if (isset($_POST["submit"])) {
    if (empty($_POST["firstname"])) {
        $error["fname"] = "Please state your first name!";
    } else {
        $firstname = $_POST["firstname"];
        $trimmedFirstname = trim($firstname);
        if (strlen($trimmedFirstname) < 3) {
            $error["fname"] = "Name must not be less than 3 characters!";
        } else {
            if (!preg_match("/^[a-zA-Z]+$/", $trimmedFirstname)) {
                $error["fname"] = "Name must only have letters (a-z or A-Z).";
            } elseif ($trimmedFirstname !== $firstname) {
                $firstname = $trimmedFirstname;
                $error["fname"] = "<span style='color: green;'>Trim was used. Updated value: $firstname</span>";
            }
        }
    }

    if (empty($_POST["lastname"])) {
        $error["lname"] = "Please state your last name!";
    } else {
        $lastname = $_POST["lastname"];
        $trimmedLastname = trim($lastname);
        if (strlen($trimmedLastname) < 3) {
            $error["lname"] = "Name must not be less than 3 characters!";
        } else {
            if (!preg_match("/^[a-zA-Z]+$/", $trimmedLastname)) {
                $error["lname"] = "Name must only have letters (a-z or A-Z).";
            } elseif ($trimmedLastname !== $lastname) {
                $lastname = $trimmedLastname;
                $error["lname"] = "<span style='color: green;'>Trim was used. Updated value: $lastname</span>";
            }
        }
    }

    if (empty($_POST["username"])) {
        $error["uname"] = "Please state your username!";
    } else {
        $username = $_POST["username"];
        $trimmedUsername = trim($username);
        if (strlen($trimmedUsername) < 3) {
            $error["uname"] = "Username must not be less than 3 characters!";
        } else {
            if (!preg_match("/^[a-zA-Z0-9_-]+$/", $trimmedUsername)) {
                $error["uname"] = "Username must only have letters (a-z or A-Z), numbers(0-9), iphen (-) & underscores (_).";
            } elseif ($trimmedUsername !== $username) {
                $username = $trimmedUsername;
                $error["uname"] = "<span style='color: green;'>Trim was used. Updated value: $username</span>";
            } else {
                // Check if the username already exists
                $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $error["uname"] = "Username already exists. Please choose a different one.";
                }
                $stmt->close();
            }
        }
    }

    if (empty($_POST["phone"])) {
        $error["phon"] = "Please state your mobile number!";
    } else {
        $phone = $_POST["phone"];
        $trimmedPhone = trim($phone);
        if (strlen($trimmedPhone) !== 10) {
            $error["phon"] = "Number must be exactly 10 numbers.";
        } else {
            if (!preg_match("/^[+0-9]+$/", $trimmedPhone)) {
                $error["phon"] = "Number must only have a valid number (+, 0-9).";
            } elseif ($trimmedPhone !== $phone) {
                $phone = $trimmedPhone;
                $error["phon"] = "<span style='color: green;'>Trim was used. Updated value: $phone</span>";
            } else {
                // Check if the phone number already exists
                $stmt = $conn->prepare("SELECT phone FROM users WHERE phone = ?");
                $stmt->bind_param("s", $phone);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $error["phon"] = "Phone number already exists. Please choose a different one.";
                }
                $stmt->close();
            }
        }
    }

    if (empty($_POST["password"])) {
        $error["pass"] = "Please state your password!";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 6) {
            $error["pass"] = "Password must not be less than 6 characters!";
        }
    }

    // Check if there are errors in the form
    if (array_filter($error)) {
        // Display the errors or handle them accordingly
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the SQL statement
        $sql = "INSERT INTO users (firstname, lastname, username, phone, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $firstname, $lastname, $username, $phone, $hashedPassword);
        $stmt->execute();

        // Check if the registration was successful
        if ($stmt->affected_rows > 0) {
            // Registration successful
            $_SESSION['username'] = $username; // Store the username in the session
            header('Location: signup_success.php');
            exit;
        } else {
            // Registration failed
            echo "Registration failed. Please try again.";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
} else {
    // echo "Submit not set";
}
?>