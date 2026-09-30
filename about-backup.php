<?php

include 'includes/db.php';

$totalCustomers = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM users WHERE role='customer'")
);

$totalBookings = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM bookings")
);

$totalProviders = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM providers")
);

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
Professional Home Cleaning Services
</h1>

<p class="lead mt-3">
Trusted Home Cleaning, Deep Cleaning, Maid Services &
Office Cleaning in Noida.
</p>

<a href="contact.php" class="btn btn-primary btn-lg mt-3">
Get Free Quote
</a>

</div>

</section>

<div class="container mt-5">

<div class="row">

<div class="col-md-6">

<img
src="assets/images/home-cleaning.jpg"
class="img-fluid rounded">

</div>

<div class="col-md-6">

<h3>Professional Home Cleaning Services</h3>

<p>

Cleannora provides reliable and affordable
home cleaning, deep cleaning, bathroom cleaning,
kitchen cleaning, office cleaning and maid services.

</p>

<p>

Our trained and verified professionals help
customers maintain clean, hygienic and healthy
living spaces with quality service.

</p>

<p>

We focus on customer satisfaction, transparency
and timely service delivery.

</p>

</div>

</div>

<div class="row mt-5 text-center">

<div class="col-md-4">

<h2>50+</h2>
<p>Happy Customers</p>

</div>

<div class="col-md-4">

<h2>100+</h2>
<p>Completed Jobs</p>

</div>

<div class="col-md-4">

<h2>10+</h2>
<p>Professional Staff</p>

</div>

</div>

</div>

<div class="container mt-5">

<h2 class="text-center mb-5">
Customer Testimonials
</h2>

<div class="row">

<div class="col-md-4">
<div class="card p-4">
★★★★★
<br><br>
Excellent cleaning service and professional staff.
<br><br>
<b>Home Cleaning Customer</b>
</div>
</div>

<div class="col-md-4">
<div class="card p-4">
★★★★★
<br><br>
Very affordable and on-time service.
<br><br>
<b>Deep Cleaning Customer</b>
</div>
</div>

<div class="col-md-4">
<div class="card p-4">
★★★★★
<br><br>
Highly recommended for home cleaning.
<br><br>
<b>Office Cleaning Customer</b>
</div>
</div>

</div>

</div>

<div class="container mt-5 mb-5">

<h2 class="text-center mb-4">
Frequently Asked Questions
</h2>

<div class="card p-4 mb-3 shadow-sm">
<b>How do I book a service?</b>
<br>
Fill the booking form on the homepage.
</div>

<div class="card p-4 mb-3 shadow-sm">
<b>Are your professionals verified?</b>
<br>
Yes, all professionals are verified.
</div>

<div class="card p-4 mb-3 shadow-sm">
<b>Do you provide same day service?</b>
<br>
Subject to availability.
</div>

</div>

<?php include 'includes/footer.php'; ?>