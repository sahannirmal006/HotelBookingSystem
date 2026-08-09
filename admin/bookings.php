<?php

session_start();

include "../config/db.php";


if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}



// Update Status

if(isset($_POST['update_status'])){


    $booking_id=$_POST['booking_id'];

    $status=$_POST['status'];



    mysqli_query($conn,


    "UPDATE bookings

    SET status='$status'

    WHERE id=$booking_id"

    );


    header("Location: bookings.php");

    exit();

}



include "../includes/header.php";


?>



<div class="container-fluid">


<div class="row">



<!-- Sidebar -->


<div class="col-md-3 bg-dark vh-100 p-3">


<h3 class="text-white text-center">

🏨 Admin Panel

</h3>


<hr class="text-white">



<a href="dashboard.php"

class="btn btn-dark text-white w-100 mb-2">

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



<a href="bookings.php"

class="btn btn-primary w-100 mb-2">

📅 Bookings

</a>



<a href="payments.php"

class="btn btn-dark text-white w-100 mb-2">

💳 Payments

</a>



<a href="logout.php"

class="btn btn-danger w-100">

Logout

</a>



</div>







<!-- Content -->


<div class="col-md-9 p-5">


<h1>

📅 Booking Management

</h1>




<div class="card shadow mt-4">


<div class="card-body">



<table class="table table-bordered table-striped">


<tr>

<th>ID</th>

<th>Customer</th>

<th>Hotel</th>

<th>Room</th>

<th>Amount</th>

<th>Date</th>

<th>Status</th>

<th>Action</th>

</tr>



<?php



$result=mysqli_query($conn,


"SELECT bookings.*,

customers.name,

hotels.hotel_name,

rooms.room_type


FROM bookings


JOIN customers

ON bookings.customer_id=customers.id



JOIN rooms

ON bookings.room_id=rooms.id



JOIN hotels

ON rooms.hotel_id=hotels.id



ORDER BY bookings.id DESC"

);





while($row=mysqli_fetch_assoc($result)){



?>



<tr>


<td>

<?php echo $row['id']; ?>

</td>



<td>

<?php echo $row['name']; ?>

</td>



<td>

<?php echo $row['hotel_name']; ?>

</td>



<td>

<?php echo $row['room_type']; ?>

</td>



<td>

Rs. <?php echo number_format($row['total_amount']); ?>

</td>



<td>

<?php echo $row['created_at']; ?>

</td>



<td>


<form method="POST">


<input type="hidden"

name="booking_id"

value="<?php echo $row['id']; ?>">



<select name="status"

class="form-control">


<option <?php if($row['status']=="Pending") echo "selected"; ?>>

Pending

</option>


<option <?php if($row['status']=="Confirmed") echo "selected"; ?>>

Confirmed

</option>


<option <?php if($row['status']=="Checked-in") echo "selected"; ?>>

Checked-in

</option>


<option <?php if($row['status']=="Completed") echo "selected"; ?>>

Completed

</option>


<option <?php if($row['status']=="Cancelled") echo "selected"; ?>>

Cancelled

</option>



</select>



</td>



<td>


<button class="btn btn-success btn-sm"

name="update_status">

Update

</button>


</form>


</td>


</tr>



<?php

}

?>



</table>



</div>

</div>



</div>



</div>



</div>



<?php

include "../includes/footer.php";

?>