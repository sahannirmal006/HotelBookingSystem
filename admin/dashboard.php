<?php

session_start();

include "../config/db.php";


if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}


include "../includes/header.php";


// Statistics


$hotels = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM hotels"
))['total'];



$rooms = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM rooms"
))['total'];



$customers = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM customers"
))['total'];



$bookings = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM bookings"
))['total'];




// Revenue

$revenue = mysqli_fetch_assoc(mysqli_query($conn,

"SELECT SUM(amount) total FROM payments"

))['total'];


if(!$revenue){

    $revenue=0;

}




// Booking status


$pending = mysqli_fetch_assoc(mysqli_query($conn,

"SELECT COUNT(*) total FROM bookings WHERE status='Pending'"

))['total'];



$confirmed = mysqli_fetch_assoc(mysqli_query($conn,

"SELECT COUNT(*) total FROM bookings WHERE status='Confirmed'"

))['total'];



$paid = mysqli_fetch_assoc(mysqli_query($conn,

"SELECT COUNT(*) total FROM bookings WHERE status='Paid'"

))['total'];





?>


<!DOCTYPE html>

<html>

<head>

<title>Admin Dashboard</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>


<body class="bg-light">



<div class="container-fluid">


<div class="row">



<!-- Sidebar -->

<div class="col-md-3 bg-dark vh-100 p-4">


<h3 class="text-white text-center">

🏨 Admin Panel

</h3>


<hr class="text-white">



<a href="dashboard.php"

class="btn btn-primary w-100 mb-2">

📊 Dashboard

</a>


<a href="hotels.php"

class="btn btn-dark text-white w-100 mb-2">

🏨 Hotels

</a>


<a href="rooms.php"

class="btn btn-dark text-white w-100 mb-2">

🚪 Rooms

</a>


<a href="customers.php"

class="btn btn-dark text-white w-100 mb-2">

👤 Customers

</a>


<a href="bookings.php"

class="btn btn-dark text-white w-100 mb-2">

📅 Bookings

</a>


<a href="payments.php"

class="btn btn-dark text-white w-100 mb-2">

💳 Payments

</a>



<a href="logout.php"

class="btn btn-danger w-100 mt-3">

Logout

</a>



</div>





<!-- Content -->

<div class="col-md-9 p-5">


<h1>

📊 Admin Dashboard

</h1>


<hr>




<div class="row g-4">



<div class="col-md-4">

<div class="card shadow p-3">

<h5>

🏨 Hotels

</h5>

<h2>

<?php echo $hotels; ?>

</h2>

</div>

</div>





<div class="col-md-4">

<div class="card shadow p-3">

<h5>

🚪 Rooms

</h5>

<h2>

<?php echo $rooms; ?>

</h2>

</div>

</div>





<div class="col-md-4">

<div class="card shadow p-3">

<h5>

👤 Customers

</h5>

<h2>

<?php echo $customers; ?>

</h2>

</div>

</div>





<div class="col-md-6">

<div class="card shadow bg-success text-white p-3">


<h5>

💰 Total Revenue

</h5>


<h2>

Rs. <?php echo number_format($revenue); ?>

</h2>


</div>

</div>




<div class="col-md-6">

<div class="card shadow bg-primary text-white p-3">


<h5>

📅 Total Bookings

</h5>


<h2>

<?php echo $bookings; ?>

</h2>


</div>

</div>



</div>





<div class="row mt-5">


<div class="col-md-6">


<div class="card shadow">


<div class="card-body">


<h4>

📅 Booking Status

</h4>


<canvas id="bookingChart"></canvas>


</div>


</div>


</div>





<div class="col-md-6">


<div class="card shadow">


<div class="card-body">


<h4>

💰 Revenue

</h4>


<canvas id="revenueChart"></canvas>


</div>


</div>


</div>


</div>



</div>


</div>


</div>





<script>


new Chart(

document.getElementById('bookingChart'),

{

type:'doughnut',

data:{


labels:[

'Pending',

'Confirmed',

'Paid'

],


datasets:[{

data:[

<?php echo $pending; ?>,

<?php echo $confirmed; ?>,

<?php echo $paid; ?>

]


}]


}


}

);






new Chart(

document.getElementById('revenueChart'),

{


type:'bar',

data:{


labels:[

'Revenue'

],


datasets:[{

label:'Rs.',

data:[

<?php echo $revenue; ?>

]


}]


}


}


);



</script>



</body>

</html>