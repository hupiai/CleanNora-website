<?php

$extraCss = [
    './assets/css/support.css'
];

include 'includes/header.php';

?>

<main class="support-page">

    <!-- =====================================================
         HERO
         ===================================================== -->
    <section class="support-hero">

        <div class="support-hero-container">

            <div class="support-hero-content">

                <div class="support-hero-badge">
                    <i class="bi bi-headset"></i>
                    We Are Here To Help
                </div>

                <h1>
                    How Can We
                    <span>Help You?</span>
                </h1>

                <p class="support-hero-description">
                    Our support team is always ready to assist you.
                    Find answers, get help or reach out to us anytime.
                </p>

                <form
                    class="support-search"
                    id="supportSearchForm"
                >

                    <input
                        type="search"
                        id="supportSearchInput"
                        placeholder="Search for help articles..."
                        autocomplete="off"
                    >

                    <button
                        type="submit"
                        aria-label="Search"
                    >
                        <i class="bi bi-search"></i>
                    </button>

                </form>

            </div>


            <div class="support-hero-visual">
    <img
        src="./assets/images/support-hero.webp"
        alt="Cleannora customer support executive"
    >
</div>

        </div>

    </section>



    <!-- =====================================================
         CHOOSE HOW YOU NEED HELP
         ===================================================== -->
    <section class="support-section support-help-section">

        <div class="support-section-container">

            <div class="support-section-heading">

                <span class="support-section-eyebrow">
                    We're Here For You
                </span>

                <h2>
                    Choose How You Need Help
                </h2>

            </div>


            <div class="support-help-grid">


                <article class="support-help-card">

                    <div class="support-help-icon">
                        <i class="bi bi-book"></i>
                    </div>

                    <h3>
                        Help Center
                    </h3>

                    <p>
                        Browse our articles to find answers
                        to common questions.
                    </p>

                    <a
                        href="help.php"
                        class="support-card-btn"
                    >
                        Browse Articles
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </article>



                <article class="support-help-card">

                    <div class="support-help-icon">
                        <i class="bi bi-chat-dots"></i>
                    </div>

                    <h3>
                        Live Chat
                    </h3>

                    <p>
                        Chat with our support team
                        in real-time.
                    </p>

                    <a
                        href="#live-chat"
                        class="support-card-btn"
                    >
                        Start Live Chat
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </article>



                <article class="support-help-card">

                    <div class="support-help-icon">
                        <i class="bi bi-envelope"></i>
                    </div>

                    <h3>
                        Email Support
                    </h3>

                    <p>
                        Drop us an email and we'll
                        get back to you.
                    </p>

                    <a
                        href="mailto:info@cleannora.com"
                        class="support-card-btn"
                    >
                        Send Email
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </article>



                <article class="support-help-card">

                    <div class="support-help-icon">
                        <i class="bi bi-telephone"></i>
                    </div>

                    <h3>
                        Call Support
                    </h3>

                    <p>
                        Speak with our support
                        executive directly.
                    </p>

                    <a
                        href="tel:+919205080012"
                        class="support-card-btn"
                    >
                        +91 9205080012
                    </a>

                </article>

            </div>

        </div>

    </section>



    <!-- =====================================================
         POPULAR TOPICS
         ===================================================== -->
    <section class="support-section support-topics-section">

        <div class="support-section-container">

            <div class="support-section-heading">

                <span class="support-section-eyebrow">
                    Popular Topics
                </span>

                <h2>
                    What Can We Help You With?
                </h2>

            </div>


            <div class="support-topics-grid">


                <a
                    href="help.php#booking"
                    class="support-topic-card"
                    data-search="booking scheduling appointment"
                >

                    <span class="support-topic-icon">
                        <i class="bi bi-calendar3"></i>
                    </span>

                    <span class="support-topic-title">
                        Booking &amp;<br>
                        Scheduling
                    </span>

                    <span class="support-topic-arrow">
                        <i class="bi bi-chevron-right"></i>
                    </span>

                </a>



                <a
                    href="help.php#payments"
                    class="support-topic-card"
                    data-search="payments refunds payment money"
                >

                    <span class="support-topic-icon">
                        <i class="bi bi-currency-rupee"></i>
                    </span>

                    <span class="support-topic-title">
                        Payments &amp;<br>
                        Refunds
                    </span>

                    <span class="support-topic-arrow">
                        <i class="bi bi-chevron-right"></i>
                    </span>

                </a>



                <a
                    href="help.php#services"
                    class="support-topic-card"
                    data-search="services providers cleaning"
                >

                    <span class="support-topic-icon">
                        <i class="bi bi-person-check"></i>
                    </span>

                    <span class="support-topic-title">
                        Services &amp;<br>
                        Providers
                    </span>

                    <span class="support-topic-arrow">
                        <i class="bi bi-chevron-right"></i>
                    </span>

                </a>



                <a
                    href="help.php#locations"
                    class="support-topic-card"
                    data-search="locations availability noida greater noida"
                >

                    <span class="support-topic-icon">
                        <i class="bi bi-geo-alt"></i>
                    </span>

                    <span class="support-topic-title">
                        Locations &amp;<br>
                        Availability
                    </span>

                    <span class="support-topic-arrow">
                        <i class="bi bi-chevron-right"></i>
                    </span>

                </a>



                <a
                    href="help.php#policies"
                    class="support-topic-card"
                    data-search="policies safety security terms"
                >

                    <span class="support-topic-icon">
                        <i class="bi bi-shield-check"></i>
                    </span>

                    <span class="support-topic-title">
                        Policies &amp;<br>
                        Safety
                    </span>

                    <span class="support-topic-arrow">
                        <i class="bi bi-chevron-right"></i>
                    </span>

                </a>

            </div>

        </div>

    </section>



    <!-- =====================================================
         CONTACT
         ===================================================== -->
    <section class="support-section support-contact-section">

        <div class="support-section-container">

            <div class="support-contact-wrapper">


                <div class="support-message-area">

                    <div class="support-message-eyebrow">
                        Still Need Help?
                    </div>

                    <h2>
                        Send Us a Message
                    </h2>


                    <div class="support-message-layout">


                        <div>

                            <p class="support-message-description">
                                Can't find what you're looking for?
                                Send us a message and we'll get back
                                to you as soon as possible.
                            </p>


                            <div class="support-support-illustration">

                                <div>

                                    <i
                                        class="bi bi-headset"
                                        style="
                                            display:block;
                                            font-size:72px;
                                            color:#B9DED2;
                                            margin-bottom:6px;
                                        "
                                    ></i>

                                    <strong
                                        style="
                                            display:block;
                                            font-size:22px;
                                        "
                                    >
                                        24/7
                                    </strong>

                                    <span
                                        style="
                                            display:block;
                                            font-size:12px;
                                            font-weight:800;
                                        "
                                    >
                                        Support
                                    </span>

                                </div>

                            </div>

                        </div>


                        <div>

                            <form
                                class="support-form"
                                action="contact.php"
                                method="POST"
                            >

                                <div class="support-form-row">

                                    <input
                                        type="text"
                                        name="name"
                                        placeholder="Full Name"
                                        required
                                    >

                                    <input
                                        type="email"
                                        name="email"
                                        placeholder="Email Address"
                                        required
                                    >

                                </div>


                                <input
                                    type="tel"
                                    name="phone"
                                    placeholder="Phone Number"
                                >


                                <input
                                    type="text"
                                    name="subject"
                                    placeholder="Subject"
                                    required
                                >


                                <textarea
                                    name="message"
                                    placeholder="Message"
                                    required
                                ></textarea>


                                <button
                                    type="submit"
                                    class="support-submit-btn"
                                >
                                    Send Message
                                    <i
                                        class="bi bi-send"
                                        style="margin-left:5px;"
                                    ></i>
                                </button>

                            </form>

                        </div>

                    </div>

                </div>



                <aside class="support-contact-info">

                    <h3>
                        Other Ways to Reach Us
                    </h3>


                    <div class="support-contact-item">

                        <div class="support-contact-item-icon">
                            <i class="bi bi-telephone"></i>
                        </div>

                        <div class="support-contact-item-content">

                            <strong>
                                Call Us
                            </strong>

                            <a href="tel:+919205080012">
                                +91 9205080012
                            </a>

                            <span>
                                Mon - Sun: 8:00 AM - 8:00 PM
                            </span>

                        </div>

                    </div>


                    <div class="support-contact-item">

                        <div class="support-contact-item-icon">
                            <i class="bi bi-envelope"></i>
                        </div>

                        <div class="support-contact-item-content">

                            <strong>
                                Email Us
                            </strong>

                            <a href="mailto:info@cleannora.com">
                                info@cleannora.com
                            </a>

                            <span>
                                We reply within 24 hours
                            </span>

                        </div>

                    </div>


                    <div class="support-contact-item">

                        <div class="support-contact-item-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>

                        <div class="support-contact-item-content">

                            <strong>
                                Our Office
                            </strong>

                            <span>
                                Sector 62, Noida,<br>
                                Uttar Pradesh, India
                            </span>

                        </div>

                    </div>

                </aside>

            </div>

        </div>

    </section>



    <!-- =====================================================
         TRUST STRIP
         ===================================================== -->
    <section class="support-trust-section">

        <div class="support-trust-wrapper">


            <div class="support-trust-intro">

                <h3>
                    Your Satisfaction is<br>
                    Our Priority
                </h3>

                <p>
                    We are committed to providing you
                    the best cleaning experience.
                </p>

            </div>


            <div class="support-trust-item">

                <div class="support-trust-icon">
                    <i class="bi bi-shield-check"></i>
                </div>

                <strong>
                    Trusted Professionals
                </strong>

                <span>
                    Background verified<br>
                    and trained experts
                </span>

            </div>


            <div class="support-trust-item">

                <div class="support-trust-icon">
                    <i class="bi bi-award"></i>
                </div>

                <strong>
                    Quality Service
                </strong>

                <span>
                    High standards and<br>
                    quality you can trust
                </span>

            </div>


            <div class="support-trust-item">

                <div class="support-trust-icon">
                    <i class="bi bi-hand-thumbs-up"></i>
                </div>

                <strong>
                    Hassle Free
                </strong>

                <span>
                    Easy booking and<br>
                    stress-free experience
                </span>

            </div>


            <div class="support-trust-item">

                <div class="support-trust-icon">
                    <i class="bi bi-headset"></i>
                </div>

                <strong>
                    Always Here
                </strong>

                <span>
                    Support for all<br>
                    your queries
                </span>

            </div>

        </div>

    </section>

