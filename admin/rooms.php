<?php

session_start();

include "../config/db.php";


if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}



// Add Room

if(isset($_POST['add_room'])){


    $hotel_id = $_POST['hotel_id'];

    $room_type = mysqli_real_escape_string($conn,$_POST['room_type']);

    $price = $_POST['price'];

    $status = $_POST['status'];



    // Upload Image

    $image = $_FILES['image']['name'];

    $tmp_name = $_FILES['image']['tmp_name'];


    move_uploaded_file(

        $tmp_name,

        "../uploads/rooms/".$image

    );




    $sql = "INSERT INTO rooms

    (hotel_id,room_type,price,status,image)

    VALUES

    ('$hotel_id','$room_type','$price','$status','$image')";




    if(mysqli_query($conn,$sql)){


        header("Location: rooms.php");

        exit();

    }


}


?>



<!DOCTYPE html>
<html>

<head>

<title>Manage Rooms</title>

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

🚪 Room Management

</h1>




<div class="card shadow mt-4">


<div class="card-body">


<h4>Add New Room</h4>




<form method="POST" enctype="multipart/form-data">





<div class="mb-3">

<label>Select Hotel</label>


<select name="hotel_id"

class="form-control"

required>


<option value="">

Choose Hotel

</option>



<?php


$hotels=mysqli_query($conn,

"SELECT * FROM hotels"

);


while($hotel=mysqli_fetch_assoc($hotels)){


?>


<option value="<?php echo $hotel['id']; ?>">


<?php echo $hotel['hotel_name']; ?>


</option>


<?php

}

?>


</select>


</div>





<div class="mb-3">

<label>Room Type</label>


<input type="text"

name="room_type"

class="form-control"

placeholder="Deluxe Room"

required>


</div>





<div class="mb-3">

<label>Price Per Day</label>


<input type="number"

name="price"

class="form-control"

required>


</div>





<div class="mb-3">

<label>Status</label>


<select name="status"

class="form-control">


<option value="Available">

Available

</option>


<option value="Booked">

Booked

</option>


</select>


</div>





<div class="mb-3">

<label>Room Image</label>


<input type="file"

name="image"

class="form-control"

required>


</div>





<button class="btn btn-primary"

name="add_room">

Add Room

</button>



</form>



</div>


</div>







<div class="card shadow mt-5">


<div class="card-body">


<h4>

Room List

</h4>




<table class="table table-bordered table-striped">


<tr>

<th>ID</th>

<th>Image</th>

<th>Hotel</th>

<th>Room Type</th>

<th>Price</th>

<th>Status</th>

</tr>





<?php


$result=mysqli_query($conn,


"SELECT rooms.*, hotels.hotel_name

FROM rooms

JOIN hotels

ON rooms.hotel_id = hotels.id"

);



while($row=mysqli_fetch_assoc($result)){


?>



<tr>



<td>

<?php echo $row['id']; ?>

</td>




<td>


<?php if(!empty($row['image'])){ ?>


<img src="../uploads/rooms/<?php echo $row['image']; ?>"

width="100"

height="70"

style="object-fit:cover;">


<?php } ?>


</td>




<td>

<?php echo $row['hotel_name']; ?>

</td>




<td>

<?php echo $row['room_type']; ?>

</td>




<td>

Rs. <?php echo $row['price']; ?>

</td>




<td>


<?php if($row['status']=="Available"){ ?>


<span class="badge bg-success">

Available

</span>


<?php }else{ ?>


<span class="badge bg-danger">

Booked

</span>


<?php } ?>


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