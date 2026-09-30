<?php
include 'includes/header.php';
?>

<style>

/* =========================================================
   CLEANNNORA SERVICES PAGE
   ========================================================= */

body.page-services {
    background: #ffffff !important;
    color: #17372d;
    overflow-x: hidden;
}

/* ---------- HERO ---------- */

.cn-services-hero {
    position: relative;
    overflow: hidden;
    background:
        radial-gradient(
            circle at 88% 20%,
            rgba(244, 191, 25, 0.10),
            transparent 28%
        ),
        linear-gradient(
            135deg,
            #063a29 0%,
            #083d2b 58%,
            #062f23 100%
        );
    color: #ffffff;
}

.cn-services-hero-inner {
    position: relative;
    z-index: 2;
    min-height: 500px;
    display: grid;
    grid-template-columns: 0.95fr 1.05fr;
    align-items: start;
    gap: 55px;
    padding: 45px 0 0;
}

.cn-services-hero::before,
.cn-services-hero::after {
    content: "";
    position: absolute;
    border: 1px solid rgba(244, 191, 25, 0.14);
    border-radius: 50%;
    pointer-events: none;
}

.cn-services-hero::before {
    width: 520px;
    height: 520px;
    left: -300px;
    top: -260px;
}

.cn-services-hero::after {
    width: 430px;
    height: 430px;
    right: -240px;
    top: -220px;
}

.cn-services-copy {
    min-width: 0;
    max-width: 650px;
}

.cn-services-tag {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 22px;
    padding: 9px 15px;
    border: 1px solid rgba(244, 191, 25, 0.75);
    border-radius: 999px;
    color: #f4bf19;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.cn-services-copy h1 {
    margin: 0;
    color: #ffffff;
    font-size: clamp(48px, 5vw, 72px);
    font-weight: 850;
    line-height: 1;
    letter-spacing: -3px;
}

.cn-services-copy h1 span {
    color: #f4bf19;
}

.cn-services-copy p {
    max-width: 570px;
    margin: 25px 0 0;
    color: rgba(255,255,255,.80);
    font-size: 16px;
    line-height: 1.8;
}

.cn-services-points {
    display: flex;
    flex-wrap: wrap;
    gap: 14px 24px;
    margin-top: 30px;
}

.cn-services-point {
    display: flex;
    align-items: center;
    gap: 9px;
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
}

.cn-services-point i {
    width: 34px;
    height: 34px;
    display: grid;
    place-items: center;
    border: 1px solid rgba(244,191,25,.75);
    border-radius: 50%;
    color: #f4bf19;
}

/* ---------- HERO IMAGE ---------- */

.cn-services-visual {
    position: relative;
    min-width: 0;
}

.cn-services-photo {
    position: relative;
    overflow: hidden;
    height: 500px;
    border: 1px solid rgba(244,191,25,.35);
    border-radius: 30px;
    background: #092f24;
    box-shadow: 0 30px 80px rgba(0,0,0,.25);
}

.cn-services-photo img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
}

.cn-services-photo::after {
    content: "";
    position: absolute;
    inset: 0;
    background:
        linear-gradient(
            90deg,
            rgba(8,61,43,.52),
            rgba(8,61,43,.08) 55%,
            transparent
        );
    pointer-events: none;
}

/* ---------- RATING ---------- */

.cn-services-rating {
    position: absolute;
    z-index: 5;
    left: 28px;
    bottom: 24px;

    display: flex;
    align-items: center;
    gap: 15px;

    padding: 14px 18px;

    border: 1px solid rgba(244,191,25,.8);
    border-radius: 18px;

    background: rgba(5,49,36,.96);
    box-shadow: 0 18px 45px rgba(0,0,0,.22);
}

.cn-rating-avatars {
    display: flex;
}

.cn-rating-avatars span {
    width: 33px;
    height: 33px;

    display: grid;
    place-items: center;

    margin-left: -5px;

    border: 2px solid #ffffff;
    border-radius: 50%;

    background: #f2eee4;
    font-size: 15px;
}

.cn-rating-avatars span:first-child {
    margin-left: 0;
}

.cn-rating-stars {
    color: #f4bf19;
    font-size: 11px;
    letter-spacing: 2px;
}

.cn-services-rating strong {
    color: #ffffff;
    font-size: 22px;
}

.cn-services-rating small {
    margin-left: 7px;
    color: rgba(255,255,255,.60);
    font-size: 10px;
}

/* ---------- SERVICES SECTION ---------- */

.cn-services-section {
    padding: 82px 0 95px;
    background: #ffffff;
}

