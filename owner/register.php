<?php

include "../config/db.php";


if(isset($_POST['register'])){


$name=mysqli_real_escape_string($conn,$_POST['name']);

$email=mysqli_real_escape_string($conn,$_POST['email']);

$phone=$_POST['phone'];

$password=password_hash($_POST['password'],PASSWORD_DEFAULT);



$sql="INSERT INTO owners

(name,email,password,phone)

VALUES

('$name','$email','$password','$phone')";



if(mysqli_query($conn,$sql)){


header("Location: login.php");


}



}



?>


<!DOCTYPE html>
<html>

<head>

<title>Owner Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body>


<div class="container mt-5">


<div class="card shadow">


<div class="card-body">


<h2>

🏨 Hotel Owner Registration

</h2>



<form method="POST">



<input type="text"

name="name"

class="form-control mb-3"

placeholder="Owner Name"

required>




<input type="email"

name="email"

class="form-control mb-3"

placeholder="Email"

required>




<input type="text"

name="phone"

class="form-control mb-3"

placeholder="Phone"

required>




<input type="password"

name="password"

class="form-control mb-3"

placeholder="Password"

required>




<button class="btn btn-primary"

name="register">

Register

</button>



</form>



</div>


</div>


</div>


</body>

</html>