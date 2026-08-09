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



if(!isset($_GET['id'])){

    header("Location: bookings.php");
    exit();

}


$booking_id = $_GET['id'];



// Get booking details

$result = mysqli_query($conn,

"SELECT 

bookings.*,

rooms.room_type,

hotels.hotel_name


FROM bookings


INNER JOIN rooms

ON bookings.room_id = rooms.id


INNER JOIN hotels

ON rooms.hotel_id = hotels.id


WHERE bookings.id='$booking_id'

AND bookings.customer_id='$customer_id'

"

);



$booking = mysqli_fetch_assoc($result);



if(!$booking){

    echo "Booking not found";

    exit();

}




// Payment submit

if(isset($_POST['pay'])){


$method = $_POST['method'];



mysqli_query($conn,

"UPDATE bookings

SET 

status='Paid',

payment_method='$method'

WHERE id='$booking_id'

"

);



?>



<script>

alert("Payment Successful 🎉");

window.location="bookings.php";

</script>



<?php

exit();

}



?>



<!DOCTYPE html>

<html>

<head>


<title>Payment</title>


<meta charset="UTF-8">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="../assets/style.css" rel="stylesheet">


</head>



<body>


<?php include "../includes/navbar.php"; ?>



<div class="container mt-5">



<div class="card shadow col-md-6 mx-auto">


<div class="card-body">



<h2 class="text-center">

💳 Payment

</h2>


<hr>



<h4>

🏨 <?php echo htmlspecialchars($booking['hotel_name']); ?>

</h4>



<p>

🚪 Room:

<strong>

<?php echo htmlspecialchars($booking['room_type']); ?>

</strong>

</p>




<p>

📅 Check In:

<?php echo $booking['check_in']; ?>

</p>



<p>

📅 Check Out:

<?php echo $booking['check_out']; ?>

</p>



<h3>

💰 Rs. <?php echo number_format($booking['total_amount']); ?>

</h3>



<hr>



<?php if($booking['status']=="Paid"){ ?>


<div class="alert alert-success text-center">

✅ Payment Already Completed

</div>



<a href="bookings.php" class="btn btn-primary w-100">

⬅ My Bookings

</a>



<?php }else{ ?>



<form method="POST">



<label class="mb-2">

Payment Method

</label>



<select name="method" class="form-control mb-3" required>


<option value="Card Payment">

💳 Card Payment

</option>


<option value="Bank Transfer">

🏦 Bank Transfer

</option>


<option value="Cash Payment">

💵 Cash Payment

</option>


</select>




<button name="pay"

class="btn btn-success w-100">


✅ Confirm Payment


</button>



</form>



<?php } ?>



</div>


</div>


</div>



</body>

</html>