.cn-services-heading {
    margin-bottom: 30px;
}

.cn-services-kicker {
    display: block;
    margin-bottom: 9px;

    color: #d29f00;
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.cn-services-heading h2 {
    margin: 0;
    color: #083d2b;
    font-size: clamp(36px,4vw,52px);
    font-weight: 850;
    letter-spacing: -1.5px;
}

.cn-services-heading p {
    max-width: 650px;
    margin: 12px 0 0;

    color: #66756f;
    font-size: 15px;
    line-height: 1.75;
}

/* ---------- FILTERS ---------- */

.cn-service-filters {
    display: flex;
    gap: 8px;

    width: 100%;
    overflow-x: auto;

    padding: 6px;
    margin-bottom: 32px;

    border: 1px solid #e7ece8;
    border-radius: 16px;

    background: #f7f9f7;

    scrollbar-width: none;
}

.cn-service-filters::-webkit-scrollbar {
    display: none;
}

.cn-service-filter {
    flex: 0 0 auto;

    border: 0;
    border-radius: 11px;

    padding: 11px 18px;

    background: transparent;

    color: #52615b;
    font-size: 13px;
    font-weight: 800;

    white-space: nowrap;
    cursor: pointer;
}

.cn-service-filter.active {
    color: #083d2b;
    background: #f4bf19;
    box-shadow: 0 7px 18px rgba(244,191,25,.22);
}

/* ---------- CARDS ---------- */

.cn-service-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 22px;
}

.cn-service-card {
    display: flex;
    flex-direction: column;
    overflow: hidden;

    border: 1px solid #e5ebe7;
    border-radius: 18px;

    background: #ffffff;

    color: inherit;
    text-decoration: none;

    box-shadow: 0 8px 28px rgba(8,61,43,.055);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}

.cn-service-card:hover {
    transform: translateY(-6px);

    border-color: rgba(244,191,25,.65);

    box-shadow:
        0 22px 45px rgba(8,61,43,.12);
}

.cn-service-image {
    position: relative;
    overflow: hidden;
    height: 205px;
    background: #edf2ef;
}

.cn-service-image img {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;

    transition: transform .45s ease;
}

.cn-service-card:hover .cn-service-image img {
    transform: scale(1.045);
}

.cn-service-badge {
    position: absolute;
    z-index: 2;
    top: 13px;
    right: 13px;

    padding: 7px 11px;

    border-radius: 999px;

    background: #f4bf19;
    color: #083d2b;

    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
}

.cn-service-body {
    display: flex;
    flex: 1;
    flex-direction: column;

    padding: 20px;
}

.cn-service-icon {
    width: 45px;
    height: 45px;

    display: grid;
    place-items: center;

    margin-top: -43px;
    margin-bottom: 15px;

    position: relative;
    z-index: 3;

    border: 4px solid #ffffff;
    border-radius: 13px;

    background: #083d2b;
    color: #f4bf19;

    box-shadow: 0 10px 22px rgba(8,61,43,.18);
}

.cn-service-body h3 {
    margin: 0;

    color: #083d2b;

    font-size: 18px;
    font-weight: 850;
}

.cn-service-body p {
    min-height: 48px;

    margin: 9px 0 18px;

    color: #6a7772;

    font-size: 13px;
    line-height: 1.6;
}

.cn-service-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;

    margin-top: auto;
    padding-top: 14px;

    border-top: 1px solid #edf0ee;
}

.cn-service-price {
    color: #083d2b;
    font-size: 13px;
    font-weight: 900;
}

.cn-service-link {
    color: #d29f00;
    font-size: 12px;
    font-weight: 900;
    white-space: nowrap;
}

.cn-service-link i {
    transition: transform .2s ease;
}

.cn-service-card:hover .cn-service-link i {
    transform: translateX(4px);
}

.cn-service-card.hidden {
    display: none !important;
}

/* ---------- TRUST STRIP ---------- */

.cn-services-trust {
    display: grid;
    grid-template-columns: repeat(4, 1fr);

    margin-top: 55px;

    overflow: hidden;

    border: 1px solid #e8e4d9;
    border-radius: 20px;

    background: #fffcf5;
}

.cn-services-trust-item {
    position: relative;
    padding: 25px 22px;
}

.cn-services-trust-item + .cn-services-trust-item::before {
    content: "";

    position: absolute;

    left: 0;
    top: 25%;

    width: 1px;
    height: 50%;

    background: #e4e2da;
}

.cn-services-trust-item i {
    display: block;
    margin-bottom: 10px;

    color: #557267;
    font-size: 20px;
}

