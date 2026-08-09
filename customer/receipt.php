<?php

session_start();

require "../vendor/autoload.php";

include "../config/db.php";


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



$result=mysqli_query($conn,


"SELECT payments.*,

customers.name,
customers.email,

hotels.hotel_name,

rooms.room_type,

bookings.check_in,
bookings.check_out


FROM payments


JOIN bookings

ON payments.booking_id=bookings.id


JOIN customers

ON bookings.customer_id=customers.id


JOIN rooms

ON bookings.room_id=rooms.id


JOIN hotels

ON rooms.hotel_id=hotels.id


WHERE payments.booking_id=$booking_id"

);



$data=mysqli_fetch_assoc($result);



if(!$data){

echo "Receipt not found";

exit();

}




$html='


<h1 style="text-align:center">

🏨 Hotel Booking System

</h1>


<h2 style="text-align:center">

Payment Receipt

</h2>


<hr>


<h3>Customer Details</h3>


<p>
Name: '.$data['name'].'
</p>


<p>
Email: '.$data['email'].'
</p>




<h3>Booking Details</h3>


<p>
Hotel:
'.$data['hotel_name'].'
</p>


<p>
Room:
'.$data['room_type'].'
</p>


<p>
Check In:
'.$data['check_in'].'
</p>


<p>
Check Out:
'.$data['check_out'].'
</p>




<h3>Payment Details</h3>


<p>
Amount:
Rs. '.number_format($data['amount']).'
</p>


<p>
Status:
'.$data['payment_status'].'
</p>


<p>
Date:
'.$data['payment_date'].'
</p>



<br><br>


<h3 style="text-align:center">

Thank you for booking with us ❤️

</h3>



';



$dompdf=new Dompdf();


$dompdf->loadHtml($html);


$dompdf->setPaper('A4','portrait');


$dompdf->render();


$dompdf->stream("Hotel_Payment_Receipt.pdf");

?>