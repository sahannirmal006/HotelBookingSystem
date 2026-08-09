<?php

include "../config/db.php";


$id = $_GET['id'];


// Get hotel data

$result = mysqli_query($conn,"SELECT * FROM hotels WHERE id=$id");

$hotel = mysqli_fetch_assoc($result);



if(isset($_POST['update'])){


$name = $_POST['hotel_name'];

$location = $_POST['location'];

$description = $_POST['description'];



$sql = "UPDATE hotels SET

hotel_name='$name',

location='$location',

description='$description'

WHERE id=$id";



mysqli_query($conn,$sql);



header("Location: hotels.php");

exit();


}


?>



<!DOCTYPE html>
<html>

<head>

<title>Edit Hotel</title>

</head>


<body>


<h1>Edit Hotel</h1>



<form method="POST">


Hotel Name:

<br>

<input 
type="text" 
name="hotel_name"
value="<?php echo $hotel['hotel_name']; ?>"
required>


<br><br>



Location:

<br>

<input 
type="text"
name="location"
value="<?php echo $hotel['location']; ?>"
required>


<br><br>



Description:

<br>

<textarea name="description">

<?php echo $hotel['description']; ?>

</textarea>



<br><br>



<button name="update">

Update Hotel

</button>



</form>


<br>


<a href="hotels.php">
Back
</a>



</body>

</html>