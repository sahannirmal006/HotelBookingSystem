<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";


if(!isset($_SESSION['owner_id'])){

    header("Location: login.php");
    exit();

}



if(isset($_GET['id']) && isset($_GET['status'])){


    $booking_id = $_GET['id'];

    $status = $_GET['status'];



    // Get room id from booking

    $booking_query = mysqli_query($conn,

    "SELECT room_id FROM bookings WHERE id='$booking_id'"

    );


    $booking = mysqli_fetch_assoc($booking_query);


    $room_id = $booking['room_id'];



    // Update booking status

    mysqli_query($conn,

    "UPDATE bookings

    SET status='$status'

    WHERE id='$booking_id'"

    );




    // If confirmed, make room booked

    if($status=="Confirmed"){


        mysqli_query($conn,

        "UPDATE rooms

        SET status='Booked'

        WHERE id='$room_id'"

        );


    }



    // If rejected, make room available again

    if($status=="Rejected"){


        mysqli_query($conn,

        "UPDATE rooms

        SET status='Available'

        WHERE id='$room_id'"

        );


    }




    header("Location: manage_bookings.php");

    exit();



}


else{


echo "Invalid Request";


}


?>