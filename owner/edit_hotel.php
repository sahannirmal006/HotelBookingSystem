<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../config/db.php";
include "../includes/header.php";

if(!isset($_SESSION['owner_id'])){
    header("Location: login.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];

if(!isset($_GET['id'])){
    header("Location: hotels.php");
    exit();
}

$id = (int)$_GET['id'];

$result = mysqli_query($conn,
"SELECT * FROM hotels
WHERE id='$id'
AND owner_id='$owner_id'");

if(mysqli_num_rows($result)==0){

    echo "<div class='container mt-5'>
            <div class='alert alert-danger'>
                Hotel not found or access denied.
            </div>
          </div>";

    include "../includes/footer.php";
    exit();
}

$hotel = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $hotel_name = mysqli_real_escape_string($conn,$_POST['hotel_name']);
    $location = mysqli_real_escape_string($conn,$_POST['location']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);

    $image = $hotel['image'];

    if(!empty($_FILES['image']['name'])){

        $image = time()."_".$_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../uploads/hotels/".$image
        );

    }

    mysqli_query($conn,

    "UPDATE hotels SET

    hotel_name='$hotel_name',
    location='$location',
    description='$description',
    image='$image'

    WHERE id='$id'

    ");

    echo "<script>

    alert('Hotel Updated Successfully');

    window.location='hotels.php';

    </script>";

    exit();

}

?>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>✏ Edit Hotel</h3>

</div>

<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<label class="form-label">Hotel Name</label>

<input
type="text"
name="hotel_name"
class="form-control"
value="<?php echo $hotel['hotel_name']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Location</label>

<input
type="text"
name="location"
class="form-control"
value="<?php echo $hotel['location']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Description</label>

<textarea
name="description"
class="form-control"
rows="4"
required><?php echo $hotel['description']; ?></textarea>

</div>

<div class="mb-3">

<label class="form-label">

Current Image

</label>

<br>

<img
src="../uploads/hotels/<?php echo $hotel['image']; ?>"
width="250"
class="img-thumbnail">

</div>

<div class="mb-3">

<label class="form-label">

Change Image

</label>

<input
type="file"
name="image"
class="form-control">

</div>

<button
type="submit"
name="update"
class="btn btn-success">

💾 Update Hotel

</button>

<a
href="hotels.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

<?php

include "../includes/footer.php";

?>