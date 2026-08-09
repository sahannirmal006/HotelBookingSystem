<?php

session_start();

include "../config/db.php";


if(isset($_POST['login'])){


$email=mysqli_real_escape_string($conn,$_POST['email']);

$password=$_POST['password'];



$result=mysqli_query($conn,


"SELECT * FROM owners WHERE email='$email'"

);



$owner=mysqli_fetch_assoc($result);



if($owner && password_verify($password,$owner['password'])){


$_SESSION['owner_id']=$owner['id'];

$_SESSION['owner_name']=$owner['name'];


header("Location: dashboard.php");

exit();


}
else{


$error="Invalid Email or Password";


}



}


?>


<!DOCTYPE html>

<html>


<head>

<title>Owner Login</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body>


<div class="container mt-5">


<div class="row justify-content-center">


<div class="col-md-5">


<div class="card shadow">


<div class="card-body">



<h2 class="text-center">

🏨 Owner Login

</h2>



<?php if(isset($error)){ ?>


<div class="alert alert-danger">

<?php echo $error; ?>

</div>


<?php } ?>




<form method="POST">


<label>Email</label>


<input type="email"

name="email"

class="form-control mb-3"

required>




<label>Password</label>


<input type="password"

name="password"

class="form-control mb-3"

required>




<button class="btn btn-primary w-100"

name="login">

Login

</button>



</form>



<br>


<a href="register.php">

Create Owner Account

</a>



</div>


</div>


</div>


</div>


</div>


</body>


</html>