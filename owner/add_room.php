<?php

session_start();

include "../config/db.php";

include "../includes/header.php";


if(!isset($_SESSION['owner_id'])){

    header("Location: login.php");
    exit();

}


if(!isset($_GET['hotel_id'])){

    header("Location: my_hotels.php");
    exit();

}


$hotel_id=$_GET['hotel_id'];



// Check hotel belongs to owner

$owner_id=$_SESSION['owner_id'];


$check=mysqli_query($conn,

"SELECT * FROM hotels

WHERE id=$hotel_id

AND owner_id=$owner_id"

);


if(mysqli_num_rows($check)==0){

    echo "Access Denied";
    exit();

}




if(isset($_POST['add_room'])){


$room_type=$_POST['room_type'];

$price=$_POST['price'];

$status=$_POST['status'];



$image="";



if(!empty($_FILES['image']['name'])){


$image=$_FILES['image']['name'];


$tmp=$_FILES['image']['tmp_name'];


move_uploaded_file(

$tmp,

"../uploads/rooms/".$image

);


}



$sql="INSERT INTO rooms

(hotel_id,room_type,price,status,image)

VALUES

('$hotel_id',
'$room_type',
'$price',
'$status',
'$image')";



if(mysqli_query($conn,$sql)){


echo "

<script>

alert('Room Added Successfully');

window.location='my_hotels.php';

</script>

";


}



}



?>



<div class="container mt-5">


<div class="card shadow">


<div class="card-body">


<h2>

🚪 Add Room

</h2>



<form method="POST" enctype="multipart/form-data">


<label>

Room Type

</label>


<input type="text"

name="room_type"

class="form-control mb-3"

placeholder="Deluxe Room"

required>




<label>

Price Per Day

</label>


<input type="number"

name="price"

class="form-control mb-3"

placeholder="15000"

required>




<label>

Status

</label>


<select name="status"

class="form-control mb-3">


<option value="Available">

Available

</option>


<option value="Booked">

Booked

</option>


</select>





<label>

Room Image

</label>


<input type="file"

name="image"

class="form-control mb-3">





<button class="btn btn-primary"

name="add_room">

➕ Add Room

</button>



</form>


</div>


</div>


</div>



<?php

include "../includes/footer.php";

?>