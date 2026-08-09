<?php

include "../config/db.php";


$id = $_GET['id'];


$sql = "DELETE FROM hotels WHERE id=$id";


mysqli_query($conn,$sql);


header("Location: hotels.php");


exit();

?>