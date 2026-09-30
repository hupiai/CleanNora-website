<?php include 'includes/header-v2.php'; ?>

<main class="cn-services-page">

    <!-- =====================================================
         SERVICES SECTION
    ====================================================== -->
    <section class="cn-services-section">

        <div class="container">

            <!-- HEADING -->
            <div class="cn-services-heading">

                <div>

                    <span class="cn-section-label">
                        WHAT WE OFFER
                    </span>

                    <h2>
                        Our Cleaning Services
                    </h2>

                </div>

            </div>

<!-- CATEGORY FILTERS -->
<div class="cn-service-filters">

    <button
        type="button"
        class="cn-service-filter active"
        data-filter="all">
        All Services
    </button>

    <button
        type="button"
        class="cn-service-filter"
        data-filter="home">
        Home Cleaning
    </button>

    <button
        type="button"
        class="cn-service-filter"
        data-filter="deep">
        Deep Cleaning
    </button>

</div>

            <!-- =====================================================
                 SERVICE GRID
            ====================================================== -->
            <div class="cn-services-grid">


                <!-- INSTANT MAID -->
                <a
                    href="instant-maid.php"
                    class="cn-service-card"
                    data-category="home">

                    <div class="cn-service-image">

                        <img
                            src="assets/images/services/instant-maid.webp"
                            alt="Instant Maid">

                        <span class="cn-service-icon">
                            <i class="bi bi-person-check"></i>
                        </span>

                    </div>

                    <div class="cn-service-content">

                        <h3>Instant Maid</h3>

                        <p>
                            Get a maid on-demand for quick and efficient cleaning.
                        </p>

                    </div>

                </a>


                <!-- HOME CLEANING -->
                <a
                    href="home-cleaning.php"
                    class="cn-service-card"
                    data-category="home">

                    <div class="cn-service-image">

                        <img
                            src="assets/images/services/home-cleaning.webp"
                            alt="Home Cleaning">

                        <span class="cn-service-icon">
                            <i class="bi bi-house-door"></i>
                        </span>

                    </div>

                    <div class="cn-service-content">

                        <h3>Home Cleaning</h3>

                        <p>
                            Regular home cleaning for a fresh and healthy living space.
                        </p>

                    </div>

                </a>


                <!-- DEEP CLEANING -->
                <a
                    href="deep-cleaning.php"
                    class="cn-service-card"
                    data-category="deep">

                    <div class="cn-service-image">

                        <img
                            src="assets/images/services/deep-cleaning.webp"
                            alt="Deep Cleaning">

                        <span class="cn-service-icon">
                            <i class="bi bi-stars"></i>
                        </span>

                    </div>

                    <div class="cn-service-content">

                        <h3>Deep Cleaning</h3>

                        <p>
                            Thorough deep cleaning to remove dirt, dust and bacteria.
                        </p>

                    </div>

                </a>


                <!-- KITCHEN CLEANING -->
                <a
                    href="kitchen-cleaning.php"
                    class="cn-service-card"
                    data-category="specialized">

                    <div class="cn-service-image">

                        <img
                            src="assets/images/services/kitchen-cleaning.webp"
                            alt="Kitchen Cleaning">

                        <span class="cn-service-icon">
                            <i class="bi bi-cup-hot"></i>
                        </span>

                    </div>

                    <div class="cn-service-content">

                        <h3>Kitchen Cleaning</h3>

                        <p>
                            Complete cleaning and degreasing for a hygienic kitchen.
                        </p>

                    </div>

                </a>


                <!-- BATHROOM CLEANING -->
                <a
                    href="bathroom-cleaning.php"
                    class="cn-service-card"
                    data-category="specialized">

                    <div class="cn-service-image">

                        <img
                            src="assets/images/services/bathroom-cleaning.webp"
                            alt="Bathroom Cleaning">

                        <span class="cn-service-icon">
                            <i class="bi bi-droplet"></i>
                        </span>

                    </div>

                    <div class="cn-service-content">

                        <h3>Bathroom Cleaning</h3>

                        <p>
                            Deep cleaning and disinfection for a spotless bathroom.
                        </p>

                    </div>

                </a>


                <!-- SOFA CLEANING -->
                <a
                    href="sofa-cleaning.php"
                    class="cn-service-card"
                    data-category="specialized">

                    <div class="cn-service-image">

                        <img
                            src="assets/images/services/sofa-cleaning.webp"
                            alt="Sofa Cleaning">

                        <span class="cn-service-icon">
                            <i class="bi bi-house-heart"></i>
                        </span>

                    </div>

                    <div class="cn-service-content">

                        <h3>Sofa Cleaning</h3>

                        <p>
                            Remove stains, dust and odors for a fresh and clean sofa.
                        </p>

                    </div>

                </a>


            </div>


            <!-- VIEW ALL -->
            <div class="cn-services-view-all">

                <a href="services.php">

                    View All Services

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>

        </div>

    </section>

</main>


<!-- =====================================================
     SERVICE FILTER JAVASCRIPT
===================================================== -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const filterButtons = document.querySelectorAll(".cn-service-filter");
    const serviceCards = document.querySelectorAll(".cn-service-card");

    filterButtons.forEach(function (button) {

        button.addEventListener("click", function (event) {

            event.preventDefault();

            const filterValue = this.getAttribute("data-filter");

            /* Active tab change */
            filterButtons.forEach(function (btn) {
                btn.classList.remove("active");
            });

            this.classList.add("active");


            /* Filter services */
            serviceCards.forEach(function (card) {

                const category = card.getAttribute("data-category");

                if (
                    filterValue === "all" ||
                    category === filterValue
                ) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }

            });

        });

    });

});
</script>