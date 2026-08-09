<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../config/db.php";

if (!isset($_SESSION['owner_id'])) {
    header("Location: login.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];


// Get owner's hotels
$result = mysqli_query($conn, "
    SELECT *
    FROM hotels
    WHERE owner_id = '$owner_id'
    ORDER BY id DESC
");

?>

<!DOCTYPE html>

<html>

<head>

```
<title>My Hotels</title>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>
```

</head>

<body class="bg-light">

<div class="container-fluid">

<div class="row">

<!-- SIDEBAR -->

<div class="col-md-3 bg-dark text-white min-vh-100 p-4">

```
<h3 class="text-center mb-4">
    🏨 Owner Panel
</h3>

<hr>

<a href="dashboard.php"
   class="btn btn-dark text-white w-100 mb-2">
    📊 Dashboard
</a>

<a href="hotels.php"
   class="btn btn-primary w-100 mb-2">
    🏨 My Hotels
</a>

<a href="rooms.php"
   class="btn btn-dark text-white w-100 mb-2">
    🚪 My Rooms
</a>

<a href="bookings.php"
   class="btn btn-dark text-white w-100 mb-2">
    📅 Customer Bookings
</a>

<a href="revenue.php"
   class="btn btn-dark text-white w-100 mb-2">
    💰 Revenue
</a>

<a href="logout.php"
   class="btn btn-danger w-100 mt-3">
    🚪 Logout
</a>
```

</div>

<!-- MAIN -->

<div class="col-md-9 p-5">

<div class="d-flex justify-content-between align-items-center mb-4">

```
<h1>
    🏨 My Hotels
</h1>

<a href="add_hotel.php"
   class="btn btn-success">

    ➕ Add Hotel

</a>
```

</div>

<div class="row">

<?php

if (mysqli_num_rows($result) > 0) {

    while ($hotel = mysqli_fetch_assoc($result)) {

?>

<div class="col-md-6 col-lg-4 mb-4">

<div class="card shadow h-100">

<?php if (!empty($hotel['image'])) { ?>

```
<img
    src="../uploads/hotels/<?php echo htmlspecialchars($hotel['image']); ?>"
    class="card-img-top"
    style="height:220px; object-fit:cover;"
>
```

<?php } else { ?>

```
<div
    class="bg-secondary text-white d-flex align-items-center justify-content-center"
    style="height:220px;"
>

    🏨 No Image

</div>
```

<?php } ?>

<div class="card-body">

<h4>
    <?php echo htmlspecialchars($hotel['hotel_name']); ?>
</h4>

<p class="text-muted">

```
📍 <?php echo htmlspecialchars($hotel['location']); ?>
```

</p>

<p>

```
<?php echo htmlspecialchars($hotel['description']); ?>
```

</p>

</div>

<div class="card-footer">

<a
 href="rooms.php?hotel_id=<?php echo $hotel['id']; ?>"
 class="btn btn-success btn-sm">

```
🚪 Rooms
```

</a>

<a
 href="edit_hotel.php?id=<?php echo $hotel['id']; ?>"
 class="btn btn-warning btn-sm">

```
✏️ Edit
```

</a>

<a
 href="delete_hotel.php?id=<?php echo $hotel['id']; ?>"
 class="btn btn-danger btn-sm"
 onclick="return confirm('Are you sure you want to delete this hotel?');">

```
🗑️ Delete
```

</a>

</div>

</div>

</div>

<?php

    }

} else {

?>

<div class="col-12">

```
<div class="alert alert-warning text-center">

    <h4>
        No Hotels Found
    </h4>

    <p>
        You haven't added any hotels yet.
    </p>

    <a href="add_hotel.php"
       class="btn btn-success">

        ➕ Add Your First Hotel

    </a>

</div>
```

</div>

<?php

}

?>

</div>

</div>

</div>

</div>

</body>

</html>
