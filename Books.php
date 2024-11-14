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
        nav{
            display:flex;
            position:absolute;
            top:0;
            justify-content:space-evenly;
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
        .displaybooks{
            margin-top: 20px;
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
    </style>
</head>

<?php
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
        <h1>Library Management System</h1>
        <a href="Registeruser.php"><h4>Register User</h4></a>
        <a href="Report.php"><h4>Library Report</h4></a>
        <h1>Logout</h1>
    </nav>
    <div>
        <form method='POST' action=' '>
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
                                        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Author']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Category']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Available']) . "</td>";
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
        if (mysqli_query($con,$sql)){
            echo "<br><br><br>Inserted Successfully!!!";
        }
        else{
            echo "<br>Insertion Failed!!!";
        }
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