.cn-services-trust-item strong {
    display: block;
    margin-bottom: 6px;

    color: #083d2b;
    font-size: 13px;
}

.cn-services-trust-item span {
    display: block;

    color: #6a7772;
    font-size: 12px;
    line-height: 1.55;
}

/* ---------- RESPONSIVE ---------- */

@media (max-width: 1199px) {

    .cn-service-grid {
        grid-template-columns: repeat(3, minmax(0,1fr));
    }

}

@media (max-width: 991px) {

    .cn-services-hero-inner {
        grid-template-columns: 1fr;
        min-height: auto;
        gap: 40px;
    }

    .cn-services-copy {
        max-width: 760px;
    }

    .cn-services-visual {
        max-width: 760px;
        width: 100%;
        margin: 0 auto;
    }

    .cn-service-grid {
        grid-template-columns: repeat(2, minmax(0,1fr));
    }

    .cn-services-trust {
        grid-template-columns: repeat(2,1fr);
    }

    .cn-services-trust-item:nth-child(3),
    .cn-services-trust-item:nth-child(4) {
        border-top: 1px solid #e4e2da;
    }

    .cn-services-trust-item:nth-child(3)::before {
        display: none;
    }

}

@media (max-width: 767px) {

    .cn-services-hero-inner {
        padding: 55px 0 65px;
    }

    .cn-services-copy h1 {
        font-size: clamp(42px,10vw,58px);
        letter-spacing: -2px;
    }

    .cn-services-copy p {
        font-size: 14px;
    }

    .cn-services-points {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .cn-services-photo {
        height: 360px;
        border-radius: 22px;
    }

    .cn-services-rating {
        left: 14px;
        right: 14px;
        bottom: 14px;
    }

    .cn-services-section {
        padding: 65px 0 75px;
    }

    .cn-service-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .cn-services-trust {
        grid-template-columns: 1fr;
    }

    .cn-services-trust-item + .cn-services-trust-item {
        border-top: 1px solid #e4e2da;
    }

    .cn-services-trust-item + .cn-services-trust-item::before {
        display: none;
    }

}

@media (max-width: 480px) {

    .cn-services-points {
        grid-template-columns: 1fr;
    }

    .cn-services-photo {
        height: 300px;
    }

    .cn-rating-avatars {
        display: none;
    }

    .cn-services-rating {
        justify-content: center;
    }

    .cn-service-body {
        padding: 18px;
    }

}

/* =========================================================
   SERVICES HERO - FINAL FIXED ALIGNMENT
   ========================================================= */

body.page-services .cn-services-hero {
    min-height: auto !important;
    padding: 0 !important;
}

body.page-services .cn-services-hero-inner {
    min-height: 500px !important;
    display: grid !important;
    grid-template-columns: 0.95fr 1.05fr !important;
    align-items: center !important;
    gap: 55px !important;
    padding: 35px 0 35px !important;
}

/* LEFT CONTENT */
body.page-services .cn-services-copy {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    align-self: center !important;
}

body.page-services .cn-services-hero .cn-services-main-title {
    font-size: 58px !important;
    line-height: 1.08 !important;
    font-weight: 700 !important;
    letter-spacing: -1.4px !important;
    max-width: 620px !important;
    margin: 0 !important;
}

body.page-services .cn-services-hero .cn-services-main-title span {
    font-weight: 700 !important;
}

body.page-services .cn-services-hero .cn-services-tag {
    margin-bottom: 22px !important;
}

body.page-services .cn-services-copy > p {
    font-size: 16px !important;
    line-height: 1.75 !important;
    font-weight: 400 !important;
    max-width: 590px !important;
}

/* RIGHT IMAGE */
body.page-services .cn-services-visual {
    margin: 0 !important;
    padding: 0 !important;
    align-self: center !important;
}

body.page-services .cn-services-photo {
    height: 440px !important;
    overflow: hidden !important;
    border-radius: 26px !important;
}

body.page-services .cn-services-photo img {
    width: 100% !important;
    height: 100% !important;
    display: block !important;
    object-fit: cover !important;
    object-position: center center !important;
}

}

</style>

<main>

    <!-- =====================================================
         SERVICES HERO
         ===================================================== -->

    <section class="cn-services-hero">

        <div class="container">

            <div class="cn-services-hero-inner">

                <div class="cn-services-copy">

                    <div class="cn-services-tag">
                        <i class="bi bi-patch-check-fill"></i>
                        Trusted Cleaning Professionals
                    </div>

                    <h1 class="cn-services-main-title">
    Professional Cleaning Services for
    <span>Every Need</span>
