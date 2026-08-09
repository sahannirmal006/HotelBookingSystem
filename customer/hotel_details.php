<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";


if(!isset($_SESSION['customer_id'])){

    header("Location: login.php");
    exit();

}



if(!isset($_GET['id'])){

    header("Location: hotels.php");
    exit();

}



$hotel_id = $_GET['id'];



// Get hotel details

$hotel_query = mysqli_query($conn,

"SELECT *

FROM hotels

WHERE id='$hotel_id'

AND status='Approved'

"

);



$hotel = mysqli_fetch_assoc($hotel_query);



if(!$hotel){

    echo "Hotel not found";

    exit();

}



?>


<!DOCTYPE html>

<html>

<head>

<title><?php echo $hotel['hotel_name']; ?></title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="../assets/style.css" rel="stylesheet">


</head>



<body>


<?php include "../includes/navbar.php"; ?>



<div class="container mt-5">



<a href="hotels.php" class="btn btn-dark mb-4">

⬅ Back Hotels

</a>




<div class="card shadow">



<?php

if(!empty($hotel['image']) && file_exists("../uploads/hotels/".$hotel['image'])){


?>

<img

src="../uploads/hotels/<?php echo $hotel['image']; ?>"

class="card-img-top"

style="height:350px;object-fit:cover;"



>


<?php


}else{


?>


<div class="bg-secondary text-white d-flex justify-content-center align-items-center"

style="height:350px;">

🏨 No Image

</div>



<?php

}

?>





<div class="card-body">



<h1>

🏨 <?php echo htmlspecialchars($hotel['hotel_name']); ?>

</h1>



<h5>

📍 <?php echo htmlspecialchars($hotel['location']); ?>

</h5>



<p class="mt-3">

<?php echo htmlspecialchars($hotel['description']); ?>

</p>



</div>


</div>





<h2 class="mt-5">

🚪 Available Rooms

</h2>



<div class="row mt-3">



<?php



$rooms = mysqli_query($conn,


"SELECT *

FROM rooms

WHERE hotel_id='$hotel_id'

AND status='Available'

"

);



if(mysqli_num_rows($rooms)>0){



while($room=mysqli_fetch_assoc($rooms)){



?>



<div class="col-md-4 mb-4">



<div class="card shadow">



<?php

if(!empty($room['image']) && file_exists("../uploads/rooms/".$room['image'])){


?>


<img

src="../uploads/rooms/<?php echo $room['image']; ?>"

class="card-img-top"

style="height:220px;object-fit:cover;"

>


<?php


}else{


?>

<div class="bg-secondary text-white d-flex justify-content-center align-items-center"

style="height:220px;">

🚪 No Image

</div>


<?php


}


?>





<div class="card-body">



<h4>

🚪 <?php echo htmlspecialchars($room['room_type']); ?>

</h4>



<h5>

💰 Rs. <?php echo number_format($room['price']); ?>

</h5>



<span class="badge bg-success">

✅ Available

</span>



<a href="booking.php?room_id=<?php echo $room['id']; ?>"

class="btn btn-primary w-100 mt-3">


Book Now


</a>




</div>



</div>



</div>



<?php


}


}else{


?>


<div class="alert alert-warning">

<h4>

🚪 No Rooms Available

</h4>


<p>

Currently no rooms are available for this hotel.

</p>

</div>



<?php


}


?>



</div>



</div>



</body>

</html>