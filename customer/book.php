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


$room_id = $_GET['id'];



// Get room details

$room_result = mysqli_query($conn,

"SELECT rooms.*, hotels.hotel_name

FROM rooms

JOIN hotels

ON rooms.hotel_id = hotels.id

WHERE rooms.id='$room_id'"

);


$room = mysqli_fetch_assoc($room_result);



if(isset($_POST['book'])){


    $check_in = $_POST['check_in'];

    $check_out = $_POST['check_out'];


    $days = (strtotime($check_out) - strtotime($check_in)) / 86400;


    if($days <= 0){

        $error = "Invalid date selection";

    }else{


        $total = $days * $room['price'];


        $customer_id = $_SESSION['customer_id'];



        $insert = mysqli_query($conn,

        "INSERT INTO bookings

        (customer_id, room_id, check_in, check_out, total_amount, status)

        VALUES

        ('$customer_id','$room_id','$check_in','$check_out','$total','Pending')"

        );



        if($insert){


            echo "<script>

            alert('Booking Successful');

            window.location='bookings.php';

            </script>";



        }


    }


}


?>



<!DOCTYPE html>

<html>

<head>

<title>Book Room</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body class="bg-light">


<div class="container mt-5">



<div class="card shadow col-md-6 mx-auto">


<div class="card-body">


<h2>

📅 Book Room

</h2>



<h4>

🏨 <?php echo $room['hotel_name']; ?>

</h4>



<p>

🚪 Room:

<?php echo $room['room_type']; ?>

</p>



<p>

💰 Price per day:

Rs. <?php echo number_format($room['price']); ?>

</p>



<?php

if(isset($error)){

echo "

<div class='alert alert-danger'>

$error

</div>

";

}

?>



<form method="POST">



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




<button name="book"

class="btn btn-success w-100">

Confirm Booking

</button>



</form>



</div>

</div>


</div>


</body>

</html>