</h1>

                    <p>
                        From everyday cleaning to deep cleaning,
                        Cleannora makes it simple to keep your home,
                        office and important spaces fresh, hygienic
                        and spotless.
                    </p>

                    <div class="cn-services-points">

                        <div class="cn-services-point">
                            <i class="bi bi-patch-check-fill"></i>
                            <span>Verified Experts</span>
                        </div>

                        <div class="cn-services-point">
                            <i class="bi bi-calendar-check-fill"></i>
                            <span>Secure Booking</span>
                        </div>

                        <div class="cn-services-point">
                            <i class="bi bi-shield-check"></i>
                            <span>Satisfaction Guaranteed</span>
                        </div>

                    </div>

                </div>


                <div class="cn-services-visual">

                    <div class="cn-services-photo">

                        <img
                            src="assets/images/services/services-hero.webp"
                            alt="Cleannora Professional Cleaning Service"
                            loading="eager"
                        >

                        <div class="cn-services-rating">

                            <div class="cn-rating-avatars">
                                <span>👩🏻</span>
                                <span>👨🏻</span>
                                <span>👩🏽</span>
                                <span>👨🏽</span>
                            </div>

                            <div>

                                <div class="cn-rating-stars">
                                    ★★★★★
                                </div>

                                <strong>4.8/5</strong>

                                <small>
                                    Trusted by Customers
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         SERVICES
         ===================================================== -->

    <section class="cn-services-section">

        <div class="container">

            <div class="cn-services-heading">

                <span class="cn-services-kicker">
                    What We Offer
                </span>

                <h2>
                    Our Cleaning Services
                </h2>

                <p>
                    Choose the right service for your home,
                    workplace or vehicle. Every service is
                    designed around quality, convenience and trust.
                </p>

            </div>


            <!-- FILTERS -->

            <div class="cn-service-filters">

                <button
                    type="button"
                    class="cn-service-filter active"
                    data-filter="all"
                >
                    All Services
                </button>

                <button
                    type="button"
                    class="cn-service-filter"
                    data-filter="home"
                >
                    Home Cleaning
                </button>

                <button
                    type="button"
                    class="cn-service-filter"
                    data-filter="deep"
                >
                    Deep Cleaning
                </button>

                <button
                    type="button"
                    class="cn-service-filter"
                    data-filter="specialized"
                >
                    Specialized Cleaning
                </button>

                <button
                    type="button"
                    class="cn-service-filter"
                    data-filter="office"
                >
                    Office Cleaning
                </button>

                <button
                    type="button"
                    class="cn-service-filter"
                    data-filter="other"
                >
                    Other Services
                </button>

            </div>


            <!-- SERVICE GRID -->

            <div class="cn-service-grid">

                <?php

                $services = [

                    [
                        'instant-maid.php',
                        'instant-maid.webp',
                        'Instant Maid',
                        'Verified maid services for daily household support and regular home assistance.',
                        '₹199',
                        'home',
                        'bi-house-heart-fill',
                        'Popular'
                    ],

                    [
                        'home-cleaning.php',
                        'home-cleaning.webp',
                        'Home Cleaning',
                        'Complete home cleaning for bedrooms, living rooms and common areas.',
                        '₹399',
                        'home',
                        'bi-house-check-fill',
                        ''
                    ],

                    [
                        'deep-cleaning.php',
                        'deep-cleaning.webp',
                        'Deep Cleaning',
                        'Detailed deep cleaning with stain removal and professional sanitization.',
                        '₹999',
                        'deep',
                        'bi-stars',
                        'Best Seller'
                    ],

                    [
                        'kitchen-cleaning.php',
                        'kitchen-cleaning.webp',
                        'Kitchen Cleaning',
                        'Professional kitchen degreasing and complete hygiene service.',
                        '₹499',
                        'specialized',
                        'bi-egg-fried',
                        ''
                    ],

                    [
                        'bathroom-cleaning.php',
                        'bathroom-cleaning.webp',
                        'Bathroom Cleaning',
                        'Bathroom sanitization, stain removal and a fresh sparkling finish.',
                        '₹399',
                        'specialized',
                        'bi-droplet-half',
                        ''
                    ],

                    [
                        'sofa-cleaning.php',
                        'sofa-cleaning.webp',
                        'Sofa Cleaning',
                        'Deep sofa shampoo cleaning and professional upholstery care.',
                        '₹499',
                        'specialized',
                        'bi-lamp-fill',
                        ''
                    ],

                    [
                        'carpet-cleaning.php',
                        'carpet-cleaning.webp',
                        'Carpet Cleaning',
                        'Deep carpet shampooing with stain and dust removal.',
                        '₹399',
                        'specialized',
                        'bi-grid-3x3-gap-fill',
                        ''
                    ],

                    [
                        'window-cleaning.php',
                        'window-cleaning.webp',
                        'Window Cleaning',
                        'Crystal-clear glass and window cleaning for homes and offices.',
                        '₹299',
                        'specialized',
                        'bi-window',
                        ''
                    ],

                    [
                        'office-cleaning.php',
                        'office-cleaning.webp',
                        'Office Cleaning',
                        'Professional office cleaning for a productive and hygienic workspace.',
                        '₹999',
                        'office',
                        'bi-building',
                        ''
                    ],

                    [
                        'car-cleaning.php',
                        'car-cleaning.webp',
                        'Car Cleaning',
                        'Professional interior and exterior car cleaning service.',
                        '₹599',
                        'other',
                        'bi-car-front-fill',
                        ''
                    ],

                    [
                        'move-in-out-cleaning.php',
                        'move-in-out-cleaning.webp',
                        'Move In / Out Cleaning',
                        'Complete move-in and move-out cleaning for a fresh new start.',
                        '₹1499',
                        'other',
                        'bi-box-seam-fill',
                        ''
                    ]

                ];

                foreach ($services as $service):

                ?>

                    <a
                        href="<?php echo htmlspecialchars($service[0]); ?>"
                        class="cn-service-card"
                        data-category="<?php echo htmlspecialchars($service[5]); ?>"
                    >

                        <div class="cn-service-image">

                            <img
                                src="assets/images/services/<?php echo htmlspecialchars($service[1]); ?>"
                                alt="<?php echo htmlspecialchars($service[2]); ?>"
                                loading="lazy"
                            >

                            <?php if (!empty($service[7])): ?>

                                <span class="cn-service-badge">
                                    <?php echo htmlspecialchars($service[7]); ?>
                                </span>

                            <?php endif; ?>

                        </div>


                        <div class="cn-service-body">

                            <div class="cn-service-icon">

                                <i class="bi <?php echo htmlspecialchars($service[6]); ?>"></i>

                            </div>


                            <h3>
                                <?php echo htmlspecialchars($service[2]); ?>
                            </h3>


                            <p>
                                <?php echo htmlspecialchars($service[3]); ?>
                            </p>


                            <div class="cn-service-bottom">

                                <span class="cn-service-price">
                                    From <?php echo htmlspecialchars($service[4]); ?>
                                </span>

                                <span class="cn-service-link">
                                    Explore Service
                                    <i class="bi bi-arrow-right"></i>
                                </span>

                            </div>

                        </div>

                    </a>

                <?php endforeach; ?>

            </div>


            <!-- =================================================
                 TRUST STRIP
                 ================================================= -->

            <div class="cn-services-trust">

                <div class="cn-services-trust-item">

                    <i class="bi bi-person-check"></i>

                    <strong>
                        Trained & Verified Professionals
                    </strong>

                    <span>
                        Background-verified and trained cleaning experts.
                    </span>

                </div>


                <div class="cn-services-trust-item">

                    <i class="bi bi-calendar-check"></i>

                    <strong>
                        Secure & Hassle-Free Booking
                    </strong>

                    <span>
                        Book online in minutes with secure payment options.
                    </span>

                </div>


                <div class="cn-services-trust-item">

                    <i class="bi bi-tags"></i>

                    <strong>
                        Transparent Pricing
                    </strong>

                    <span>
                        No hidden charges. What you see is what you pay.
                    </span>

                </div>


                <div class="cn-services-trust-item">

                    <i class="bi bi-shield-check"></i>

                    <strong>
                        100% Satisfaction Guarantee
                    </strong>

                    <span>
                        Not happy? We'll make it right.
                    </span>

                </div>

            </div>

        </div>

    </section>

</main>


<?php include 'includes/footer.php'; ?>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const filterButtons = document.querySelectorAll(".cn-service-filter");
    const serviceCards = document.querySelectorAll(".cn-service-card");

    filterButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            filterButtons.forEach(function (item) {
                item.classList.remove("active");
            });

            button.classList.add("active");

            const filter = button.getAttribute("data-filter");

            serviceCards.forEach(function (card) {

                const category = card.getAttribute("data-category");

                if (filter === "all" || category === filter) {
                    card.classList.remove("hidden");
                } else {
                    card.classList.add("hidden");
                }

            });

        });

    });

});
</script>