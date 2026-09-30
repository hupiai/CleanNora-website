<?php
$pageTitle = 'Home Services in Noida | Cleaning, Maid, Cook, Salon & Repair | CleanNora';
$pageDescription = 'Book trusted home services in Noida with CleanNora: home cleaning, instant maid, cook, bathroom & kitchen cleaning, sofa cleaning, home salon, AC service, electrician, plumber and more.';
include 'includes/header.php';
?>
<script type="application/ld+json">
<?= json_encode([
 '@context'=>'https://schema.org',
 '@type'=>'Organization',
 'name'=>'Clean Nora India Pvt. Ltd.',
 'alternateName'=>'CleanNora',
 'url'=>'https://cleannora.com/',
 'logo'=>'https://cleannora.com/assets/images/logo.png',
 'email'=>'info@cleannora.com',
 'telephone'=>'+91-92050-80012',
 'areaServed'=>[['@type'=>'City','name'=>'Noida']],
 'sameAs'=>[
   'https://www.facebook.com/getcleannora',
   'https://www.instagram.com/getcleannora/',
   'https://www.youtube.com/@getcleannora'
 ]
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) ?>
</script>
<script type="application/ld+json">
<?= json_encode([
 '@context'=>'https://schema.org',
 '@type'=>'Service',
 'name'=>'CleanNora Home Services in Noida',
 'provider'=>['@type'=>'Organization','name'=>'Clean Nora India Pvt. Ltd.','url'=>'https://cleannora.com/'],
 'areaServed'=>['@type'=>'City','name'=>'Noida'],
 'serviceType'=>['Home Cleaning','Instant Maid','Cook Service','Bathroom Cleaning','Kitchen Cleaning','Sofa Cleaning','Home Salon','AC Service and Repair','Electrician','Plumber','Chimney and Hob Cleaning','Car Cleaning']
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) ?>
</script>
<main>
<?php include 'includes/home/hero.php'; ?>
<?php include 'includes/home/services.php'; ?>
<?php include 'includes/home/instamart-highlight.php'; ?>
<?php include 'includes/home/local-seo.php'; ?>
<?php include 'includes/home/why.php'; ?>
<?php include 'includes/home/how.php'; ?>
<?php include 'includes/home/reviews.php'; ?>
<?php include 'includes/home/download-app.php'; ?>
<?php include 'includes/home/faq.php'; ?>
<?php include 'includes/home/cta.php'; ?>
</main>
<?php include 'includes/footer.php'; ?>