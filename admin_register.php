<?php

include('admin_register_process.php');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Registration</title>
    <style>
        .main-content {
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Nirmala UI';
        }

        .form-cont {
            padding: 20px;
            background: lightcoral;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            margin: 0 0 20px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        label p {
            color: #ff0000;
            margin: 0 0 5px;
            font-size: 14px;
        }

        input {
            margin: 5px 0;
            padding: 8px;
            border: none;
            outline: none;
            flex: 1;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            margin-top: 10px;
            padding: 10px;
            font-size: 17px;
            background: #fff;
            border: none;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }

        @media (max-width: 480px) {
            .form-cont {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="form-cont">
            <h2>Admin Registration</h2>
            <form action="admin_register.php" method="POST">
                <label for="firstname"><p>First Name:</p></label>
                <input type="text" id="firstname" name="firstname" required>

                <label for="lastname"><p>Last Name:</p></label>
                <input type="text" id="lastname" name="lastname" required>

                <label for="username"><p>Username:</p></label>
                <input type="text" id="username" name="username" required>

                <label for="phone"><p>Phone Number:</p></label>
                <input type="text" id="phone" name="phone" required>

                <label for="password"><p>Password:</p></label>
                <input type="password" id="password" name="password" required>

                <label for="user_role"><p>User Role:</p></label>
                <select id="user_role" name="user_role" required>
                    <option value="customer">Customer</option>
                    <option value="cook">Cook</option>
                    <option value="delivery">Delivery</option>
                    <option value="manager">Manager</option>
                </select>

                <button type="submit">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
