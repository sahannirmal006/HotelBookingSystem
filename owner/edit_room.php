<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";
include "../includes/header.php";


if(!isset($_SESSION['owner_id'])){

    header("Location: login.php");
    exit();

}


$owner_id=$_SESSION['owner_id'];



if(!isset($_GET['id'])){

    header("Location: rooms.php");
    exit();

}


$id=(int)$_GET['id'];



// Get room details

$result=mysqli_query($conn,

"SELECT rooms.*, hotels.owner_id

FROM rooms

JOIN hotels

ON rooms.hotel_id = hotels.id

WHERE rooms.id='$id'

AND hotels.owner_id='$owner_id'

");



if(mysqli_num_rows($result)==0){

    die("Room not found or access denied.");

}


$room=mysqli_fetch_assoc($result);





if(isset($_POST['update'])){


$room_type=mysqli_real_escape_string($conn,$_POST['room_type']);

$price=mysqli_real_escape_string($conn,$_POST['price']);

$status=mysqli_real_escape_string($conn,$_POST['status']);

$image=$room['image'];



if(!empty($_FILES['image']['name'])){


$image=time()."_".$_FILES['image']['name'];


move_uploaded_file(

$_FILES['image']['tmp_name'],

"../uploads/rooms/".$image

);


}



mysqli_query($conn,


"UPDATE rooms SET

room_type='$room_type',

price='$price',

status='$status',

image='$image'


WHERE id='$id'

"

);



echo "<script>

alert('Room Updated Successfully');

window.location='rooms.php';

</script>";

exit();


}



?>



<div class="container mt-5">


<div class="card shadow">


<div class="card-header bg-primary text-white">

<h3>✏ Edit Room</h3>

</div>



<div class="card-body">


<form method="POST" enctype="multipart/form-data">



<div class="mb-3">

<label>Room Type</label>

<input type="text"

name="room_type"

class="form-control"

value="<?php echo $room['room_type']; ?>"

required>

</div>



<div class="mb-3">

<label>Price</label>

<input type="number"

name="price"

class="form-control"

value="<?php echo $room['price']; ?>"

required>

</div>




<div class="mb-3">

<label>Status</label>


<select name="status" class="form-control">


<option value="Available"

<?php if($room['status']=="Available") echo "selected"; ?>>

Available

</option>


<option value="Booked"

<?php if($room['status']=="Booked") echo "selected"; ?>>

Booked

</option>


</select>


</div>




<div class="mb-3">


<label>Current Image</label>

<br>


<img src="../uploads/rooms/<?php echo $room['image']; ?>"

width="250"

class="img-thumbnail">


</div>




<div class="mb-3">


<label>Change Image</label>


<input type="file"

name="image"

class="form-control">


</div>




<button name="update"

class="btn btn-success">

💾 Update Room

</button>


<a href="rooms.php"

class="btn btn-secondary">

Cancel

</a>



</form>


</div>


</div>


</div>




<?php

include "../includes/footer.php";

?>