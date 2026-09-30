<?php

require_once __DIR__ . '/includes/db.php';

$currentPage = basename($_SERVER['SCRIPT_NAME']);

$productsQuery = "
    SELECT *
    FROM mart_products
    WHERE status = 'active'
    ORDER BY
        is_best_seller DESC,
        is_featured DESC,
        id ASC
";

$productsResult = mysqli_query($conn, $productsQuery);

$productsResult = mysqli_query($conn, $productsQuery);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>CleanMart | Premium Cleaning Products by Cleannora</title>

    <meta name="description"
          content="Shop premium cleaning products and home care essentials from Cleannora through CleanMart.">

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet"
          href="assets/css/cleanmart.css">

</head>

<body>


<!-- =====================================================
     HEADER
===================================================== -->

<header class="cm-header">

    <div class="cm-header-inner">

        <a href="cleanmart.php"
           class="cm-logo">

            <img src="assets/images/logo.png"
                 alt="CleanMart">

        </a>


       <nav class="cm-nav">

    <a href="index.php">
        Home
    </a>

    <a href="services.php">
        Explore Services
    </a>

    <a href="about.php">
        Who We Are
    </a>

    <a href="help.php">
        Support
    </a>

    <a href="cleanmart.php"
       class="active">
        CleanMart
    </a>

</nav>


        <div class="cm-header-right">

            <div class="cm-search">

                <input
                    type="search"
                    placeholder="Search products...">

                <button type="button">

                    <i class="bi bi-search"></i>

                </button>

            </div>


            <a href="account.php"
               class="cm-icon-btn">

                <i class="bi bi-person"></i>

            </a>


            <a href="cart.php"
               class="cm-cart">

                <i class="bi bi-cart3"></i>

<span class="cart-count">
    <?php
    $cleanmartCartCount = 0;

    if (isset($_SESSION['mart_cart']) && is_array($_SESSION['mart_cart'])) {
        foreach ($_SESSION['mart_cart'] as $cartItem) {
            if (is_array($cartItem)) {
                $cleanmartCartCount += (int)($cartItem['quantity'] ?? 1);
            } else {
                $cleanmartCartCount += (int)$cartItem;
            }
        }
    }

    echo $cleanmartCartCount;
    ?>
</span>

            </a>

        </div>


        <button class="cm-mobile-menu"
                type="button">

            <i class="bi bi-list"></i>

        </button>

    </div>

</header>


<!-- =====================================================
     TRUST STRIP
===================================================== -->

<section class="cm-trust">

    <div class="cm-container">

        <div class="cm-trust-item">

            <i class="bi bi-patch-check"></i>

            <span>
                100% Original Products
            </span>

        </div>


        <div class="cm-trust-item">

            <i class="bi bi-shield-check"></i>

            <span>
                Quality You Can Trust
            </span>

        </div>


        <div class="cm-trust-item">

            <i class="bi bi-truck"></i>

            <span>
                Fast Delivery Across India
            </span>

        </div>


        <div class="cm-trust-item">

            <i class="bi bi-bag-check"></i>

            <span>
                Secure Payments
            </span>

        </div>

    </div>

</section>

<main>

</section>

<!-- =====================================================
     CLEANMART MAIN HERO SLIDER
===================================================== -->

<section class="cm-main-hero-slider">

    <div class="cm-main-hero-track">

        <!-- SLIDE 1 -->
        <div class="cm-main-hero-slide active">
            <div class="cm-main-hero-grid">
                <div class="cm-main-hero-image">
                    <img
                        src="assets/images/banners/cleanmart/cleanmart-banner-1.webp"
                        alt="CleanMart Premium Cleaning Products">
                </div>
            </div>
        </div>


        <!-- SLIDE 2 -->
        <div class="cm-main-hero-slide">
            <div class="cm-main-hero-grid">
                <div class="cm-main-hero-image">
                    <img
                        src="assets/images/banners/cleanmart/cleanmart-banner-2.webp"
                        alt="CleanMart Special Offer">
                </div>
            </div>
        </div>


        <!-- SLIDE 3 -->
        <div class="cm-main-hero-slide">
            <div class="cm-main-hero-grid">
                <div class="cm-main-hero-image">
                    <img
                        src="assets/images/banners/cleanmart/cleanmart-banner-3.webp"
                        alt="CleanMart Fast Delivery">
                </div>
            </div>
        </div>

    </div>


    <!-- PREVIOUS BUTTON -->
    <button
        type="button"
        class="cm-main-hero-arrow cm-main-hero-prev"
        aria-label="Previous slide">

        <i class="bi bi-chevron-left"></i>

    </button>


    <!-- NEXT BUTTON -->
    <button
        type="button"
        class="cm-main-hero-arrow cm-main-hero-next"
        aria-label="Next slide">

        <i class="bi bi-chevron-right"></i>

    </button>


    <!-- SLIDER DOTS -->
    <div class="cm-main-hero-dots">

        <button
            type="button"
            class="cm-main-hero-dot active"
            aria-label="Slide 1">
        </button>

        <button
            type="button"
            class="cm-main-hero-dot"
            aria-label="Slide 2">
        </button>

        <button
            type="button"
            class="cm-main-hero-dot"
            aria-label="Slide 3">
        </button>

    </div>

