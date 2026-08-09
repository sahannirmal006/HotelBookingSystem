<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";


if(!isset($_SESSION['customer_id'])){

    header("Location: login.php");
    exit();

}


$name = $_SESSION['customer_name'];

?>


<!DOCTYPE html>

<html>

<head>

<title>Customer Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body class="bg-light">


<div class="container mt-5">


<div class="card shadow">


<div class="card-body text-center">


<h1>

👤 Welcome <?php echo $name; ?>

</h1>


<p class="lead">

Welcome to Hotel Booking System

</p>



<a href="hotels.php"

class="btn btn-primary">

🏨 Browse Hotels

</a>



<a href="bookings.php"

class="btn btn-success">

📅 My Bookings

</a>



<a href="logout.php"

class="btn btn-danger">

🚪 Logout

</a>



</div>


</div>


</div>



</body>

</html>