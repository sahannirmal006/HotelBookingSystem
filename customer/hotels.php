<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";


if(!isset($_SESSION['customer_id'])){

    header("Location: login.php");
    exit();

}


?>


<!DOCTYPE html>

<html>

<head>

<title>Available Hotels</title>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="../assets/style.css" rel="stylesheet">


</head>


<body>


<?php include "../includes/navbar.php"; ?>



<div class="container mt-5">



<a href="dashboard.php" class="btn btn-dark mb-4">

⬅ Dashboard

</a>



<h1 class="mb-4">

🏨 Available Hotels

</h1>




<div class="row">



<?php


$sql = "

SELECT *

FROM hotels

WHERE status='Approved'

ORDER BY id DESC

";


$result = mysqli_query($conn,$sql);



if(mysqli_num_rows($result)>0){



while($hotel=mysqli_fetch_assoc($result)){



?>



<div class="col-md-4 mb-4">



<div class="card shadow h-100">



<?php


if(!empty($hotel['image']) && file_exists("../uploads/hotels/".$hotel['image'])){


?>


<img

src="../uploads/hotels/<?php echo htmlspecialchars($hotel['image']); ?>"

class="card-img-top"

style="height:220px;object-fit:cover;">



<?php


}else{


?>


<div class="bg-secondary text-white d-flex align-items-center justify-content-center"

style="height:220px;">


🏨 No Image


</div>



<?php


}


?>




<div class="card-body">



<h4>

🏨 <?php echo htmlspecialchars($hotel['hotel_name']); ?>

</h4>



<p>

📍 <?php echo htmlspecialchars($hotel['location']); ?>

</p>



<p>

<?php echo htmlspecialchars($hotel['description']); ?>

</p>



<a href="hotel_details.php?id=<?php echo $hotel['id']; ?>"

class="btn btn-primary w-100">


View Details


</a>




</div>


</div>


</div>



<?php


}


}

else{


?>


<div class="alert alert-warning text-center">


<h4>

🏨 No Hotels Available

</h4>


<p>

No approved hotels are available right now.

</p>


</div>



<?php


}


?>



</div>


</div>



</body>

</html>