</section>

<!-- =====================================================
     BENEFITS BAR
===================================================== -->

<section class="cm-benefits-wrap">

    <div class="cm-container">

        <div class="cm-benefits">

            <div class="cm-benefit">

                <i class="bi bi-award"></i>

                <div>

                    <strong>
                        Trusted Quality
                    </strong>

                    <span>
                        Carefully selected
                        high-quality products
                    </span>

                </div>

            </div>


            <div class="cm-benefit">

                <i class="bi bi-shield-check"></i>

                <div>

                    <strong>
                        Safe & Effective
                    </strong>

                    <span>
                        Safe for your family,
                        pets & surfaces
                    </span>

                </div>

            </div>


            <div class="cm-benefit">

                <i class="bi bi-tag"></i>

                <div>

                    <strong>
                        Best Value
                    </strong>

                    <span>
                        Premium products at
                        the best prices
                    </span>

                </div>

            </div>


            <div class="cm-benefit">

                <i class="bi bi-leaf"></i>

                <div>

                    <strong>
                        Eco-Friendly
                    </strong>

                    <span>
                        Better for your home
                        & environment
                    </span>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =====================================================
     CATEGORIES
===================================================== -->



<!-- =====================================================
     PRODUCTS
===================================================== -->

<section class="cm-section cm-products">

    <div class="cm-container">

        <div class="cm-section-title-row">

            <div>

                <div class="cm-kicker">
                    BEST SELLING PRODUCTS
                </div>

                <h2>
                    Top Picks for You
                </h2>

            </div>


            <a href="products.php"
               class="cm-view-all">

                View All Products

            </a>

        </div>


        <div class="cm-product-grid">

<?php if ($productsResult && mysqli_num_rows($productsResult) > 0): ?>

    <?php while ($product = mysqli_fetch_assoc($productsResult)): ?>

        <?php
            $mrp = (float)$product['mrp'];
            $salePrice = (float)$product['sale_price'];

            $discount = 0;

            if ($mrp > 0 && $salePrice > 0 && $mrp > $salePrice) {
                $discount = round((($mrp - $salePrice) / $mrp) * 100);
            }
        ?>

        <article class="cm-product-card"
                 data-product-id="<?php echo (int)$product['id']; ?>">

            <div class="cm-product-image">

                <?php if ((int)$product['is_best_seller'] === 1): ?>
                    <span class="cm-badge">BEST SELLER</span>

                <?php elseif ((int)$product['is_new'] === 1): ?>
                    <span class="cm-badge cm-badge-new">NEW</span>
                <?php endif; ?>

                <button type="button"
                        class="cm-wishlist"
                        data-product-id="<?php echo (int)$product['id']; ?>">
                    <i class="bi bi-heart"></i>
                </button>

                <img
                    src="<?php echo htmlspecialchars($product['main_image']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>">

            </div>

            <div class="cm-product-body">

                <h3>
                    <?php echo htmlspecialchars($product['name']); ?>
                </h3>

                <div class="cm-rating">
                    ★★★★★
                    <span>(0)</span>
                </div>

                <div class="cm-price">

                    <strong>
                        ₹<?php echo number_format($salePrice, 0); ?>
                    </strong>

                    <?php if ($mrp > $salePrice): ?>

                        <del>
                            ₹<?php echo number_format($mrp, 0); ?>
                        </del>

                        <span>
                            <?php echo $discount; ?>% OFF
                        </span>

                    <?php endif; ?>

                </div>

                <div class="cm-cart-controls"
     data-product-id="<?php echo (int)$product['id']; ?>">

    <button type="button"
            class="cm-add-cart"
            data-product-id="<?php echo (int)$product['id']; ?>">
        Add to Cart
        <i class="bi bi-cart3"></i>
    </button>

    <div class="cm-quantity-controls" style="display:none;">
        <button type="button" class="cm-qty-btn cm-minus">−</button>

        <span class="cm-qty-number">1</span>

        <button type="button" class="cm-qty-btn cm-plus">+</button>
    </div>

