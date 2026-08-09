<?php

session_start();

include "../config/db.php";


if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}


// Approve / Reject Hotel

if(isset($_GET['action']) && isset($_GET['id'])){


    $id = $_GET['id'];

    $action = $_GET['action'];



    if($action=="approve"){


        mysqli_query($conn,

        "UPDATE hotels 
        SET status='Approved'
        WHERE id='$id'"

        );


    }



    if($action=="reject"){


        mysqli_query($conn,

        "UPDATE hotels 
        SET status='Rejected'
        WHERE id='$id'"

        );


    }



    header("Location: hotels.php");

    exit();

}



?>



<!DOCTYPE html>

<html>

<head>

<title>Hotel Management</title>


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
📊 Dashboard
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
🚪 Logout
</a>



</div>





<!-- Content -->


<div class="col-md-9 p-5">



<h1>

🏨 Hotel Approval Management

</h1>


<hr>




<div class="card shadow">


<div class="card-body">



<table class="table table-bordered table-striped">



<tr class="table-dark">


<th>ID</th>

<th>Image</th>

<th>Hotel</th>

<th>Location</th>

<th>Description</th>

<th>Status</th>

<th>Action</th>


</tr>




<?php


$result = mysqli_query($conn,

"SELECT * FROM hotels ORDER BY id DESC"

);



while($hotel=mysqli_fetch_assoc($result)){


?>



<tr>



<td>

<?php echo $hotel['id']; ?>

</td>




<td>


<?php if(!empty($hotel['image'])){ ?>


<img 

src="../uploads/hotels/<?php echo $hotel['image']; ?>"

width="100"

height="70"

style="object-fit:cover;">


<?php }else{ ?>


No Image


<?php } ?>


</td>




<td>

🏨 <?php echo $hotel['hotel_name']; ?>

</td>



<td>

📍 <?php echo $hotel['location']; ?>

</td>



<td>

<?php echo $hotel['description']; ?>

</td>




<td>


<?php


$status = $hotel['status'] ?? "Pending";


if($status=="Approved"){


echo '<span class="badge bg-success">
✅ Approved
</span>';


}

elseif($status=="Rejected"){


echo '<span class="badge bg-danger">
❌ Rejected
</span>';


}

else{


echo '<span class="badge bg-warning">
⏳ Pending
</span>';


}


?>


</td>





<td>



<a href="hotels.php?action=approve&id=<?php echo $hotel['id']; ?>"

class="btn btn-success btn-sm">

✅ Approve

</a>




<a href="hotels.php?action=reject&id=<?php echo $hotel['id']; ?>"

class="btn btn-danger btn-sm">

❌ Reject

</a>



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



</body>

</html>