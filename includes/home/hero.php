<section class="cn-banner-slider">

    <div class="cn-banner-track">

        <!-- Banner 1 -->
        <div class="cn-banner-slide is-active">
            <img
                src="assets/images/banners/clean-home-better-life-banner.webp"
                alt="Clean home better life"
                loading="eager"
            >
        </div>

        <!-- Banner 2 -->
        <div class="cn-banner-slide">
            <img
                src="assets/images/banners/cleaning-offer-banner.webp"
                alt="Cleaning special offer"
                loading="lazy"
            >
        </div>

        <!-- Banner 3 -->
        <div class="cn-banner-slide">
            <img
                src="assets/images/banners/instant-cleaning-banner.webp"
                alt="Instant cleaning service"
                loading="lazy"
            >
        </div>

    </div>


    <!-- Previous -->
    <button
        type="button"
        class="cn-banner-arrow cn-banner-prev"
        aria-label="Previous banner"
    >
        &#10094;
    </button>


    <!-- Next -->
    <button
        type="button"
        class="cn-banner-arrow cn-banner-next"
        aria-label="Next banner"
    >
        &#10095;
    </button>


    <!-- Dots -->
    <div class="cn-banner-dots">

        <button
            type="button"
            class="cn-banner-dot is-active"
            aria-label="Banner 1"
        ></button>

        <button
            type="button"
            class="cn-banner-dot"
            aria-label="Banner 2"
        ></button>

        <button
            type="button"
            class="cn-banner-dot"
            aria-label="Banner 3"
        ></button>

    </div>

</section>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const slider = document.querySelector('.cn-banner-slider');

    if (!slider) return;

    const slides = slider.querySelectorAll('.cn-banner-slide');
    const dots = slider.querySelectorAll('.cn-banner-dot');

    const prevButton = slider.querySelector('.cn-banner-prev');
    const nextButton = slider.querySelector('.cn-banner-next');

    let currentIndex = 0;
    let autoPlay;


    function showBanner(index) {

        currentIndex = index;

        if (currentIndex >= slides.length) {
            currentIndex = 0;
        }

        if (currentIndex < 0) {
            currentIndex = slides.length - 1;
        }


        slides.forEach(function (slide) {
            slide.classList.remove('is-active');
        });

        dots.forEach(function (dot) {
            dot.classList.remove('is-active');
        });


        slides[currentIndex].classList.add('is-active');

        if (dots[currentIndex]) {
            dots[currentIndex].classList.add('is-active');
        }

    }


    function nextBanner() {
        showBanner(currentIndex + 1);
    }


    function previousBanner() {
        showBanner(currentIndex - 1);
    }


    function startAutoPlay() {

        clearInterval(autoPlay);

        autoPlay = setInterval(function () {
            nextBanner();
        }, 5000);

    }


    nextButton.addEventListener('click', function () {

        nextBanner();
        startAutoPlay();

    });


    prevButton.addEventListener('click', function () {

        previousBanner();
        startAutoPlay();

    });


    dots.forEach(function (dot, index) {

        dot.addEventListener('click', function () {

            showBanner(index);
            startAutoPlay();

        });

    });


    slider.addEventListener('mouseenter', function () {
        clearInterval(autoPlay);
    });


    slider.addEventListener('mouseleave', function () {
        startAutoPlay();
    });


    startAutoPlay();

});
</script>