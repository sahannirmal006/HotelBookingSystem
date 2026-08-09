<?php

session_start();

include "../config/db.php";


if(!isset($_SESSION['customer_id'])){

    header("Location: login.php");
    exit();

}


$customer_id = $_SESSION['customer_id'];



if(!isset($_GET['room_id'])){

    header("Location: hotels.php");
    exit();

}


$room_id = $_GET['room_id'];



// Get room details

$result = mysqli_query($conn,

"SELECT 

rooms.*,

hotels.hotel_name

FROM rooms

JOIN hotels

ON rooms.hotel_id = hotels.id

WHERE rooms.id='$room_id'

"

);


$room = mysqli_fetch_assoc($result);




// Get customer details

$customer = mysqli_fetch_assoc(mysqli_query($conn,

"SELECT *

FROM customers

WHERE id='$customer_id'

"

));




// Booking submit

if(isset($_POST['book'])){


$check_in = $_POST['check_in'];

$check_out = $_POST['check_out'];



// calculate nights

$date1 = new DateTime($check_in);

$date2 = new DateTime($check_out);


$nights = $date1->diff($date2)->days;


if($nights <= 0){

    $error="Invalid dates";

}else{


$total = $nights * $room['price'];



mysqli_query($conn,

"INSERT INTO bookings

(customer_id,room_id,check_in,check_out,total_amount,status)

VALUES

('$customer_id',
'$room_id',
'$check_in',
'$check_out',
'$total',
'Pending')

"

);



header("Location: bookings.php");

exit();


}



}



?>



<!DOCTYPE html>

<html>

<head>

<title>Room Booking</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="../assets/style.css" rel="stylesheet">


</head>



<body>


<?php include "../includes/navbar.php"; ?>



<div class="container mt-5">



<div class="card shadow col-md-7 mx-auto">


<div class="card-body">



<h2>

📅 Booking Details

</h2>


<hr>



<h3>

🏨 <?php echo $room['hotel_name']; ?>

</h3>



<h4>

🚪 <?php echo $room['room_type']; ?>

</h4>



<h4>

💰 Rs. <?php echo number_format($room['price']); ?> / Day

</h4>



<?php

if(isset($error)){

echo "<div class='alert alert-danger'>$error</div>";

}

?>



<form method="POST">



<label>

Name

</label>

<input type="text"

class="form-control mb-3"

value="<?php echo $customer['name']; ?>"

readonly>



<label>

Email

</label>

<input type="email"

class="form-control mb-3"

value="<?php echo $customer['email']; ?>"

readonly>



<label>

Phone

</label>

<input type="text"

class="form-control mb-3"

value="<?php echo $customer['phone']; ?>"

readonly>




<label>

Check In

</label>

<input type="date"

name="check_in"

class="form-control mb-3"

required>




<label>

Check Out

</label>

<input type="date"

name="check_out"

class="form-control mb-3"

required>




<button

name="book"

class="btn btn-success w-100">


✅ Confirm Booking


</button>



</form>



</div>

</div>



</div>



</body>

</html>