</div>

            </div>

        </article>

    <?php endwhile; ?>

<?php else: ?>

    <div class="cm-no-products">
        No products available right now.
    </div>

<?php endif; ?>

        </div>

    </div>

</section>


<!-- =====================================================
     OFFER BANNER
===================================================== -->

<section class="cm-offer-section">

    <div class="cm-container">

        <div class="cm-offer">

            <div class="cm-offer-content">

                <div class="cm-offer-kicker">
                    LIMITED TIME OFFER
                </div>

                <h2>
                    Flat 20% OFF
                </h2>

                <p>
                    On Orders Above ₹999
                </p>

                <a href="deals.php"
                   class="cm-offer-btn">

                    Shop the Deal

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>


            <div class="cm-offer-products">

    <img
        src="assets/images/cleanmart/offer-products.webp"
        alt="Cleannora Cleaning Products Offer">

</div>


            <div class="cm-offer-badge">
                20%
                <small>OFF</small>
            </div>

        </div>

    </div>

</section>


<!-- =====================================================
     WHY CHOOSE
===================================================== -->

<section class="cm-why">

    <div class="cm-container">

        <div class="cm-section-heading">

            <div class="cm-kicker">
                WHY CHOOSE CLEANNORA?
            </div>

        </div>


        <div class="cm-why-grid">


            <div class="cm-why-item">

                <i class="bi bi-patch-check"></i>

                <div>

                    <strong>
                        100% Original
                    </strong>

                    <span>
                        Products
                    </span>

                </div>

            </div>


            <div class="cm-why-item">

                <i class="bi bi-lock"></i>

                <div>

                    <strong>
                        Secure
                    </strong>

                    <span>
                        Payments
                    </span>

                </div>

            </div>


            <div class="cm-why-item">

                <i class="bi bi-truck"></i>

                <div>

                    <strong>
                        Fast & Reliable
                    </strong>

                    <span>
                        Delivery
                    </span>

                </div>

            </div>


            <div class="cm-why-item">

                <i class="bi bi-arrow-repeat"></i>

                <div>

                    <strong>
                        Easy Returns
                    </strong>

                    <span>
                        & Refunds
                    </span>

                </div>

            </div>


            <div class="cm-why-item">

                <i class="bi bi-headset"></i>

                <div>

                    <strong>
                        Dedicated
                    </strong>

                    <span>
                        Support
                    </span>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =====================================================
     NEWSLETTER
===================================================== -->

<section class="cm-newsletter">

    <div class="cm-container">

        <div class="cm-newsletter-grid">

            <div>

                <h3>
                    Stay Clean, Stay Updated
                </h3>

                <p>
                    Subscribe for offers, cleaning tips
                    & new product updates.
                </p>

            </div>


            <form class="cm-newsletter-form">

                <input
                    type="email"
                    placeholder="Enter your email address"
                    required>

                <button type="submit">
                    Subscribe
                </button>

            </form>


            <div class="cm-newsletter-benefit">

                <i class="bi bi-truck"></i>

                <div>

                    <strong>
                        Free Delivery
                    </strong>

                    <span>
                        On orders above ₹499
                    </span>

                </div>

            </div>


            <div class="cm-newsletter-benefit">

                <i class="bi bi-arrow-repeat"></i>

                <div>

                    <strong>
                        Easy Returns
                    </strong>

                    <span>
                        Within 7 days
                    </span>

                </div>

            </div>


            <div class="cm-newsletter-benefit">

                <i class="bi bi-headset"></i>

                <div>

                    <strong>
                        24/7 Support
                    </strong>

                    <span>
                        We're here to help
                    </span>

                </div>

            </div>

        </div>

    </div>

</section>


</main>


<!-- =====================================================
     FOOTER
===================================================== -->

