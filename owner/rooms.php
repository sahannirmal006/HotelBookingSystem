<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";


if(!isset($_SESSION['owner_id'])){

    header("Location: login.php");
    exit();

}


$owner_id = $_SESSION['owner_id'];



$hotel_id = isset($_GET['hotel_id']) ? $_GET['hotel_id'] : "";



if($hotel_id != ""){


$sql = "

SELECT rooms.*, hotels.hotel_name

FROM rooms

INNER JOIN hotels

ON rooms.hotel_id = hotels.id

WHERE hotels.owner_id='$owner_id'

AND hotels.id='$hotel_id'

ORDER BY rooms.id DESC

";


}else{


$sql = "

SELECT rooms.*, hotels.hotel_name

FROM rooms

INNER JOIN hotels

ON rooms.hotel_id = hotels.id

WHERE hotels.owner_id='$owner_id'

ORDER BY rooms.id DESC

";


}



$result = mysqli_query($conn,$sql);



?>


<!DOCTYPE html>

<html>

<head>

<title>My Rooms</title>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body class="bg-light">



<div class="container-fluid">


<div class="row">



<!-- Sidebar -->

<div class="col-md-3 bg-dark text-white min-vh-100 p-4">


<h3 class="text-center mb-4">

🏨 Owner Panel

</h3>


<hr>


<a href="dashboard.php"
class="btn btn-dark text-white w-100 mb-2">

📊 Dashboard

</a>



<a href="hotels.php"
class="btn btn-dark text-white w-100 mb-2">

🏨 My Hotels

</a>



<a href="rooms.php"
class="btn btn-primary w-100 mb-2">

🚪 My Rooms

</a>



<a href="bookings.php"
class="btn btn-dark text-white w-100 mb-2">

📅 Customer Bookings

</a>



<a href="revenue.php"
class="btn btn-dark text-white w-100 mb-2">

💰 Revenue

</a>



<a href="logout.php"
class="btn btn-danger w-100 mt-3">

🚪 Logout

</a>



</div>




<!-- Main -->


<div class="col-md-9 p-5">


<div class="d-flex justify-content-between align-items-center">


<h1>

🚪 My Rooms

</h1>


<a href="add_room.php"
class="btn btn-success">

➕ Add Room

</a>


</div>



<hr>



<?php if($hotel_id!=""){ ?>


<div class="alert alert-info">

Showing rooms for selected hotel.


<a href="rooms.php"
class="btn btn-sm btn-dark ms-2">

Show All Rooms

</a>


</div>


<?php } ?>





<div class="row mt-4">



<?php


if(mysqli_num_rows($result)>0){



while($room=mysqli_fetch_assoc($result)){



?>



<div class="col-md-4 mb-4">


<div class="card shadow h-100">



<?php if(!empty($room['image'])){ ?>


<img

src="../uploads/rooms/<?php echo $room['image']; ?>"

class="card-img-top"

style="height:220px;object-fit:cover;"

>


<?php }else{ ?>


<div class="bg-secondary text-white d-flex align-items-center justify-content-center"

style="height:220px;">


🚪 No Image


</div>


<?php } ?>





<div class="card-body">



<h4>

🚪 <?php echo $room['room_type']; ?>

</h4>




<p>

🏨 <strong>

<?php echo $room['hotel_name']; ?>

</strong>


</p>




<p>

💰 Rs.

<?php echo number_format($room['price']); ?>


</p>





<?php


if($room['status']=="Available"){


echo '<span class="badge bg-success">
✅ Available
</span>';



}elseif($room['status']=="Booked"){


echo '<span class="badge bg-danger">
🔴 Booked
</span>';



}else{


echo '<span class="badge bg-warning">
'.$room['status'].'
</span>';

}


?>



</div>





<div class="card-footer">


<a href="edit_room.php?id=<?php echo $room['id']; ?>"

class="btn btn-warning btn-sm">

✏️ Edit

</a>




<a href="delete_room.php?id=<?php echo $room['id']; ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Delete this room?');">


🗑️ Delete


</a>



</div>



</div>


</div>




<?php


}


}else{


?>


<div class="alert alert-warning text-center">


<h4>

🚪 No Rooms Found

</h4>


<p>

You haven't added any rooms yet.

</p>



<a href="add_room.php"

class="btn btn-success">

➕ Add Your First Room

</a>



</div>



<?php


}


?>



</div>



</div>



</div>


</div>



</body>

</html>