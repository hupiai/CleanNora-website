<?php

include 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$success = false;

if(isset($_POST['send_message']))
{
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = mysqli_query($conn,"
    INSERT INTO contact_messages
    (
        name,
        email,
        phone,
        message
    )
    VALUES
    (
        '$name',
        '$email',
        '$phone',
        '$message'
    )
    ");

    if($query)
    {
        $success = true;
    }
    else
    {
        die(mysqli_error($conn));
    }
}

include 'includes/header.php';

?>

<section class="py-5 text-center text-white"
style="
background:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),
url('assets/images/home-cleaning.jpg');
background-size:cover;
background-position:center;
">

<div class="container">

<h1 class="display-4 fw-bold">
Contact Cleannora
</h1>

<p class="lead">
Book Home Cleaning, Deep Cleaning, Maid Services &
Office Cleaning in Noida.
</p>

<a href="tel:+919205080012"
class="btn btn-warning btn-lg">
📞 Call Now
</a>

</div>

</section>

<div class="container mt-5">

<?php if($success){ ?>

<div class="alert alert-success text-center">
Message Sent Successfully. We will contact you shortly.
</div>

<?php } ?>

<div class="row">

<div class="col-md-6">

<div class="card shadow-sm p-3 mb-3">
<h5>📞 Call Us</h5>
<p class="mb-0">+91 9205080012</p>
</div>

<div class="card shadow-sm p-3 mb-3">
<h5>💬 WhatsApp</h5>
<a href="https://wa.me/919205080012" target="_blank">
Chat On WhatsApp
</a>
</div>

<div class="card shadow-sm p-3">
<h5>📍 Location</h5>
<p class="mb-0">Noida Sector 70</p>
</div>

</div>

<div class="col-md-6">

<form method="POST">

<input
type="text"
name="name"
class="form-control mb-3"
placeholder="Your Name"
required>

<input
type="email"
name="email"
class="form-control mb-3"
placeholder="Email"
required>

<input
type="text"
name="phone"
class="form-control mb-3"
placeholder="Phone"
required>

<textarea
name="message"
class="form-control mb-3"
rows="5"
placeholder="Message"
required></textarea>

<button
type="submit"
name="send_message"
class="btn btn-primary w-100 py-3">
Send Message
</button>

</form>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>