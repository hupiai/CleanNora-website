<?php

$services = [

[
"title"=>"Instant Maid",
"image"=>"assets/images/services/instant-maid.webp",
"icon"=>"assets/images/icons/instant-maid.png",
"price"=>"From ₹199 / 2 Hrs",
"url"=>"instant-maid-services.php"
],

[
"title"=>"Home Cleaning",
"image"=>"assets/images/services/home-cleaning.webp",
"icon"=>"assets/images/icons/home-cleaning.png",
"price"=>"From ₹399",
"url"=>"home-cleaning.php"
],

[
"title"=>"Deep Cleaning",
"image"=>"assets/images/services/deep-cleaning.webp",
"icon"=>"assets/images/icons/deep-cleaning.png",
"price"=>"From ₹999",
"url"=>"deep-cleaning.php"
],

[
"title"=>"Kitchen Cleaning",
"image"=>"assets/images/services/kitchen-cleaning.webp",
"icon"=>"assets/images/icons/kitchen-cleaning.png",
"price"=>"From ₹499",
"url"=>"kitchen-cleaning.php"
],

[
"title"=>"Bathroom Cleaning",
"image"=>"assets/images/services/bathroom-cleaning.webp",
"icon"=>"assets/images/icons/bathroom-cleaning.png",
"price"=>"From ₹349",
"url"=>"bathroom-cleaning.php"
],

[
"title"=>"Sofa Cleaning",
"image"=>"assets/images/services/sofa-cleaning.webp",
"icon"=>"assets/images/icons/sofa-cleaning.png",
"price"=>"From ₹599",
"url"=>"sofa-cleaning.php"
],

[
"title"=>"Carpet Cleaning",
"image"=>"assets/images/services/carpet-cleaning.webp",
"icon"=>"assets/images/icons/carpet-cleaning.png",
"price"=>"From ₹499",
"url"=>"carpet-cleaning.php"
],

[
"title"=>"Window Cleaning",
"image"=>"assets/images/services/window-cleaning.webp",
"icon"=>"assets/images/icons/window-cleaning.png",
"price"=>"From ₹299",
"url"=>"window-cleaning.php"
],

[
"title"=>"Office Cleaning",
"image"=>"assets/images/services/office-cleaning.webp",
"icon"=>"assets/images/icons/office-cleaning.png",
"price"=>"From ₹999",
"url"=>"office-cleaning.php"
],

[
"title"=>"Move In / Out Cleaning",
"image"=>"assets/images/services/move-in-out-cleaning.webp",
"icon"=>"assets/images/icons/move-in-out-cleaning.png",
"price"=>"From ₹1499",
"url"=>"move-in-out-cleaning.php"
]

];

?>

<section class="cln-services">

<div class="container">

<div class="cln-heading">

<span>Explore Services</span>

<h2>Professional Cleaning & Home Services</h2>

<p>Trusted cleaning professionals for every corner of your home.</p>

</div>

<div class="cln-grid">

<?php foreach(array_slice($services,0,6) as $service){ ?>

<div class="cln-card">

<div class="cln-image">

<img src="<?= $service['image']; ?>" alt="<?= $service['title']; ?>">

</div>

<div class="cln-body">

    <div class="cln-icon">
        <img src="<?= $service['icon']; ?>" alt="">
    </div>

    <h3><?= $service['title']; ?></h3>

    <div class="cln-price">
        <?= $service['price']; ?>
    </div>

    <a href="<?= $service['url']; ?>" class="cln-btn">
        Book Now
    </a>

</div>

</div>

<?php } ?>

</div>

<div class="cln-bottom">

<a href="services.php" class="cln-view">

View All Services →

</a>

</div>

</div>

</section>