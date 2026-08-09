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



// Total bookings

$total_booking = mysqli_fetch_assoc(mysqli_query($conn,

"
SELECT COUNT(*) AS total

FROM bookings

JOIN rooms

ON bookings.room_id = rooms.id

JOIN hotels

ON rooms.hotel_id = hotels.id

WHERE hotels.owner_id='$owner_id'

"

));



// Paid bookings

$paid_booking = mysqli_fetch_assoc(mysqli_query($conn,

"
SELECT COUNT(*) AS total

FROM bookings

JOIN rooms

ON bookings.room_id = rooms.id

JOIN hotels

ON rooms.hotel_id = hotels.id

WHERE hotels.owner_id='$owner_id'

AND bookings.status='Paid'

"

));




// Pending bookings

$pending_booking = mysqli_fetch_assoc(mysqli_query($conn,

"
SELECT COUNT(*) AS total

FROM bookings

JOIN rooms

ON bookings.room_id = rooms.id

JOIN hotels

ON rooms.hotel_id = hotels.id

WHERE hotels.owner_id='$owner_id'

AND bookings.status='Pending'

"

));




// Revenue

$revenue = mysqli_fetch_assoc(mysqli_query($conn,

"
SELECT SUM(total_amount) AS amount

FROM bookings

JOIN rooms

ON bookings.room_id = rooms.id

JOIN hotels

ON rooms.hotel_id = hotels.id


WHERE hotels.owner_id='$owner_id'

AND bookings.status='Paid'

"

));



$total_revenue = $revenue['amount'] ?? 0;



// Commission

$commission = $total_revenue * 0.15;



// Owner income

$owner_income = $total_revenue - $commission;



?>


<!DOCTYPE html>

<html>

<head>

<title>Revenue Dashboard</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="../assets/style.css" rel="stylesheet">


</head>



<body>



<?php include "../includes/navbar.php"; ?>



<div class="container mt-5">



<h1>

💰 Revenue Dashboard

</h1>


<hr>




<div class="row g-4">



<div class="col-md-3">

<div class="card shadow text-center p-4">


<h5>

📅 Total Bookings

</h5>


<h2>

<?php echo $total_booking['total']; ?>

</h2>


</div>

</div>





<div class="col-md-3">

<div class="card shadow text-center p-4">


<h5>

✅ Paid Bookings

</h5>


<h2 class="text-success">

<?php echo $paid_booking['total']; ?>

</h2>


</div>

</div>





<div class="col-md-3">

<div class="card shadow text-center p-4">


<h5>

⏳ Pending

</h5>


<h2 class="text-warning">

<?php echo $pending_booking['total']; ?>

</h2>


</div>

</div>





<div class="col-md-3">

<div class="card shadow text-center p-4">


<h5>

💳 Revenue

</h5>


<h2>

Rs. <?php echo number_format($total_revenue); ?>

</h2>


</div>

</div>



</div>





<div class="row mt-4">



<div class="col-md-6">


<div class="card shadow p-4 text-center">


<h4>

🏦 Platform Commission (15%)

</h4>


<h2 class="text-danger">

Rs. <?php echo number_format($commission); ?>

</h2>


</div>


</div>





<div class="col-md-6">


<div class="card shadow p-4 text-center">


<h4>

💰 Your Earnings

</h4>


<h2 class="text-success">

Rs. <?php echo number_format($owner_income); ?>

</h2>


</div>


</div>



</div>



</div>



</body>

</html>