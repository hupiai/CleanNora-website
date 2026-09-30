<footer class="cn-footer">

    <div class="cn-footer-main">

        <div class="cn-footer-container">

            <!-- BRAND -->
            <div class="cn-footer-brand">

                <a href="index.php" class="cn-footer-logo">
                    <img src="/assets/images/logo.png" alt="CleanNora">
                </a>

                <p>
                    Professional home cleaning and maid services
                    for homes, offices and apartments.
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
   aria-label="WhatsApp">
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


            <!-- QUICK LINKS -->
            <div class="cn-footer-column">

                <h4>Quick Links</h4>

                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="services.php">Explore Services</a></li>
                    <li><a href="who-we-are.php">Who We Are</a></li>
                    <li><a href="become-a-partner.php">Partner With Us</a></li>
                    <li><a href="support.php">Support</a></li>
                    <li><a href="cleanmart.php">InstaMart</a></li>
                    <li><a href="blog.php">Blog</a></li>
                </ul>

            </div>


            <!-- SERVICES -->
            <div class="cn-footer-column">

                <h4>Our Services</h4>

                <ul>
                    <li><a href="home-cleaning.php">Home Cleaning</a></li>
                    <li><a href="deep-cleaning.php">Deep Cleaning</a></li>
                    <li><a href="bathroom-cleaning.php">Bathroom Cleaning</a></li>
                    <li><a href="kitchen-cleaning.php">Kitchen Cleaning</a></li>
                    <li><a href="office-cleaning.php">Office Cleaning</a></li>
                    <li><a href="services.php">View All Services</a></li>
                </ul>

            </div>


            <!-- COMPANY -->
            <div class="cn-footer-column">

                <h4>Company</h4>

                <ul>
                    <li><a href="who-we-are.php">Who We Are</a></li>
                    <li><a href="support.php">Support</a></li>
                    <li><a href="terms-conditions.php">Terms &amp; Conditions</a></li>
                    <li><a href="privacy-policy.php">Privacy Policy</a></li>
                </ul>

            </div>


            <!-- CONTACT -->
            <div class="cn-footer-column cn-footer-contact">

                <h4>Contact Us</h4>

                <a href="tel:+919205080012" class="cn-footer-contact-item">
    <span class="cn-footer-contact-icon">
    <i class="bi bi-telephone-fill"></i>
</span>
    <span>+91 92050 80012</span>
</a>


                <a
                    href="mailto:info@cleannora.com"
                    class="cn-footer-contact-item"
                >
                    <span class="cn-footer-contact-icon">
                        <i class="bi bi-envelope"></i>
                    </span>

                    <span>info@cleannora.com</span>
                </a>


                <div class="cn-footer-contact-item">

                    <span class="cn-footer-contact-icon">
                        <i class="bi bi-geo-alt"></i>
                    </span>

                    <span>Noida, India</span>

                </div>

            </div>

        </div>

    </div>


    <!-- BOTTOM BAR -->
    <div class="cn-footer-bottom">

        <div class="cn-footer-bottom-inner">

            <p>
                © 2026 CleanNora. All Rights Reserved.
            </p>

        </div>

    </div>

</footer>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const slides = [

        {
            title: `
                Premium Home
                <span>Cleaning, Made<br>Effortless.</span>
            `,
            description: `
                Book trusted home cleaning professionals for spotless homes.
                Fast booking, verified experts, transparent pricing and
                exceptional service across Noida & Greater Noida.
            `,
            featureOne: "Verified Experts",
            featureTwo: "Same-Day Booking",
            featureThree: "100% Satisfaction"
        },

        {
            title: `
                Professional Cleaning
                <span>For Every<br>Corner.</span>
            `,
            description: `
                From deep cleaning to kitchen, bathroom and sofa cleaning,
                our trusted professionals make your home fresh and spotless.
            `,
            featureOne: "Trained Professionals",
            featureTwo: "Easy Booking",
            featureThree: "Premium Service"
        },

        {
            title: `
                Clean Homes.
                <span>Happy Lives.<br>Every Day.</span>
            `,
            description: `
                Experience hassle-free home services with transparent pricing,
                trusted experts and quality you can rely on every time.
            `,
            featureOne: "Trusted Service",
            featureTwo: "Quick Response",
            featureThree: "Verified Quality"
        }

    ];


    let currentSlide = 0;


    const heroTitle = document.getElementById("heroTitle");
    const heroDescription = document.getElementById("heroDescription");

    const featureOne = document.getElementById("featureOne");
    const featureTwo = document.getElementById("featureTwo");
    const featureThree = document.getElementById("featureThree");

    const heroLeft = document.querySelector(".hero-left");
    const heroRight = document.querySelector(".hero-right");

    const dots = document.querySelectorAll(".hero-slider-dot");

    const prevButton = document.getElementById("heroPrev");
    const nextButton = document.getElementById("heroNext");


    function showSlide(index) {

        if (index < 0) {
            index = slides.length - 1;
        }

        if (index >= slides.length) {
            index = 0;
        }

        currentSlide = index;


        heroLeft.classList.add("hero-slide-changing");
        heroRight.classList.add("hero-slide-changing");


        setTimeout(function () {

            const slide = slides[currentSlide];

            heroTitle.innerHTML = slide.title;
            heroDescription.innerHTML = slide.description;

            featureOne.textContent = slide.featureOne;
            featureTwo.textContent = slide.featureTwo;
            featureThree.textContent = slide.featureThree;


            dots.forEach(function (dot, dotIndex) {

                if (dotIndex === currentSlide) {
                    dot.classList.add("active");
                } else {
                    dot.classList.remove("active");
                }

            });


            heroLeft.classList.remove("hero-slide-changing");
            heroRight.classList.remove("hero-slide-changing");

        }, 250);

    }


    if (prevButton) {

        prevButton.addEventListener("click", function () {
            showSlide(currentSlide - 1);
        });

    }


    if (nextButton) {

        nextButton.addEventListener("click", function () {
            showSlide(currentSlide + 1);
        });

    }


    dots.forEach(function (dot) {

        dot.addEventListener("click", function () {

            const slideNumber = parseInt(
                this.getAttribute("data-slide")
            );

            showSlide(slideNumber);

        });

    });


    setInterval(function () {

        showSlide(currentSlide + 1);

    }, 6000);

});

</script>
