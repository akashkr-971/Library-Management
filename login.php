<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library User Login</title>
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
        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin-top: 50px;
        }
        .login-form h2 {
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
        }
        nav {
            display: flex;
            position: absolute;
            top: 0;
            justify-content: space-evenly;
            width: 100%;
            background-color: rgb(36, 242, 132);
            color: black;
        }
        a{
            text-decoration: none;
            color:black;
        }
    </style>
</head>

<body>
    <nav>
        <h1>Library Management System</h1>
    </nav>
    <div class="login-form">
        <h2>User Login</h2>
        <form action=" " method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-button">
                <input type="submit" name="login-button" value="Login">
            </div>
        </form>
    </div>
</body>
<?php
    session_start();
    $con = mysqli_connect("localhost","root","","library");
    if(!$con)
        die("Connection Failed ".mysqli_connect_error());
        
    if(isset($_POST['login-button']))
    {
        $uname = $_POST['username'];
        $upass = $_POST['password'];
        $sql = "SELECT * FROM Users WHERE  username='$uname' ";
        try{
            $result = mysqli_query($con, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if ($upass == $row['password'] ) {
                    $_SESSION['user_id'] = $row['Membership_id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['role'] = $row['role'];
                    echo "<script>console.log('Session Username: " . $_SESSION['username'] . "');</script>";
                    echo "<script>console.log('Session User ID: " . $_SESSION['user_id'] . "');</script>";
                    if($row['role'] == 'admin')
                        header("Location: books.php");
                    else
                        header("Location: student.php");
                }
                else{
                    echo "<script>alert('Invalid password!'); window.location.href='login.php';</script>";
                }
                
            } else {
                echo "<script>alert('No user found with that username!'); window.location.href='login.php';</script>";
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
    mysqli_close($con);

?>

</html>