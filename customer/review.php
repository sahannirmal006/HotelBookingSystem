<?php

session_start();

include "../config/db.php";

include "../includes/header.php";
include "../includes/navbar.php";



if(!isset($_SESSION['customer_id'])){

    header("Location: login.php");
    exit();

}



if(!isset($_GET['hotel_id'])){

    header("Location:index.php");
    exit();

}



$hotel_id=$_GET['hotel_id'];

$customer_id=$_SESSION['customer_id'];





if(isset($_POST['submit_review'])){


$rating=$_POST['rating'];

$comment=mysqli_real_escape_string($conn,$_POST['comment']);



mysqli_query($conn,


"INSERT INTO reviews

(customer_id,hotel_id,rating,comment)

VALUES

('$customer_id',
'$hotel_id',
'$rating',
'$comment')"

);



header("Location: hotels.php?id=$hotel_id");

exit();


}



?>



<div class="container mt-5">


<div class="card shadow">


<div class="card-body">


<h2>

⭐ Add Hotel Review

</h2>


<form method="POST">



<label>

Rating

</label>


<select name="rating" class="form-control" required>


<option value="5">
⭐⭐⭐⭐⭐ 5
</option>


<option value="4">
⭐⭐⭐⭐ 4
</option>


<option value="3">
⭐⭐⭐ 3
</option>


<option value="2">
⭐⭐ 2
</option>


<option value="1">
⭐ 1
</option>


</select>



<br>


<label>

Comment

</label>


<textarea name="comment"

class="form-control"

rows="4"

required></textarea>



<br>


<button class="btn btn-primary"

name="submit_review">

Submit Review

</button>



</form>


</div>

</div>


</div>



<?php

include "../includes/footer.php";

?>