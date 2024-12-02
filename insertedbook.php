<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserted Books</title>
    <style>
        body {
            background-color: rgb(31, 49, 20);
            color: rgb(255, 238, 0);
            font-family: Georgia, 'Times New Roman', Times, serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 95vh;

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
        .displaybooks{
            margin-top: 20px;
            overflow: scroll;
        }
        .displaybooks::-webkit-scrollbar {
            width: 0px;
        }
        form {
            border: 10px solid red;
            padding: 20px;
        }
        input{
            border-radius: 5px;
            border: 1px solid #ccc;
            padding:8px;
            font-size:16px;
        }
        input:focus {
            outline: none;
            border-color: #007bff;
        }
        input[type='text']{
            width: 93%;
            padding: 5px;
            margin-bottom: 5px;
        }
        input[type='submit']{
            width: 24%;
            padding: 5px;
            margin-bottom: 5px;
        }
        input[type='search']{
            width: 75%;
            padding: 5px;
            margin-bottom: 5px;
            font-size: 16px;
        }
        a{
            text-decoration: none;
            color:black;
        }
    </style>
</head>

<?php
    session_start();
    echo "<script>console.log('Session Username: " . $_SESSION['username'] . "');</script>";
    echo "<script>console.log('Session User ID: " . $_SESSION['user_id'] . "');</script>";
    if(!isset($_SESSION['username'])){
        header("Location:login.php");
    }

    $con = mysqli_connect("localhost", "root", "", "library");
    if (!$con) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    $fullresult = null;
    if (!isset($_POST['searchbook'])) {
        $sql = "SELECT * FROM books";
        try {
            $fullresult = mysqli_query($con, $sql);
        } catch (Exception $e) {
            echo $e;
        }
    }

    if (isset($_POST['searchbook'])) {
        $bookdetail = trim($_POST['bookdetail']);

        $sql = "SELECT * FROM books 
                WHERE ID = '$bookdetail' 
                OR LOWER(Title) LIKE LOWER('%$bookdetail%') 
                OR LOWER(Author) LIKE LOWER('%$bookdetail%') 
                OR LOWER(Category) LIKE LOWER('%$bookdetail%')
                OR LOWER(Available) LIKE LOWER('%$bookdetail%')";

        try {
            $result = mysqli_query($con, $sql);
        } catch (Exception $e) {
            echo $e;
        }
    }
?>
<body>
    <nav>
        <a href="Books.php"><h1>Library Management System</h1></a>
        <a href="Registeruser.php"><h4>Register User</h4></a>
        <a href="Books.php"><h4>Return Home</h4></a>
        <a href="logout.php"><h1>Logout</h1></a>
    </nav>
    <div class="displaybooks">
        <form action="" method="post">
            <input type="search" name="bookdetail" placeholder="Enter the detail of book to search">
            <input type="submit" name="searchbook" value="Search Book">
            <table border="1" class="displaytable">
                <thead>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Book Author</th>
                    <th>Book Category</th>
                    <th>Book Availability</th>
                </thead>
                <tbody>
                    <tbody>
                        <?php
                            if (isset($_POST['searchbook'])) {
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['ID'] . "</td>";
                                        echo "<td>" . $row['Title'] . "</td>";
                                        echo "<td>" . $row['Author'] . "</td>";
                                        echo "<td>" . $row['Category'] . "</td>";
                                        echo "<td>" . $row['Available'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No results found.</td></tr>";
                                }
                            } else {
                                if ($fullresult && mysqli_num_rows($fullresult) > 0) {
                                    while ($row = mysqli_fetch_assoc($fullresult)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Author']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Category']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Available']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No books available.</td></tr>";
                                }
                            }
                        ?>

                </tbody>
            </table>
        </form>
    </div>
</body>
</html>
