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
            margin-bottom : 20px;
        }
        .displaybooks{
            margin-top:80px;
            width: 80%;
            max-width: 1000px;
            background-color: rgb(52, 73, 94);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            overflow: auto;
            max-height:500px;
        }
        .displaybooks::-webkit-scrollbar {
            width: 0px;
        }
        .bookdetails {
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
            width: 23%;
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
        table{
            width:100%;
        }
        .action{
            width:100% !important;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: rgb(36, 242, 132);
            color: black;
        }

        td {
            background-color: #f8f9fa;
            color: black;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        tr:nth-child(odd) td {
            background-color: #ffffff;
        }
        #bookingform{
            display: flex;
            position:relative;
            transform: translate(0%,10%);
            background-color:green;
            height: 400px;
            width: 500px;
            flex-direction: column;
            padding: 10px;
            border-radius: 10px;
            z-index: 2;
        }
        .buttons{
            display: flex;
            justify-content:space-evenly;
            padding-top:10px;
        }
        .takebutton{
            width:15% !important;
            margin:0 !important;
            padding:0 !important;
        }
        button ,.takebutton{
            padding: 8px 16px;
            border: none;
            background-color: #FFFF00;
            color: green;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }
        button:hover, input[type="submit"]:hover {
            background-color: lightgray;
        }
        #overlay{
            position: absolute;
            height:100%;
            width:100%;
            background-color:#fff;
            z-index:1;
            opacity: 0.3;
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
    if (isset($_POST['Take'])) {
        $user_id = $_SESSION['user_id'];
        $book_id = trim($_POST['bookid']);
        $book_name = trim($_POST['bname']);
        $take_date = trim($_POST['takeDate']);
        $ret_date = trim($_POST['retdate']);
        
        if (empty($take_date)) {
            echo "<script>alert('Please select a take date.'); window.history.back();</script>";
            exit;
        }
        if (empty($ret_date)) {
            echo "<script>alert('Please reselect the take date.'); window.history.back();</script>";
            exit;
        }
        $sql = "INSERT INTO bookings(user_id,Book_id, Book_name, Take_date, Return_date, Status) 
                VALUES ('$user_id','$book_id', '$book_name', '$take_date', '$ret_date', 'Pending')";
        $sql1 = "UPDATE BOOKS SET AVAILABLE = 'No' WHERE id = '$book_id'; ";
    
        if (mysqli_query($con, $sql)) {
            if(mysqli_query($con, $sql1)){
                echo "<script>
                    alert('Book taking request sent');
                    window.history.back();
                    document.getElementById('takeDate').value = ''; 
                </script>";
            exit;
            }
            else{
                echo "<script>alert('Update error: " . mysqli_error($con) . "'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "'); window.history.back();</script>";
            exit;
        }
        
    }
?>
<body>
    <div id="overlay" style="display:none"></div>
    <nav>
        <a href="student.php"><h1>Library Management System</h1></a>
        <a href="Bookings.php"><h4>Manage Bookings</h4></a>
        <a href="logout.php"><h1>Logout</h1></a>
    </nav>
    <div class="displaybooks" id="displaybooks">
        <form class="bookdetails" action="" method="post">
            <input class="search" type="search" name="bookdetail" placeholder="Enter the detail of book to search">
            <input type="submit" name="searchbook" value="Search Book">
            <table border="1" class="displaytable">
                <thead>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Book Author</th>
                    <th>Book Category</th>
                    <th>Book Availability</th>
                    <th>Action</th>
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
                                        if($row['Available'] == "Yes"){
                                            echo "<td><button type='button' onclick='bookingform(" . $row['ID'] . ", \"" .$row['Title'] . "\")'>Take Book</button></td>";
                                        }else   
                                            echo "<td>Book already Taken</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No results found.</td></tr>";
                                }
                            } else {
                                if ($fullresult && mysqli_num_rows($fullresult) > 0) {
                                    while ($row = mysqli_fetch_assoc($fullresult)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['ID'] . "</td>";
                                        echo "<td>" . $row['Title'] . "</td>";
                                        echo "<td>" . $row['Author'] . "</td>";
                                        echo "<td>" . $row['Category'] . "</td>";
                                        echo "<td>" . $row['Available'] . "</td>";
                                        if($row['Available'] == "Yes")
                                            echo "<td><button type='button' onclick='bookingform(" . $row['ID'] . ", \"" .$row['Title'] . "\")'>Take Book</button></td>";
                                        else   
                                            echo "<td>Book not available</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' >No books available.</td></tr>";
                                }
                            }
                        ?>
                </tbody>
            </table>
        </form>
    </div>
    <div id="bookingform" style="display:none">
        <h4 style="text-align: center;">Booking Form</h4>
        <form action="" method="post">
            <table width="100%">
                <tr><td>Book ID</td><td><input type="text" name="bookid" id="bookid" style="width:51%;text-align:center" readonly></td></tr>
                <tr><td>Book Name</td><td><input type="text" id="bname" name="bname" style="width:51%;text-align:center" readonly></td></tr>
                <tr><td>Date</td><td><input type='date' id="takeDate" name="takeDate" onchange="updateReturnDate()"></td></tr>
                <tr><td>Return Date</td><td><input type="date" id="retdate" name="retdate" readonly></td></tr>
                <tr>
                    <td colspan='2'>
                        <div class="buttons">
                            <button type="button" onclick="closeform()">Cancel</button>
                            <input class="takebutton" type="submit" name="Take" value="Take" style="width:100%">
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded',event => {
            const datetime = document.getElementById('takeDate');
            const now = new Date();
            console.log(now);
            const mindate = now.toISOString().split('T')[0];
            datetime.setAttribute('min',mindate);
            datetime.value="";
        });
        function bookingform(bid,title){
            document.getElementById('overlay').style.display='flex';
            document.getElementById('bookingform').style.display='flex';
            document.getElementById('displaybooks').style.display='none';
            bookid = document.getElementById('bookid');
            bookname = document.getElementById('bname');
            bookid.value=bid;
            bookname.value=title;
        }
        function updateReturnDate(){
            takeDateInput = document.getElementById('takeDate');
            retDateLabel = document.getElementById('retdate');
            takeDate = new Date(takeDateInput.value);
            takeDate.setDate(takeDate.getDate() + 7);
            const returnDate = takeDate.toISOString().split('T')[0];
            retDateLabel.value = returnDate;
        }
        function closeform(){
            document.getElementById('overlay').style.display='none';
            document.getElementById('bookingform').style.display='none';
            document.getElementById('displaybooks').style.display='';
        }
    </script>
</body>
</html>