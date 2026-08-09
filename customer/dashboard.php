<?php

session_start();


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


<hr>


<h3>

🏨 Hotel Booking System

</h3>


<p class="text-muted">

Find your perfect hotel and book your room easily.

</p>



<a href="hotels.php" class="btn btn-primary">

🏨 Browse Hotels

</a>



<a href="bookings.php" class="btn btn-success">

📅 My Bookings

</a>



<a href="logout.php" class="btn btn-danger">

🚪 Logout

</a>



</div>


</div>


</div>


</body>

</html>