<?php

session_start();

include "../config/db.php";

include "../includes/header.php";


if(!isset($_SESSION['owner_id'])){

    header("Location: login.php");
    exit();

}


$owner_id=$_SESSION['owner_id'];



$result=mysqli_query($conn,


"SELECT * FROM hotels

WHERE owner_id=$owner_id"

);


?>


<div class="container mt-5">


<h1>

🏨 My Hotels

</h1>


<div class="row mt-4">



<?php


if(mysqli_num_rows($result)>0){


while($hotel=mysqli_fetch_assoc($result)){


?>


<div class="col-md-4 mb-4">


<div class="card shadow h-100">



<?php if(!empty($hotel['image'])){ ?>


<img src="../uploads/hotels/<?php echo $hotel['image']; ?>"

class="card-img-top"

style="height:220px;object-fit:cover;">


<?php } else { ?>


<img src="https://via.placeholder.com/400x220"

class="card-img-top">


<?php } ?>




<div class="card-body">


<h4>

🏨 <?php echo $hotel['hotel_name']; ?>

</h4>



<p>

📍 <?php echo $hotel['location']; ?>

</p>



<p>

<?php echo $hotel['description']; ?>

</p>



<a href="add_room.php?hotel_id=<?php echo $hotel['id']; ?>"

class="btn btn-success w-100 mb-2">

🚪 Add Rooms

</a>



</div>


</div>


</div>



<?php


}


}

else{


?>


<div class="alert alert-warning">

No hotels added yet.

</div>


<?php


}


?>


</div>


</div>



<?php

include "../includes/footer.php";

?>