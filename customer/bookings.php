<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";


if(!isset($_SESSION['customer_id'])){

    header("Location: login.php");
    exit();

}


$customer_id = $_SESSION['customer_id'];



$sql = "

SELECT 

bookings.*,

rooms.room_type,

hotels.hotel_name


FROM bookings


INNER JOIN rooms

ON bookings.room_id = rooms.id


INNER JOIN hotels

ON rooms.hotel_id = hotels.id


WHERE bookings.customer_id='$customer_id'


ORDER BY bookings.id DESC

";



$result = mysqli_query($conn,$sql);



?>


<!DOCTYPE html>

<html>

<head>

<title>My Bookings</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="../assets/style.css" rel="stylesheet">


</head>



<body>


<?php include "../includes/navbar.php"; ?>



<div class="container mt-5">



<div class="d-flex justify-content-between align-items-center">


<h1>

📅 My Bookings

</h1>



<a href="dashboard.php"

class="btn btn-dark">

⬅ Dashboard

</a>


</div>


<hr>




<div class="row">



<?php


if(mysqli_num_rows($result)>0){



while($booking=mysqli_fetch_assoc($result)){



?>



<div class="col-md-6 mb-4">



<div class="card shadow">



<div class="card-body">



<h3>

🏨 <?php echo htmlspecialchars($booking['hotel_name']); ?>

</h3>



<h5>

🚪 <?php echo htmlspecialchars($booking['room_type']); ?>

</h5>



<hr>



<p>

📅 Check In:

<strong>

<?php echo $booking['check_in']; ?>

</strong>

</p>



<p>

📅 Check Out:

<strong>

<?php echo $booking['check_out']; ?>

</strong>

</p>



<h5>

💰 Rs. <?php echo number_format($booking['total_amount']); ?>

</h5>




<p>

Status:

<?php


if($booking['status']=="Paid"){


echo '

<span class="badge bg-success">

✅ Paid

</span>';



}

elseif($booking['status']=="Confirmed"){


echo '

<span class="badge bg-primary">

✔ Confirmed

</span>';



}

else{


echo '

<span class="badge bg-warning">

⏳ '.$booking['status'].'

</span>';



}



?>


</p>




<?php if($booking['status']=="Confirmed"){ ?>


<a href="payment.php?id=<?php echo $booking['id']; ?>"

class="btn btn-success w-100">


💳 Pay Now


</a>



<?php } ?>




</div>


</div>


</div>



<?php


}


}else{


?>



<div class="alert alert-warning text-center">


<h4>

📅 No Bookings Found

</h4>


<p>

You haven't made any bookings yet.

</p>


<a href="hotels.php" class="btn btn-primary">

🏨 Browse Hotels

</a>


</div>



<?php


}


?>



</div>



</div>



</body>

</html>