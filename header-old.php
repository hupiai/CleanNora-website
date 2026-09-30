<!DOCTYPE html>
<html lang="en">

<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']);
$pageName = strtolower(pathinfo($currentPage, PATHINFO_FILENAME));
$pageClass = 'public-page page-' . preg_replace('/[^a-z0-9-]/', '-', $pageName);
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cleannora Home Services</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Main CSS -->
<link href="assets/css/style.css" rel="stylesheet">
<link href="assets/css/responsive.css" rel="stylesheet">
<link href="assets/css/services-hero.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="<?php echo $pageClass; ?>">

<nav class="navbar navbar-expand-xl cleannora-navbar sticky-top">
  <div class="container">

    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="assets/images/logo.png" alt="Cleannora" class="site-logo">
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#cleannoraNavbar" aria-controls="cleannoraNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
<div class="collapse navbar-collapse" id="cleannoraNavbar">

    <!-- Center Menu -->
    <ul class="navbar-nav mx-auto">

        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'services.php') ? 'active' : ''; ?>" href="services.php">Explore Services</a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'plans-pricing.php') ? 'active' : ''; ?>" href="plans-pricing.php">Plans & Pricing</a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'why-cleannora.php') ? 'active' : ''; ?>" href="why-cleannora.php">Why Cleannora</a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'help.php') ? 'active' : ''; ?>" href="help.php">Help</a>
        </li>

    </ul>

    <!-- Right Button -->
    <div class="nav-btn-wrap">
        <a class="btn btn-book" href="book-now.php">Book Now</a>
    </div>

</div>

  </div>
</nav>