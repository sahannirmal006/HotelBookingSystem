<?php

session_start();

include "../config/db.php";


// Check login

if(!isset($_SESSION['customer_id'])){

    header("Location: login.php");
    exit();

}


$customer_id = $_SESSION['customer_id'];



// Get customer details

$customer_query = mysqli_query($conn,

"SELECT * FROM customers WHERE id=$customer_id"

);


$customer = mysqli_fetch_assoc($customer_query);




// Get bookings

$booking_query = mysqli_query($conn,


"SELECT 

bookings.*,

rooms.room_type,

rooms.price,

hotels.hotel_name,

hotels.location


FROM bookings


JOIN rooms

ON bookings.room_id = rooms.id


JOIN hotels

ON rooms.hotel_id = hotels.id


WHERE bookings.customer_id=$customer_id"

);



include "../includes/header.php";

include "../includes/navbar.php";


?>


<div class="container mt-5">



<h1>

👤 My Profile

</h1>



<div class="card shadow mt-4">


<div class="card-body">


<h3>

<?php echo $customer['name']; ?>

</h3>


<p>

📧 <?php echo $customer['email']; ?>

</p>


<p>

📞 <?php echo $customer['phone']; ?>

</p>



</div>


</div>





<h2 class="mt-5">

📅 My Bookings

</h2>



<div class="card shadow mt-3">


<div class="card-body">



<table class="table table-bordered table-striped">


<tr>

<th>ID</th>

<th>Hotel</th>

<th>Room</th>

<th>Check In</th>

<th>Check Out</th>

<th>Amount</th>

<th>Status</th>

</tr>



<?php


if(mysqli_num_rows($booking_query)>0){



while($row=mysqli_fetch_assoc($booking_query)){



?>


<tr>


<td>

<?php echo $row['id']; ?>

</td>


<td>

🏨 <?php echo $row['hotel_name']; ?>

<br>

📍 <?php echo $row['location']; ?>

</td>


<td>

<?php echo $row['room_type']; ?>

</td>


<td>

<?php echo $row['check_in']; ?>

</td>


<td>

<?php echo $row['check_out']; ?>

</td>


<td>

Rs. <?php echo $row['total_amount']; ?>

</td>


<td>


<?php


if($row['status']=="Approved"){


?>


<span class="badge bg-success">

Approved

</span>



<?php

}

elseif($row['status']=="Cancelled"){


?>


<span class="badge bg-danger">

Cancelled

</span>


<?php

}

else{


?>


<span class="badge bg-warning">

Pending

</span>


<?php

}


?>


</td>


</tr>


<?php


}


}

else{


?>


<tr>

<td colspan="7" class="text-center">

No bookings found

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