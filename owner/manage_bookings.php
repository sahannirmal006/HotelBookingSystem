<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";


if(!isset($_SESSION['owner_id'])){

    header("Location: login.php");
    exit();

}


$owner_id = $_SESSION['owner_id'];



$sql = "

SELECT 

bookings.id,
bookings.check_in,
bookings.check_out,
bookings.total_amount,
bookings.status,

customers.name AS customer_name,

hotels.hotel_name,

rooms.room_type


FROM bookings


INNER JOIN rooms

ON bookings.room_id = rooms.id


INNER JOIN hotels

ON rooms.hotel_id = hotels.id


INNER JOIN customers

ON bookings.customer_id = customers.id



WHERE hotels.owner_id='$owner_id'


ORDER BY bookings.id DESC

";



$result = mysqli_query($conn,$sql);



if(!$result){

    die(mysqli_error($conn));

}


?>



<!DOCTYPE html>

<html>

<head>

<title>Manage Bookings</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>



<body class="bg-light">



<div class="container mt-5">


<h1>

📅 Manage Customer Bookings

</h1>


<hr>




<table class="table table-bordered table-striped">



<thead class="table-dark">


<tr>

<th>Customer</th>

<th>Hotel</th>

<th>Room</th>

<th>Check In</th>

<th>Check Out</th>

<th>Amount</th>

<th>Status</th>

<th>Action</th>

</tr>


</thead>



<tbody>



<?php


if(mysqli_num_rows($result)>0){


while($booking = mysqli_fetch_assoc($result)){


?>



<tr>


<td>

👤 <?php echo $booking['customer_name']; ?>

</td>



<td>

🏨 <?php echo $booking['hotel_name']; ?>

</td>



<td>

🚪 <?php echo $booking['room_type']; ?>

</td>



<td>

<?php echo $booking['check_in']; ?>

</td>



<td>

<?php echo $booking['check_out']; ?>

</td>



<td>

Rs. <?php echo number_format($booking['total_amount']); ?>

</td>



<td>


<?php


if($booking['status']=="Confirmed"){


echo '<span class="badge bg-success">

✅ Confirmed

</span>';


}

elseif($booking['status']=="Rejected"){


echo '<span class="badge bg-danger">

❌ Rejected

</span>';


}

else{


echo '<span class="badge bg-warning">

⏳ Pending

</span>';


}


?>


</td>



<td>


<a href="update_booking.php?id=<?php echo $booking['id']; ?>&status=Confirmed"

class="btn btn-success btn-sm">


✅ Confirm


</a>



<a href="update_booking.php?id=<?php echo $booking['id']; ?>&status=Rejected"

class="btn btn-danger btn-sm">


❌ Reject


</a>



</td>



</tr>



<?php


}


}else{


?>


<tr>

<td colspan="8" class="text-center">

No bookings found

</td>

</tr>


<?php


}


?>



</tbody>


</table>



</div>



</body>

</html>