<footer class="cm-footer">

    <div class="cm-container">

        <div class="cm-footer-grid">


            <div class="cm-footer-brand">

                <img
                    src="assets/images/logo.png"
                    alt="CleanMart">

                <p>
                    Your one-stop shop for premium
                    cleaning products. Quality you can
                    trust, every time.
                </p>


                <div class="cn-footer-socials">

                    <a
                        href="https://www.facebook.com/getcleannora"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Facebook"
                    >
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a
                        href="https://www.instagram.com/getcleannora/"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Instagram"
                    >
                        <i class="bi bi-instagram"></i>
                    </a>

                    <a href="https://wa.me/919205080012"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="WhatsApp"
                    >
                        <i class="bi bi-whatsapp"></i>
                    </a>

                    <a
                        href="https://www.youtube.com/@getcleannora"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="YouTube"
                    >
                        <i class="bi bi-youtube"></i>
                    </a>

                </div>

            </div>


            <div class="cm-footer-column">

                <h4>
                    Quick Links
                </h4>

                <a href="cleanmart.php">
                    Home
                </a>

                <a href="products.php">
                    All Products
                </a>

                <a href="categories.php">
                    Categories
                </a>

                <a href="deals.php">
                    Deals
                </a>

                <a href="about-cleanmart.php">
                    About Us
                </a>

            </div>


            <div class="cm-footer-column">

                <h4>
                    Customer Service
                </h4>

                <a href="account.php">
                    My Account
                </a>

                <a href="track-order.php">
                    Order Tracking
                </a>

                <a href="#">
                    Returns & Refunds
                </a>

                <a href="#">
                    Shipping Info
                </a>

                <a href="help.php">
                    FAQs
                </a>

            </div>


            <div class="cm-footer-column">

                <h4>
                    Categories
                </h4>

                <a href="#">
                    Floor Care
                </a>

                <a href="#">
                    Surface Cleaners
                </a>

                <a href="#">
                    Bathroom Care
                </a>

                <a href="#">
                    Kitchen Care
                </a>

                <a href="#">
                    Laundry Care
                </a>

            </div>


            <div class="cm-footer-column">

                <h4>
                    Contact Us
                </h4>

                <a href="tel:+919205080012" class="cn-footer-contact-item">
    <span class="cn-footer-contact-icon">...</span>
    <span>+91 92050 80012</span>
</a>

                <a href="mailto:info@cleannora.com">
                    <i class="bi bi-envelope"></i>
                    info@cleannora.com
                </a>

                <span>
                    <i class="bi bi-geo-alt"></i>
                    Noida, Uttar Pradesh, India
                </span>

            </div>

        </div>


        <div class="cm-footer-bottom">

            <span>
                © 2026 CleanMart by Cleannora.
                All Rights Reserved.
            </span>

            <div>

                <span>
                    Visa
                </span>

                <span>
                    Mastercard
                </span>

                <span>
                    UPI
                </span>

                <span>
                    Paytm
                </span>

            </div>

        </div>

    </div>

