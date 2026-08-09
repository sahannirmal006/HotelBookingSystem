<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";


if(isset($_POST['login'])){


    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $password = $_POST['password'];



    $result = mysqli_query($conn,

    "SELECT * FROM customers 
    WHERE email='$email'"

    );



    if(mysqli_num_rows($result)>0){


        $customer = mysqli_fetch_assoc($result);



        if(password_verify($password,$customer['password'])){


            $_SESSION['customer_id'] = $customer['id'];

            $_SESSION['customer_name'] = $customer['name'];



            header("Location: dashboard.php");

            exit();



        }else{


            $error="Incorrect Password";


        }



    }else{


        $error="Email not found";


    }



}


?>



<!DOCTYPE html>

<html>

<head>

<title>Customer Login</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body class="bg-light">



<div class="container mt-5">


<div class="card shadow col-md-5 mx-auto">


<div class="card-body">


<h2 class="text-center">

👤 Customer Login

</h2>



<?php

if(isset($error)){

echo "

<div class='alert alert-danger'>

$error

</div>

";

}

?>



<form method="POST">


<div class="mb-3">

<label>Email</label>


<input type="email"

name="email"

class="form-control"

required>


</div>




<div class="mb-3">

<label>Password</label>


<input type="password"

name="password"

class="form-control"

required>


</div>




<button

name="login"

class="btn btn-success w-100">

Login

</button>


</form>



<hr>


<p class="text-center">

Don't have account?

<a href="register.php">

Register

</a>

</p>



</div>


</div>


</div>



</body>

</html>