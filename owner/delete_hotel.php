<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";

if(!isset($_SESSION['owner_id'])){
    header("Location: login.php");
    exit();
}

$owner_id=$_SESSION['owner_id'];

if(!isset($_GET['id'])){
    header("Location: hotels.php");
    exit();
}

$id=(int)$_GET['id'];

$result=mysqli_query($conn,

"SELECT * FROM hotels
WHERE id='$id'
AND owner_id='$owner_id'");

if(mysqli_num_rows($result)==0){

    die("Hotel not found.");

}

$hotel=mysqli_fetch_assoc($result);

if(!empty($hotel['image'])){

    $path="../uploads/hotels/".$hotel['image'];

    if(file_exists($path)){

        unlink($path);

    }

}

mysqli_query($conn,

"DELETE FROM hotels
WHERE id='$id'");

header("Location: hotels.php");

exit();

?>