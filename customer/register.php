<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";


if(isset($_POST['register'])){


    $name = mysqli_real_escape_string($conn,$_POST['name']);

    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);



    // Check email already exists

    $check = mysqli_query($conn,

    "SELECT * FROM customers WHERE email='$email'"

    );


    if(mysqli_num_rows($check)>0){


        $error = "Email already registered";


    }else{


        $sql = mysqli_query($conn,

        "INSERT INTO customers

        (name,email,password)

        VALUES

        ('$name','$email','$password')"

        );


        if($sql){


            echo "<script>

            alert('Registration Successful');

            window.location='login.php';

            </script>";


        }else{


            $error = "Registration Failed";

        }


    }


}


?>


<!DOCTYPE html>

<html>

<head>

<title>Customer Register</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body class="bg-light">


<div class="container mt-5">


<div class="card shadow col-md-5 mx-auto">


<div class="card-body">


<h2 class="text-center mb-4">

👤 Customer Register

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

<label>

Full Name

</label>


<input type="text"

name="name"

class="form-control"

required>


</div>




<div class="mb-3">


<label>

Email

</label>


<input type="email"

name="email"

class="form-control"

required>


</div>




<div class="mb-3">


<label>

Password

</label>


<input type="password"

name="password"

class="form-control"

required>


</div>




<button

name="register"

class="btn btn-primary w-100">

Register

</button>



</form>



<hr>


<p class="text-center">

Already have an account?

<a href="login.php">

Login

</a>

</p>



</div>


</div>


</div>


</body>

</html>