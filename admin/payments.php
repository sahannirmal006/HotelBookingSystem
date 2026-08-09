<?php

session_start();

include "../config/db.php";


if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}


include "../includes/header.php";

?>



<div class="container-fluid">

<div class="row">


<div class="col-md-3 bg-dark vh-100">


<h3 class="text-white text-center mt-3">
🏨 Admin Panel
</h3>


<hr class="text-white">


<a href="dashboard.php" class="btn btn-dark text-white w-100">
Dashboard
</a>


<a href="hotels.php" class="btn btn-dark text-white w-100">
🏨 Hotels
</a>


<a href="rooms.php" class="btn btn-dark text-white w-100">
🚪 Rooms
</a>


<a href="bookings.php" class="btn btn-dark text-white w-100">
📅 Bookings
</a>


<a href="payments.php" class="btn btn-primary w-100">
💳 Payments
</a>


<a href="logout.php" class="btn btn-danger w-100 mt-3">
Logout
</a>


</div>





<div class="col-md-9 p-5">


<h1>
💳 Payment Management
</h1>




<table class="table table-bordered table-striped mt-4">


<tr>

<th>ID</th>
<th>Customer</th>
<th>Hotel</th>
<th>Room</th>
<th>Amount</th>
<th>Date</th>
<th>Status</th>

</tr>



<?php


$result=mysqli_query($conn,


"SELECT payments.*,

customers.name,

hotels.hotel_name,

rooms.room_type


FROM payments


JOIN bookings

ON payments.booking_id=bookings.id


JOIN customers

ON bookings.customer_id=customers.id


JOIN rooms

ON bookings.room_id=rooms.id


JOIN hotels

ON rooms.hotel_id=hotels.id"

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
Rs. <?php echo number_format($row['amount']); ?>
</td>


<td>
<?php echo $row['payment_date']; ?>
</td>


<td>

<span class="badge bg-success">

<?php echo $row['payment_status']; ?>

</span>

</td>


</tr>



<?php

}

?>


</table>


</div>


</div>


</div>


<?php

include "../includes/footer.php";

?>