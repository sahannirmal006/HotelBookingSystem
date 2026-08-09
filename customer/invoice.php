<?php

session_start();

include "../config/db.php";

require "../vendor/autoload.php";


use Dompdf\Dompdf;



if(!isset($_SESSION['customer_id'])){

    header("Location: login.php");
    exit();

}



if(!isset($_GET['booking_id'])){

    header("Location: bookings.php");
    exit();

}



$booking_id=$_GET['booking_id'];



// Get booking details

$result=mysqli_query($conn,


"SELECT bookings.*,

customers.name,

customers.email,

hotels.hotel_name,

hotels.location,

rooms.room_type


FROM bookings


JOIN customers

ON bookings.customer_id=customers.id


JOIN rooms

ON bookings.room_id=rooms.id


JOIN hotels

ON rooms.hotel_id=hotels.id



WHERE bookings.id=$booking_id"

);



$booking=mysqli_fetch_assoc($result);



if(!$booking){

    echo "Booking not found";
    exit();

}




$html='

<h1 style="text-align:center;">

🏨 Hotel Booking System

</h1>


<hr>


<h2>

Booking Invoice

</h2>


<table border="1" width="100%" cellpadding="10">


<tr>

<td><b>Booking ID</b></td>

<td>'.$booking['id'].'</td>

</tr>



<tr>

<td><b>Customer Name</b></td>

<td>'.$booking['name'].'</td>

</tr>



<tr>

<td><b>Email</b></td>

<td>'.$booking['email'].'</td>

</tr>



<tr>

<td><b>Hotel</b></td>

<td>'.$booking['hotel_name'].'</td>

</tr>




<tr>

<td><b>Location</b></td>

<td>'.$booking['location'].'</td>

</tr>




<tr>

<td><b>Room</b></td>

<td>'.$booking['room_type'].'</td>

</tr>



<tr>

<td><b>Check In</b></td>

<td>'.$booking['check_in'].'</td>

</tr>



<tr>

<td><b>Check Out</b></td>

<td>'.$booking['check_out'].'</td>

</tr>



<tr>

<td><b>Total Amount</b></td>

<td>Rs. '.number_format($booking['total_amount']).'</td>

</tr>



<tr>

<td><b>Status</b></td>

<td>'.$booking['status'].'</td>

</tr>



</table>


<br><br>


<h3 style="text-align:center;">

Thank you for choosing our hotel!

</h3>

';





$pdf=new Dompdf();


$pdf->loadHtml($html);


$pdf->setPaper('A4','portrait');


$pdf->render();



$pdf->stream(

"Hotel_Booking_Invoice.pdf",

array("Attachment"=>1)

);


?>