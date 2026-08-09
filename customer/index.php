<?php

include "../config/db.php";

include "../includes/header.php";

include "../includes/navbar.php";

?>



<div class="container mt-5">



<div class="text-center mb-4">


<h1 class="display-4">

Find Your Perfect Stay 🏨

</h1>


<p class="lead">

Book hotels easily with our online hotel booking system.

</p>


</div>







<!-- Search -->


<form method="GET" class="mb-5">


<div class="row">


<div class="col-md-10">


<input type="text"

name="search"

class="form-control"

placeholder="Search hotel name or location..."

value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">


</div>



<div class="col-md-2">


<button class="btn btn-primary w-100">

🔍 Search

</button>


</div>


</div>


</form>








<div class="row">



<?php



if(isset($_GET['search']) && $_GET['search']!=""){


$search=mysqli_real_escape_string($conn,$_GET['search']);


$sql="SELECT * FROM hotels

WHERE hotel_name LIKE '%$search%'

OR location LIKE '%$search%'";


}

else{


$sql="SELECT * FROM hotels";


}





$result=mysqli_query($conn,$sql);





if(mysqli_num_rows($result)>0){



while($hotel=mysqli_fetch_assoc($result)){



?>





<div class="col-md-4 mb-4">


<div class="card shadow h-100">






<!-- Hotel Image -->


<?php if(!empty($hotel['image'])){ ?>


<img src="../uploads/hotels/<?php echo $hotel['image']; ?>"

class="card-img-top"

style="height:220px;object-fit:cover;">



<?php }else{ ?>


<img src="https://via.placeholder.com/400x220"

class="card-img-top">



<?php } ?>








<div class="card-body">





<h4>

🏨 <?php echo $hotel['hotel_name']; ?>

</h4>





<h6 class="text-muted">

📍 <?php echo $hotel['location']; ?>

</h6>







<!-- Rating -->


<?php



$rating_query=mysqli_query($conn,


"SELECT AVG(rating) AS avg_rating,

COUNT(*) AS total_reviews

FROM reviews

WHERE hotel_id=".$hotel['id']

);



$rating=mysqli_fetch_assoc($rating_query);



$avg_rating=round($rating['avg_rating'],1);

$total_reviews=$rating['total_reviews'];



?>





<?php if($total_reviews>0){ ?>


<p>


<?php


$stars=round($avg_rating);



for($i=1;$i<=$stars;$i++){

echo "⭐";

}


?>


<br>


<small>

<?php echo $avg_rating; ?> / 5

(<?php echo $total_reviews; ?> Reviews)

</small>


</p>



<?php }else{ ?>


<p class="text-muted">

No reviews yet

</p>



<?php } ?>







<p>

<?php echo $hotel['description']; ?>

</p>







<a href="hotels.php?id=<?php echo $hotel['id']; ?>"

class="btn btn-primary w-100">

View Rooms

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

No hotels found.

</div>



<?php


}


?>



</div>


</div>






<?php

include "../includes/footer.php";

?>