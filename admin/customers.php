<?php

session_start();

include "../config/db.php";


if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}


?>


<!DOCTYPE html>
<html>

<head>

<title>Customers</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<style>

.sidebar{

height:100vh;
background:#212529;
padding-top:20px;

}

.sidebar a{

display:block;
padding:15px;
color:white;
text-decoration:none;

}

.sidebar a:hover{

background:#0d6efd;

}

</style>


</head>


<body>


<div class="container-fluid">

<div class="row">



<!-- Sidebar -->

<div class="col-md-3 sidebar">


<h3 class="text-white text-center">

🏨 Admin Panel

</h3>


<hr class="text-white">


<a href="dashboard.php">
Dashboard
</a>


<a href="hotels.php">
🏨 Hotels
</a>


<a href="rooms.php">
🚪 Rooms
</a>


<a href="customers.php">
👤 Customers
</a>


<a href="bookings.php">
📅 Bookings
</a>


<a href="payments.php">
💳 Payments
</a>


<a href="logout.php">
Logout
</a>


</div>





<!-- Content -->


<div class="col-md-9 p-5">


<h1>

👤 Customers Management

</h1>



<div class="card shadow mt-4">


<div class="card-body">



<table class="table table-bordered table-striped">


<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Phone</th>

<th>Date Joined</th>

</tr>



<?php


$result=mysqli_query($conn,

"SELECT * FROM customers"

);



if(mysqli_num_rows($result)>0){


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

<?php echo $row['email']; ?>

</td>


<td>

<?php echo $row['phone']; ?>

</td>


<td>

<?php echo $row['created_at'] ?? '-'; ?>

</td>


</tr>


<?php

}

}

else{


echo "

<tr>

<td colspan='5' class='text-center'>

No Customers Found

</td>

</tr>

";


}


?>


</table>


</div>


</div>



</div>



</div>


</div>



</body>

</html>