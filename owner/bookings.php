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



// Confirm / Reject Booking

if(isset($_GET['action']) && isset($_GET['id'])){


    $booking_id = $_GET['id'];

    $action = $_GET['action'];



    if($action=="confirm"){



        // Update booking status

        mysqli_query($conn,

        "UPDATE bookings

        SET status='Confirmed'

        WHERE id='$booking_id'

        ");



        // Get room id

        $room = mysqli_fetch_assoc(mysqli_query($conn,

        "SELECT room_id 

        FROM bookings 

        WHERE id='$booking_id'

        "));


        $room_id = $room['room_id'];



        // Update room status

        mysqli_query($conn,

        "UPDATE rooms

        SET status='Booked'

        WHERE id='$room_id'

        ");



    }



    if($action=="reject"){


        mysqli_query($conn,

        "UPDATE bookings

        SET status='Rejected'

        WHERE id='$booking_id'

        ");


    }



    header("Location: bookings.php");

    exit();


}





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



$result=mysqli_query($conn,$sql);



?>



<!DOCTYPE html>

<html>

<head>

<title>Customer Bookings</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="../assets/style.css" rel="stylesheet">


</head>


<body>


<?php include "../includes/navbar.php"; ?>



<div class="container mt-5">



<h1>

📅 Customer Bookings

</h1>


<hr>




<table class="table table-bordered table-hover shadow">



<tr class="table-dark">


<th>Customer</th>

<th>Hotel</th>

<th>Room</th>

<th>Check In</th>

<th>Check Out</th>

<th>Amount</th>

<th>Status</th>

<th>Action</th>


</tr>



<?php



if(mysqli_num_rows($result)>0){



while($booking=mysqli_fetch_assoc($result)){



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

💰 Rs. <?php echo number_format($booking['total_amount']); ?>

</td>



<td>


<?php


if($booking['status']=="Paid"){


echo "<span class='badge bg-success'>💰 Paid</span>";


}

elseif($booking['status']=="Confirmed"){


echo "<span class='badge bg-primary'>✅ Confirmed</span>";


}

elseif($booking['status']=="Rejected"){


echo "<span class='badge bg-danger'>❌ Rejected</span>";


}

else{


echo "<span class='badge bg-warning'>⏳ Pending</span>";


}



?>



</td>



<td>



<?php if($booking['status']=="Pending"){ ?>


<a href="bookings.php?action=confirm&id=<?php echo $booking['id']; ?>"

class="btn btn-success btn-sm">

✅ Confirm

</a>



<a href="bookings.php?action=reject&id=<?php echo $booking['id']; ?>"

class="btn btn-danger btn-sm">

❌ Reject

</a>



<?php }else{ ?>


-

<?php } ?>



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



</table>



</div>



</body>

</html>