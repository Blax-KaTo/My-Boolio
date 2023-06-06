<?php
session_start();

include('config.php');

if (isset($_POST["submit"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $user_role = $_POST["user_role"];

    // Perform input validation and error handling as needed

    // Check if the username or phone number already exists
    $stmt = $conn->prepare("SELECT username, phone FROM users WHERE username = ? OR phone = ?");
    $stmt->bind_param("ss", $username, $phone);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username or phone number already exists, handle the error
        $_SESSION["admin_register_error"] = "Username or phone number already exists. Please choose a different one.";
        header('Location: admin_register.php');
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the account details into the database
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, phone, password, user_role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstname, $lastname, $username, $phone, $hashedPassword, $user_role);
    $stmt->execute();

    // Redirect to a success page or the admin dashboard
    $_SESSION["admin_register_success"] = "Account registered successfully!";
    header('Location: admin.php');
    exit();
}
?>
