<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(31, 49, 20);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .registration-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .registration-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 95%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }
        .form-button {
            text-align: center;
        }
        .form-button input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-button input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .form-button a {
            display: inline-block;
            margin-top: 10px;
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .form-button a:hover {
            background-color: #218838;
        
    </style>
</head>

<body>
    <div class="registration-form">
        <h2>User Registration</h2>
        <form action="submit_registration.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Member Ship ID:</label>
                <input type="text" id="membership" name="membership" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-button">
                <input type="submit" value="Register">
            </div>
            <div class="form-button">
                <a href="Books.php">Return Home</a>
            </div>
        </form>
    </div>
</body>

</html>