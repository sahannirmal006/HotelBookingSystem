<?php

session_start();

include "../config/db.php";

if(!isset($_SESSION['owner_id'])){

    header("Location: login.php");
    exit();

}


include "../includes/header.php";



if(isset($_POST['add_hotel'])){


$owner_id = $_SESSION['owner_id'];

$hotel_name = $_POST['hotel_name'];

$location = $_POST['location'];

$description = $_POST['description'];



$image="";


if(!empty($_FILES['image']['name'])){


$image = $_FILES['image']['name'];

$tmp = $_FILES['image']['tmp_name'];


move_uploaded_file(

$tmp,

"../uploads/hotels/".$image

);


}



$sql="INSERT INTO hotels

(owner_id,hotel_name,location,description,image)

VALUES

('$owner_id',
'$hotel_name',
'$location',
'$description',
'$image')";



if(mysqli_query($conn,$sql)){


echo "

<script>

alert('Hotel Added Successfully');

window.location='dashboard.php';

</script>

";


}



}



?>



<div class="container mt-5">


<div class="card shadow">


<div class="card-body">


<h2>
🏨 Add Hotel
</h2>


<form method="POST" enctype="multipart/form-data">


<input type="text"
name="hotel_name"
class="form-control mb-3"
placeholder="Hotel Name"
required>



<input type="text"
name="location"
class="form-control mb-3"
placeholder="Location"
required>




<textarea name="description"
class="form-control mb-3"
placeholder="Description"
required></textarea>




<input type="file"
name="image"
class="form-control mb-3">





<button class="btn btn-primary"
name="add_hotel">

Add Hotel

</button>


</form>


</div>


</div>


</div>



<?php

include "../includes/footer.php";

?>