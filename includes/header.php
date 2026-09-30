<?php
require_once __DIR__ . '/festival-theme.php';

$currentPage = basename($_SERVER['SCRIPT_NAME']);
$pageName = strtolower(pathinfo($currentPage, PATHINFO_FILENAME));
$pageClass = 'public-page page-' . preg_replace('/[^a-z0-9-]/', '-', $pageName);

/*
|--------------------------------------------------------------------------
| Page SEO / Title
|--------------------------------------------------------------------------
| Individual pages can define $pageTitle and $pageDescription
| before including header.php.
*/

$siteTitle = !empty($pageTitle)
    ? $pageTitle
    : 'Cleannora Home Services';

$siteDescription = !empty($pageDescription)
    ? $pageDescription
    : 'Professional home cleaning and maid services by Cleannora.';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">

    <title><?= htmlspecialchars($siteTitle); ?></title>

    <meta
        name="description"
        content="<?= htmlspecialchars($siteDescription); ?>"
    >
    
    <?php
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$requestPath = rtrim($requestPath, '/');

if ($requestPath === '') {
    $requestPath = '/';
}

$canonicalUrl = 'https://cleannora.com' . $requestPath;
?>

<link rel="canonical" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <!-- Main CSS -->
    
    <link href="/assets/css/style.css?v=<?= time() ?>" rel="stylesheet">
<link href="/assets/css/responsive.css?v=<?= time() ?>" rel="stylesheet">
<link href="/assets/css/service-detail.css?v=<?= time() ?>" rel="stylesheet">
<link href="/assets/css/hero.css?v=<?= time() ?>" rel="stylesheet">

    <?php if (!empty($extraCss) && is_array($extraCss)): ?>

        <?php foreach ($extraCss as $cssFile): ?>

            <link
                href="<?= htmlspecialchars($cssFile); ?>?v=<?= time(); ?>"
                rel="stylesheet"
            >

        <?php endforeach; ?>

    <?php endif; ?>


    <?php if (!empty($cnFestival['active'])): ?>

        <link
            href="/assets/css/festival-theme.css?v=1.0.0"
            rel="stylesheet"
        >

    <?php endif; ?>
    
    <!-- =========================================================
     FIREBASE WEB SDK
========================================================= -->

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-app.js";
    import { getAuth } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-auth.js";
    import { firebaseConfig } from "/assets/js/firebase-config.js";

    const app = initializeApp(firebaseConfig);

    window.cleannoraFirebaseApp = app;
    window.cleannoraFirebaseAuth = getAuth(app);
</script>

</head>


<body
    class="<?= htmlspecialchars($pageClass); ?><?= !empty($cnFestival['active']) ? ' cn-festival-active cn-festival-' . htmlspecialchars($cnFestival['slug']) : ''; ?>"
>


<!-- =========================================================
     CLEANNORA NAVBAR
========================================================= -->

<nav class="cleannora-navbar">

    <div class="cleannora-nav-inner">


        <!-- LOGO -->
        <a href="/" class="cleannora-logo">
    <img
        src="/assets/images/logo.png"
        alt="Cleannora"
    >
</a>


        <!-- MENU -->
        <div class="cleannora-menu">


            <!-- HOME -->
            <a
                href="/"
                class="<?= ($currentPage === 'index.php') ? 'active' : ''; ?>"
            >
                Home
            </a>


            <!-- EXPLORE SERVICES -->
            <a
                href="/services.php"
                class="<?= ($currentPage === 'services.php') ? 'active' : ''; ?>"
            >
                Explore Services
            </a>


            <!-- WHO WE ARE -->
            <a
                href="/who-we-are.php"
                class="<?= ($currentPage === 'who-we-are.php') ? 'active' : ''; ?>"
            >
                Who We Are
            </a>


            <!-- SUPPORT -->
            <a
                href="/support.php"
                class="<?= ($currentPage === 'support.php') ? 'active' : ''; ?>"
            >
                Support
            </a>


            <!-- CLEANMART -->
            <a
                href="/cleanmart.php"
                class="<?= ($currentPage === 'cleanmart.php') ? 'active' : ''; ?>"
            >
                CleanMart
            </a>

        </div>


        <!-- DOWNLOAD NOW -->
        <a
            href="/book-now.php"
            class="cleannora-book-btn"
        >
            Download Now
        </a>

    </div>

</nav>


<?php if (!empty($cnFestival['active'])): ?>

    <script
        src="/assets/js/festival-theme.js?v=1.0.0"
        defer
    ></script>

<?php endif; ?>