</main>


<?php include 'includes/footer.php'; ?>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchForm =
        document.getElementById('supportSearchForm');

    const searchInput =
        document.getElementById('supportSearchInput');

    const topicCards =
        document.querySelectorAll('.support-topic-card');


    if (!searchForm || !searchInput) {
        return;
    }


    searchForm.addEventListener('submit', function (event) {

        event.preventDefault();

        const query =
            searchInput.value.trim().toLowerCase();


        if (!query) {

            topicCards.forEach(function (card) {

                card.classList.remove(
                    'support-search-hidden',
                    'support-search-match'
                );

            });

            return;
        }


        topicCards.forEach(function (card) {

            const searchText =
                (
                    card.dataset.search || ''
                ).toLowerCase();

            const title =
                (
                    card.innerText || ''
                ).toLowerCase();


            if (
                searchText.includes(query) ||
                title.includes(query)
            ) {

                card.classList.remove(
                    'support-search-hidden'
                );

                card.classList.add(
                    'support-search-match'
                );

            } else {

                card.classList.add(
                    'support-search-hidden'
                );

                card.classList.remove(
                    'support-search-match'
                );

            }

        });


        const topicsSection =
            document.querySelector(
                '.support-topics-section'
            );


        if (topicsSection) {

            topicsSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }

    });


    searchInput.addEventListener('input', function () {

        if (!this.value.trim()) {

            topicCards.forEach(function (card) {

                card.classList.remove(
                    'support-search-hidden',
                    'support-search-match'
                );

            });

        }

    });

});
</script>