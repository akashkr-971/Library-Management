<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Bookings</title>
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
            margin: 0;
        }
        
        nav {
            display: flex;
            position: absolute;
            top: 0;
            align-items:center;
            justify-content: space-evenly;
            width: 100%;
            background-color: rgb(36, 242, 132);
            color: black;
            height:50px;
        }
        
        nav h1 {
            font-size: 24px;
            color: black;
            margin: 0;
        }

        nav a {
            text-decoration: none;
            color: black;
            font-size: 18px;
        }

        .displaybookings {
            margin-top: 80px;
            width: 80%;
            max-width: 1000px;
            background-color: rgb(52, 73, 94);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            overflow: auto;
        }

        form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 75%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            color: #333;
        }

        input[type="submit"] ,input[type="button"]{
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #36f213;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #28a745;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
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

        @media (max-width: 768px) {
            .displaybookings {
                width: 95%;
                margin-top: 20px;
            }
            input[type="text"], input[type="submit"] {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
    $con = mysqli_connect("localhost", "root", "", "library");
    if (!$con) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    $bookings_result = null;
    if (isset($_POST['searchbooking'])) {
        $booking_detail = trim($_POST['bookingdetail']);
        $sql = "SELECT * FROM bookings  WHERE user_id = '$user_id' AND (Booking_id LIKE '%$booking_detail%' OR Book_id LIKE '%$booking_detail%' OR Take_date LIKE '%$booking_detail%')";
    } else {
        $sql = "SELECT * FROM bookings";
    }
    try {
        $bookings_result = mysqli_query($con, $sql);
    } catch (Exception $e) {
        echo $e;
    }

    if (isset($_POST['acceptbookbutton'])) {
        $bookngid = $_POST['bkngid'];
        echo "<script>console.log('$bookngid')</script>";
        $sql = "UPDATE bookings SET Status = 'Accepted' WHERE Booking_id = '$bookngid'";
        mysqli_query($con, $sql);
        header("Location: adminbooking.php");
    }
    if (isset($_POST['returnedbook'])) {
        $bookngid = $_POST['bkngid']; 
        $bkid = $_POST['bkid']; 
        echo "<script>console.log('$bookngid')</script>";
        $sql = "UPDATE bookings SET Status = 'Completed' WHERE Booking_id = '$bookngid'";
        $sql1 = "UPDATE books SET Available='Yes' WHERE id='$bkid'; ";
        mysqli_query($con, $sql);
        mysqli_query($con, $sql1);
        header("Location: adminbooking.php");
    }
    
?>

<body>
    <nav>
        <a href="Books.php"><h1>Library Management System</h1></a>
        <a href="logout.php"><h1>Logout</h1></a>
    </nav>

    <div class="displaybookings">
        <form action="" method="post">
            <input type="text" name="bookingdetail" placeholder="Search booking by ID, Book ID or Date">
            <input type="submit" name="searchbooking" value="Search Bookings">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Book ID</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($bookings_result && mysqli_num_rows($bookings_result) > 0) {
                        while ($row = mysqli_fetch_assoc($bookings_result)) {
                            echo "<tr>";
                            echo "<td>" .$row['Booking_id'] . "</td>";
                            echo "<td>" .$row['Book_id'] . "</td>";
                            echo "<td>" .$row['Take_date'] . "</td>";
                            echo "<td>" .$row['Status'] . "</td>";
                            echo "<form action='' method='post'>";
                            echo "<input type='hidden' name='bkngid' value='" . $row['Booking_id'] . "'>";
                            echo "<input type='hidden' name='bkid' value='" . $row['Book_id'] . "'>";
                            
                            if ($row['Status'] == "Pending") {
                                echo "<td><input type='submit' name='acceptbookbutton' value='Accept'></td>";
                            } elseif ($row['Status'] == "Accepted") {
                                echo "<td><Label>Accepted</Label></td>";
                            }elseif ($row['Status'] == "Returned") {
                                echo "<td><input type='submit' name='returnedbook' value='Returned Book'></td>";
                            }elseif ($row['Status'] == "Cancelled") {
                                echo "<td><Label>Cancelled</Label></td>";
                            }else {
                                echo "<td><Label>Completed</Label></td>";
                            }
                            
                            echo "</form>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No bookings found.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>