<html>
<body  style='height:1000px;background-color: coral; display:flex;flex-direction:column;align-items: center'>
<form method='POST' action=' '>

<h1 style=' margin-top: 25px'>Student details</h1><br>
<br>

<input type='text' placeholder="Roll No" name='rollno'><br><br>

<input type='text' placeholder="Name" name='sname'><br><br>

<input type='number' placeholder="Marks" name='mark' ><br><br>
<input type='submit' name='insert' value='INSERT'>
<input type='submit' name='select' value='SELECT'>
<input type='submit' name='delete' value='DELETE'>
<input type='submit' name='update' value='UPDATE'>
<input type='submit' name='search' value='SEARCH'>

</body>

</html>


<?php
if(isset($_POST['insert']))
{
$rno=$_POST['rollno'];
$nam=$_POST['sname'];
$mark=$_POST['mark'];
$con=mysqli_connect("localhost","root","","student");
if(!$con)
die("Connection failed".mysqli_connect_error());
$sql="insert into student values($rno,'$nam',$mark)";
try
{
if(mysqli_query($con,$sql))
echo"</br>Inserted Successfully";
else echo" </br>Error in inserting";

}

catch(Exception $e)
{
echo "</br></br> Enter the values in textbox to  insert";
}
mysqli_close($con);
}




if(isset($_POST['select']))
{

$con=mysqli_connect("localhost","root","","student");
if(!$con)
die("Connection failed".mysqli_connect_error());
$sql="select RollNo,Name,Marks from student";
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0)
{
echo"</br></br></br>Selected Details Are ";
while($row=mysqli_fetch_assoc($result))
echo"</br></br>Rollno:".$row["RollNo"]."</br>Name:".$row["Name"]."</br>Marks:".$row["Marks"]."<br>";
}
else echo"</br>0 Results";
mysqli_close($con);
}




if(isset($_POST['delete']))
{

$rno=$_POST['rollno'];

$con=mysqli_connect("localhost","root","","student");
if(!$con)
die("Connection failed".mysqli_connect_error());
$sql="delete from student where RollNo=$rno";
try
{
mysqli_query($con,$sql);
if(mysqli_affected_rows($con))
echo"</br>Deleted Successfully";
else echo"</br>Deletion Failed";
}
catch(Exception $e)
{
echo "</br></br> Enter the id of student to be deleted";
}

mysqli_close($con);
}






if(isset($_POST['update']))
{
$rno=$_POST['rollno'];
$nam=$_POST['sname'];
$mark=$_POST['mark'];
$con=mysqli_connect("localhost","root","","student");
if(!$con)
die("Connectionfailed".mysqli_connect_error());
$sql="update student set Name='$nam',Marks=$mark where RollNo=$rno";
try
{
mysqli_query($con,$sql);
if(mysqli_affected_rows($con))
echo"</br>Updated Successfully";
else echo"</br>Error in Updating";
}
catch(Exception $e)
{
 echo"</br>Error in Updating";
}
mysqli_close($con);
}






if(isset($_POST['search']))
{
$rno=$_POST['rollno'];
$nam=$_POST['sname'];
$mark=$_POST['mark'];
$con=mysqli_connect("localhost","root","","student");
if(!$con)
die("Connection failed".mysqli_connect_error());
$sql="select RollNo,Name,Marks from student where RollNo=$rno";

try
{
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0)
{
while($row=mysqli_fetch_assoc($result))
echo"</br></br></br>Details of Roll No: ".$row["RollNo"]." are  </br></br>Rollno:".$row["RollNo"]."</br>Name:".$row["Name"]."</br>Marks:".$row["Marks"];
}
else echo"</br>0 Results";
}
catch(Exception $e)
{
echo "<br></br>Enter id of student to be Searched in text box";
}
mysqli_close($con);
}
?>