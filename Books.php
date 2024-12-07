<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Form</title>
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
        .displaytable td{
            text-align:center;
        }
        .buttonclass input[type='submit']{
            margin:0px 12px 0px 12px;
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
        .bookinsertform{
            margin-top:100px;
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
    $con = mysqli_connect("localhost","root","","library");
    $sql1="SELECT MAX(id) FROM books";
    $lastbookid = mysqli_query($con, $sql1);
    $row = mysqli_fetch_assoc($lastbookid);
    $lastbookidno = $row['id'];
    echo "<script>console.log($lastbookidno)</script>";
    mysqli_close($con);
?>

<body>
    <nav>
        <a href="Books.php"><h1>Library Management System</h1></a>
        <a href="Registeruser.php"><h4>Register User</h4></a>
        <a href="Insertedbook.php"><h4>Inserted Books</h4></a>
        <a href="adminbooking.php"><h4>Bookings</h4></a>
        <a href="logout.php"><h1>Logout</h1></a>
    </nav>
    <div>
        <form method='POST' action=' ' class="bookinsertform">
            <table>
                <tr>
                    <td colspan="4" align="center">Book Section</th>
                </tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr>
                    <td colspan="2"><label for="">Book ID </label></td>
                    <td colspan="2"><input type="text" name="bid"></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="">Book Name </label></td>
                    <td colspan="2"><input type="text" name="bname"></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="">Book Author </label></td>
                    <td colspan="2"><input type="text" name="aname"></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="">Category </label></td>
                    <td>
                        <input type="radio" name="category" id="Action" value="Action"><label
                            for="Action">Action</label><br>
                        <input type="radio" name="category" value="Adventure" id="Adventure"> <label
                            for="Adventure">Adventure</label><br>
                        <input type="radio" name="category" value="Thriller" id="Thriller"> <label
                            for="Thriller">Thriller</label>
                    </td>
                    <td>
                        <input type="radio" name="category" value="Romance" id="Romance"> <label
                            for="Romance">Romance</label><br>
                        <input type="radio" name="category" value="Horror" id="Horror"> <label
                            for="Horror">Horror</label><br>
                        <input type="radio" name="category" value="Science Fiction" id="Sciencefiction"> <label
                            for="Sciencefiction">Science Fiction</label>
                    </td>
                </tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr>
                    <td colspan="4" class="buttonclass">
                        <input type="submit" name="insert" value="INSERT">
                        <input type="submit" name="update" value="UPDATE">
                        <input type="submit" name="delete" value="DELETE">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>

<?php
if(isset($_POST['insert']))
{
    $bid = $_POST['bid'];
    $bname = $_POST['bname'];
    $aname = $_POST['aname'];
    $category = $_POST['category'];
    $con = mysqli_connect("localhost","root","","library");
    if(!$con)
        die("Connection Failed ".mysqli_connect_error());
    $sql="insert into books (ID, Title, Author, Category) values ('$bid','$bname','$aname','$category')";
    try{
        mysqli_query($con,$sql);
    }
    catch(Exception $e)
    {
    echo "</br></br> Enter the values in textbox to  insert";
    echo $e;
    }
    mysqli_close($con);
}
if(isset($_POST['update']))
{
    $ubid = $_POST['bid'];
    $ubname = $_POST['bname'];
    $uaname = $_POST['aname'];
    $ucategory = $_POST['category'];
    $ucon = mysqli_connect("localhost", "root", "", "library");
    if(!$ucon)
        die("Connection Failed " . mysqli_connect_error());
    $usql = "UPDATE books SET Title='$ubname', Author='$uaname', Category='$ucategory' WHERE ID='$ubid'";
    if (mysqli_query($ucon, $usql)) {
        echo "<br><br><br>Updated Successfully!!!";
    } else {
        echo "<br>Update Failed!!!";
    }
    mysqli_close($ucon);
}

if(isset($_POST['delete']))
{
    $dbid = $_POST['bid'];
    $dcon = mysqli_connect("localhost", "root", "", "library");
    if(!$dcon)
        die("Connection Failed " . mysqli_connect_error());
    $dsql = "DELETE FROM books WHERE ID='$dbid'";
    if (mysqli_query($dcon, $dsql)) {
        echo "<br><br><br>Deleted Successfully!!!";
    } else {
        echo "<br>Deletion Failed!!!";
    }
    mysqli_close($dcon);
}
?>