<?php

$services = [

[
"title"=>"Instant Maid",
"image"=>"assets/images/services/instant-maid.webp",
"icon"=>"assets/images/icons/instant-maid.png",
"description"=>"Trained maid for daily cleaning, dusting and household chores.",
"url"=>"instant-maid-services.php"
],

[
"title"=>"Home Cleaning",
"image"=>"assets/images/services/home-cleaning.webp",
"icon"=>"assets/images/icons/home-cleaning.png",
"description"=>"Complete home cleaning for a fresh, hygienic and healthy living space.",
"url"=>"home-cleaning.php"
],

[
"title"=>"Deep Cleaning",
"image"=>"assets/images/services/deep-cleaning.webp",
"icon"=>"assets/images/icons/deep-cleaning.png",
"description"=>"Intensive deep cleaning for every corner of your home and furniture.",
"url"=>"deep-cleaning.php"
],

[
"title"=>"Kitchen Cleaning",
"image"=>"assets/images/services/kitchen-cleaning.webp",
"icon"=>"assets/images/icons/kitchen-cleaning.png",
"description"=>"Remove grease, stains and germs for a spotless, hygienic kitchen.",
"url"=>"kitchen-cleaning.php"
],

[
"title"=>"Bathroom Cleaning",
"image"=>"assets/images/services/bathroom-cleaning.webp",
"icon"=>"assets/images/icons/bathroom-cleaning.png",
"description"=>"Sanitize tiles, fittings and surfaces for a sparkling clean bathroom.",
"url"=>"bathroom-cleaning.php"
],

[
"title"=>"Sofa Cleaning",
"image"=>"assets/images/services/sofa-cleaning.webp",
"icon"=>"assets/images/icons/sofa-cleaning.png",
"description"=>"Professional fabric and upholstery cleaning for fresh, stain-free sofas.",
"url"=>"sofa-cleaning.php"
],

];

?>

<section class="cln-services">

<div class="container">

<div class="cln-heading">

<span>OUR SERVICES</span>

<h2>Professional Cleaning Services</h2>

<p>
Choose from our most booked home cleaning services.
</p>

</div>

<div class="row g-4">

<?php foreach($services as $service){ ?>

<div class="col-lg-4 col-md-6">

<div class="cln-card">

<div class="cln-image">

<img src="<?= $service['image']; ?>" alt="<?= $service['title']; ?>">

</div>

<div class="cln-body">

<div class="cln-icon">

<img src="<?= $service['icon']; ?>">

</div>

<h3><?= $service['title']; ?></h3>

<p class="cln-desc">
    <?= $service['description']; ?>
</p>

<a href="<?= $service['url']; ?>" class="cln-arrow">
    <i class="bi bi-arrow-right"></i>
</a>

</div>

</div>

</div>

<?php } ?>

</div>

<div class="text-center mt-5">

<a href="services.php" class="cln-view">

View All Services →

</a>

</div>

</div>

</section>