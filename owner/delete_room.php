<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../config/db.php";


if (!isset($_SESSION['owner_id'])) {
    header("Location: login.php");
    exit();
}


$owner_id = $_SESSION['owner_id'];


if (!isset($_GET['id'])) {
    header("Location: rooms.php");
    exit();
}


$id = (int) $_GET['id'];


// Check room belongs to this owner

$result = mysqli_query($conn, "

    SELECT rooms.*, hotels.owner_id

    FROM rooms

    INNER JOIN hotels
        ON rooms.hotel_id = hotels.id

    WHERE rooms.id = '$id'

    AND hotels.owner_id = '$owner_id'

");


if (!$result || mysqli_num_rows($result) == 0) {

    die("Room not found or you do not have permission to delete this room.");

}


$room = mysqli_fetch_assoc($result);


// Check if room has bookings

$booking_check = mysqli_query($conn, "

    SELECT COUNT(*) AS total

    FROM bookings

    WHERE room_id = '$id'

");


$booking_data = mysqli_fetch_assoc($booking_check);

$booking_count = $booking_data['total'];


// If bookings exist, don't delete

if ($booking_count > 0) {

    ?>

    <!DOCTYPE html>

    <html>

    <head>

        <title>Cannot Delete Room</title>

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
        >

    </head>


    <body>


    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-body text-center">

                <h2 class="text-danger">

                    ⚠️ Cannot Delete Room

                </h2>


                <p class="mt-3">

                    This room has

                    <strong>
                        <?php echo $booking_count; ?>
                    </strong>

                    booking(s).

                </p>


                <p class="text-muted">

                    You cannot delete a room that has existing bookings.

                    This protects your booking history.

                </p>


                <a
                    href="rooms.php"
                    class="btn btn-primary"
                >

                    ← Back to Rooms

                </a>

            </div>

        </div>

    </div>


    </body>

    </html>

    <?php

    exit();

}


// Delete image if there are no bookings

if (!empty($room['image'])) {

    $image_path = "../uploads/rooms/" . $room['image'];


    if (file_exists($image_path)) {

        unlink($image_path);

    }

}


// Delete room

$delete = mysqli_query($conn, "

    DELETE FROM rooms

    WHERE id = '$id'

");


if (!$delete) {

    die("Error deleting room: " . mysqli_error($conn));

}


// Return to rooms page

header("Location: rooms.php");

exit();

?>