</footer>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const slides = document.querySelectorAll(".cm-main-hero-slide");
    const dots = document.querySelectorAll(".cm-main-hero-dot");

    const prevBtn = document.querySelector(".cm-main-hero-prev");
    const nextBtn = document.querySelector(".cm-main-hero-next");

    if (!slides.length) return;

    let currentSlide = 0;
    let autoSlide;


    function showSlide(index) {

        if (index >= slides.length) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = slides.length - 1;
        } else {
            currentSlide = index;
        }


        slides.forEach(function (slide) {
            slide.classList.remove("active");
        });

        dots.forEach(function (dot) {
            dot.classList.remove("active");
        });


        slides[currentSlide].classList.add("active");

        if (dots[currentSlide]) {
            dots[currentSlide].classList.add("active");
        }
    }


    function nextSlide() {
        showSlide(currentSlide + 1);
    }


    function prevSlide() {
        showSlide(currentSlide - 1);
    }


    function startAutoSlide() {

        clearInterval(autoSlide);

        autoSlide = setInterval(function () {
            nextSlide();
        }, 5000);

    }


    if (nextBtn) {

        nextBtn.addEventListener("click", function () {
            nextSlide();
            startAutoSlide();
        });

    }


    if (prevBtn) {

        prevBtn.addEventListener("click", function () {
            prevSlide();
            startAutoSlide();
        });

    }


    dots.forEach(function (dot, index) {

        dot.addEventListener("click", function () {

            showSlide(index);
            startAutoSlide();

        });

    });


    /* MOBILE SWIPE */

    let touchStartX = 0;

    const slider = document.querySelector(".cm-main-hero-slider");

    if (slider) {

        slider.addEventListener("touchstart", function (event) {

            touchStartX =
                event.changedTouches[0].screenX;

        }, { passive: true });


        slider.addEventListener("touchend", function (event) {

            const touchEndX =
                event.changedTouches[0].screenX;

            const difference =
                touchStartX - touchEndX;


            if (Math.abs(difference) > 50) {

                if (difference > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }

                startAutoSlide();
            }

        }, { passive: true });

    }


    showSlide(0);

    startAutoSlide();

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.addEventListener('click', function (event) {

        const addButton = event.target.closest('.cm-add-cart');

        if (addButton) {

            event.preventDefault();
            event.stopPropagation();

            const wrapper =
                addButton.closest('.cm-cart-controls');

            if (!wrapper) return;

            const productId =
                wrapper.getAttribute('data-product-id');

            if (!productId) {
                console.error('Product ID missing.');
                return;
            }

            // Prevent double click
            if (addButton.dataset.processing === '1') {
                return;
            }

            addButton.dataset.processing = '1';
            addButton.disabled = true;
            addButton.innerHTML = 'Adding...';

            const formData = new FormData();

            formData.append('action', 'add');
            formData.append('product_id', productId);

            fetch('includes/mart-cart.php', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })

            .then(function (response) {
                return response.json();
            })

            .then(function (data) {

                if (!data.success) {
                    throw new Error(
                        data.message || 'Unable to add product.'
                    );
                }

                // Update cart count
                document
                    .querySelectorAll('.cart-count')
                    .forEach(function (counter) {
                        counter.textContent =
                            data.cart_count;
                    });

                const quantityBox =
                    wrapper.querySelector(
                        '.cm-quantity-controls'
                    );

                const quantityNumber =
                    wrapper.querySelector(
                        '.cm-qty-number'
                    );

                // First add = exactly 1
                if (quantityNumber) {
                    quantityNumber.textContent = '1';
                }

                addButton.style.display = 'none';

                if (quantityBox) {
                    quantityBox.style.display = 'flex';
                }

                addButton.dataset.processing = '0';
                addButton.disabled = false;

            })

            .catch(function (error) {

                console.error(error);

                alert(
                    error.message ||
                    'Unable to add product to cart.'
                );

                addButton.innerHTML =
                    'Add to Cart <i class="bi bi-cart3"></i>';

                addButton.dataset.processing = '0';
                addButton.disabled = false;

            });

            return;
        }


        // ==========================================
        // PLUS
        // ==========================================

        const plusButton =
            event.target.closest('.cm-plus');

        if (plusButton) {

            event.preventDefault();

            const wrapper =
                plusButton.closest('.cm-cart-controls');

            if (!wrapper) return;

            const quantityNumber =
                wrapper.querySelector('.cm-qty-number');

            let quantity =
                parseInt(quantityNumber.textContent, 10) || 1;

            quantity++;

            quantityNumber.textContent = quantity;

            updateCartQuantity(
                wrapper,
                quantity
            );

            return;
        }


        // ==========================================
        // MINUS
        // ==========================================

        const minusButton =
            event.target.closest('.cm-minus');

        if (minusButton) {

            event.preventDefault();

            const wrapper =
                minusButton.closest('.cm-cart-controls');

            if (!wrapper) return;

            const quantityNumber =
                wrapper.querySelector('.cm-qty-number');

            const addButton =
                wrapper.querySelector('.cm-add-cart');

            const quantityBox =
                wrapper.querySelector(
                    '.cm-quantity-controls'
                );

            let quantity =
                parseInt(quantityNumber.textContent, 10) || 1;

            quantity--;

            if (quantity <= 0) {

                const productId =
                    wrapper.getAttribute(
                        'data-product-id'
                    );

                removeCartProduct(productId);

                quantityNumber.textContent = '1';

                quantityBox.style.display = 'none';
                addButton.style.display = 'flex';

            } else {

                quantityNumber.textContent = quantity;

                updateCartQuantity(
                    wrapper,
                    quantity
                );
            }

            return;
        }

    });


    // ==========================================
    // UPDATE QUANTITY
    // ==========================================

    function updateCartQuantity(wrapper, quantity) {

        const productId =
            wrapper.getAttribute('data-product-id');

        if (!productId) return;

        const formData = new FormData();

        formData.append('action', 'update');
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        fetch('includes/mart-cart.php', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {

            if (data.success && data.cart_count !== undefined) {

                document
                    .querySelectorAll('.cart-count')
                    .forEach(function (counter) {
                        counter.textContent =
                            data.cart_count;
                    });
            }

        })
        .catch(function (error) {
            console.error(
                'Quantity update error:',
                error
            );
        });
    }


    // ==========================================
    // REMOVE PRODUCT
    // ==========================================

    function removeCartProduct(productId) {

        if (!productId) return;

        const formData = new FormData();

        formData.append('action', 'remove');
        formData.append('product_id', productId);

        fetch('includes/mart-cart.php', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {

            if (data.success) {

                document
                    .querySelectorAll('.cart-count')
                    .forEach(function (counter) {
                        counter.textContent =
                            data.cart_count || 0;
                    });
            }

        })
        .catch(function (error) {
            console.error(
                'Remove error:',
                error
            );
        });
    }

});
</script>