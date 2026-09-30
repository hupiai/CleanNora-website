<?php

include 'includes/db.php';
include 'includes/header.php';

$result = null;

if(isset($_POST['track']))
{
    $booking_id = $_POST['booking_id'];

    $result = mysqli_query($conn,"
    SELECT * FROM bookings
    WHERE booking_id='$booking_id'
    ");
}

?>

<div class="container mt-5">

<h1 class="text-center mb-4">
Track Booking
</h1>

<form method="POST">

<div class="row">

<div class="col-md-10">
<input
type="text"
name="booking_id"
class="form-control"
placeholder="Enter Booking ID"
required>
</div>

<div class="col-md-2">
<button
type="submit"
name="track"
class="btn btn-primary w-100">
Track
</button>
</div>

</div>

</form>

<?php

if($result && mysqli_num_rows($result)>0)
{
$row=mysqli_fetch_assoc($result);

?>

<div class="card mt-4 p-4">

<h4>Booking Details</h4>

<p>
<b>Booking ID:</b>
<?php echo $row['booking_id']; ?>
</p>

<p>
<b>Status:</b>
<?php echo $row['booking_status']; ?>
</p>

<p>
<b>Amount:</b>
₹<?php echo $row['amount']; ?>
</p>

<p>
<b>Payment:</b>
<?php echo $row['payment_status']; ?>
</p>

</div>

<?php } ?>

</div>

<?php include 'includes/footer.php'; ?>