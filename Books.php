<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reg form</title>
    <style>
        body{
            background-color: rgb(31, 49, 20);
            color: rgb(255, 238, 0);
            font-family: Georgia, 'Times New Roman', Times, serif;            
            display: flex;
            justify-content: center;
            align-items: center;
            height: 95vh;
        }
        form{
            border: 10px solid red;
            padding: 20px;
        }
    </style>
</head>
<body>
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
                    <td colspan="2"><label for="">Book ID : </label></td>
                    <td colspan="2"><input type="text" name="rno"></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="">Book Name : </label></td>
                    <td colspan="2"><input type="text" name="name"></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="">Book Author : </label></td>
                    <td colspan="2"><input type="text" name="aname"></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="">Category : </label></td>
                    <td colspan="2">
                        <input type="radio" name="category" value="action"> Action  
                        <input type="radio" name="category" value="adventure"> Adventure <br>
                        <input type="radio" name="category" value="thriller"> Thriller 
                        <input type="radio" name="category" value="romance"> Romance <br>
                        <input type="radio" name="category" value="horror"> Horror
                        <input type="radio" name="category" value="Sciencefiction"> Science Fiction
                    </td>
                </tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr>
                    <td colspan="4">
                        <input type="submit" name="insert" value="INSERT">
                        <input type="submit" name="update" value="UPDATE">
                        <input type="submit" name="delete" value="DELETE">
                        <input type="submit" name="display" value="DISPLAY">
                        <input type="submit" name="search" value="SEARCH">
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
    $id = $_POST['rno'];
    $name = $_POST['name'];
    $aname = $_POST['aname'];
    $category = $_POST['category'];
    $con=mysqli_connect("localhost","root","","library");
    if(!con)
    die("Connection Failed ".mysqli_connect_error());
    $sql="insert into Books values ($id,$name,$aname,$category)";
    try{
        if (mysqli_query($con,$sql)){
            echo "<br>Inserted Successfully!!!";
        }
        else{
            echo "<br>Insertion Failed!!!";
        }
    }
    catch(Exception $e)
    {
    echo "</br></br> Enter the values in textbox to  insert";
    }
    mysqli_close($con);
}
?>
