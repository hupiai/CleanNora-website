<?php
$pageTitle = "Blog | Cleaning Tips, Guides & Home Care Ideas | Cleannora";
$pageDescription = "Discover practical cleaning tips, home care guides, deep cleaning advice and useful cleaning insights from Cleannora.";
?>

<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="assets/css/blog.css">

<!-- =========================================================
     CLEANNORA BLOG PAGE
     ========================================================= -->

<main class="cleannora-blog-page">

    <!-- =========================
         BLOG HERO
         ========================= -->
    <section class="blog-hero">

        <div class="blog-hero-content">

            <span class="blog-eyebrow">
                CLEANNORA JOURNAL
            </span>

            <h1>
                Cleaning Tips, Guides<br>
                & Home Care Ideas
            </h1>

            <p>
                Practical cleaning tips, helpful guides and expert advice
                to help you keep your home fresh, healthy and beautifully maintained.
            </p>

            <!-- Search -->
            <div class="blog-search-box">
                <input
                    type="text"
                    id="blogSearch"
                    placeholder="Search articles, topics or keywords..."
                    aria-label="Search blog articles"
                >

                <button type="button" id="blogSearchBtn" aria-label="Search">
                    <span>⌕</span>
                </button>
            </div>

            <!-- Popular Topics -->
            <div class="blog-popular">

                <strong>Popular:</strong>

                <button type="button" class="popular-tag" data-category="Home Cleaning">
                    Home Cleaning
                </button>

                <button type="button" class="popular-tag" data-category="Deep Cleaning">
                    Deep Cleaning
                </button>

                <button type="button" class="popular-tag" data-category="Cleaning Tips">
                    Cleaning Tips
                </button>

                <button type="button" class="popular-tag" data-category="Local Guides">
                    Noida
                </button>

                <button type="button" class="popular-tag" data-category="Checklists">
                    Checklists
                </button>

            </div>

        </div>

        <div class="blog-hero-image">

            <img
                src="assets/images/blog/blog-hero.webp"
                alt="Premium home cleaning and home care"
                loading="eager"
            >

        </div>

    </section>


    <!-- =========================
         FEATURED ARTICLE
         ========================= -->
    <section class="blog-container blog-featured-section">

        <div class="blog-featured">

            <div class="blog-featured-content">

                <span class="featured-badge">
                    FEATURED ARTICLE
                </span>

                <span class="article-category">
                    Deep Cleaning
                </span>

                <h2>
                    How Often Should You Deep Clean Your Home?
                </h2>

                <p>
                    A complete guide to deep cleaning, including a recommended
                    schedule, room-by-room checklist and practical tips for
                    maintaining a fresher and healthier home.
                </p>

                <a
                    href="blog/how-often-should-you-deep-clean-your-home.php"
                    class="blog-primary-btn"
                >
                    Read Article
                    <span>→</span>
                </a>

                <div class="article-meta">

                    <span>
                        <span class="meta-icon">▣</span>
                        Sep 10, 2026
                    </span>

                    <span>
                        <span class="meta-icon">◷</span>
                        6 min read
                    </span>

                </div>

            </div>

            <div class="blog-featured-image">

                <img
                    src="assets/images/blog/deep-cleaning-guide.webp"
                    alt="Deep cleaning a modern home"
                    loading="lazy"
                >

            </div>

        </div>

    </section>


    <!-- =========================
         CATEGORY SECTION
         ========================= -->
    <section class="blog-container blog-category-section">

        <div class="blog-section-heading">

            <div>
                <span class="section-mini-label">
                    EXPLORE
                </span>

                <h2>
                    Browse by Category
                </h2>
            </div>

            <button
                type="button"
                class="view-all-btn"
                id="viewAllArticles"
            >
                View All Articles
                <span>→</span>
            </button>

        </div>


        <div class="blog-category-tabs">

            <button
                type="button"
                class="category-tab active"
                data-category="all"
            >
                <span class="category-icon">▤</span>
                <span>All Articles</span>
            </button>

            <button
                type="button"
                class="category-tab"
                data-category="Home Cleaning"
            >
                <span class="category-icon">⌂</span>
                <span>Home Cleaning</span>
            </button>

            <button
                type="button"
                class="category-tab"
                data-category="Deep Cleaning"
            >
                <span class="category-icon">✦</span>
                <span>Deep Cleaning</span>
            </button>

            <button
                type="button"
                class="category-tab"
                data-category="Cleaning Tips"
            >
                <span class="category-icon">♧</span>
                <span>Cleaning Tips</span>
            </button>

            <button
                type="button"
                class="category-tab"
                data-category="Local Guides"
            >
                <span class="category-icon">⌖</span>
                <span>Local Guides</span>
            </button>

        </div>

    </section>


    <!-- =========================
         LATEST ARTICLES
         ========================= -->
    <section class="blog-container blog-articles-section">

        <div class="blog-section-heading">

            <div>
                <span class="section-mini-label">
                    FROM THE JOURNAL
                </span>

                <h2>
                    Latest Articles
                </h2>
            </div>

            <button
                type="button"
                class="view-all-btn"
                id="seeMoreArticles"
            >
                See More Articles
                <span>→</span>
            </button>

        </div>


        <div class="blog-grid" id="blogGrid">


            <!-- ARTICLE 1 -->
            <article
                class="blog-card"
                data-category="Home Cleaning"
                data-title="Complete Home Cleaning Checklist for a Fresh and Healthy Home"
            >

                <a
                    href="blog/home-cleaning-checklist.php"
                    class="blog-card-image"
                >

                    <img
                        src="assets/images/blog/home-cleaning-checklist.webp"
                        alt="Complete home cleaning checklist"
                        loading="lazy"
                    >

                </a>

                <div class="blog-card-content">

                    <span class="card-category">
                        Home Cleaning
                    </span>

                    <h3>
                        <a href="blog/home-cleaning-checklist.php">
                            Complete Home Cleaning Checklist for a Fresh and Healthy Home
                        </a>
                    </h3>

                    <p>
                        A practical room-by-room checklist to keep your home
                        clean, fresh and organized.
                    </p>

                    <div class="article-meta">

                        <span>Sep 08, 2026</span>
                        <span>5 min read</span>

                    </div>

                </div>

            </article>


            <!-- ARTICLE 2 -->
            <article
                class="blog-card"
                data-category="Cleaning Tips"
                data-title="How to Clean Your Bathroom Like a Professional"
            >

                <a
                    href="blog/how-to-clean-bathroom-like-a-professional.php"
                    class="blog-card-image"
                >

                    <img
                        src="assets/images/blog/bathroom-cleaning.webp"
                        alt="How to clean a bathroom professionally"
                        loading="lazy"
                    >

                </a>

                <div class="blog-card-content">

                    <span class="card-category">
                        Cleaning Tips
                    </span>

                    <h3>
                        <a href="blog/how-to-clean-bathroom-like-a-professional.php">
                            How to Clean Your Bathroom Like a Professional
                        </a>
                    </h3>

                    <p>
                        Simple professional techniques for cleaner,
                        fresher and more hygienic bathrooms.
                    </p>

                    <div class="article-meta">

                        <span>Sep 05, 2026</span>
                        <span>6 min read</span>

                    </div>

                </div>

            </article>


            <!-- ARTICLE 3 -->
            <article
                class="blog-card"
                data-category="Cleaning Tips"
                data-title="Kitchen Cleaning Checklist What to Clean Daily Weekly and Monthly"
            >

                <a
                    href="blog/kitchen-cleaning-checklist.php"
                    class="blog-card-image"
                >

                    <img
                        src="assets/images/blog/kitchen-cleaning.webp"
                        alt="Kitchen cleaning checklist"
                        loading="lazy"
                    >

                </a>

                <div class="blog-card-content">

                    <span class="card-category">
                        Cleaning Tips
                    </span>

                    <h3>
                        <a href="blog/kitchen-cleaning-checklist.php">
                            Kitchen Cleaning Checklist: What to Clean Daily, Weekly and Monthly
                        </a>
                    </h3>

                    <p>
                        Know exactly what parts of your kitchen need
                        daily, weekly and monthly cleaning.
                    </p>

                    <div class="article-meta">

                        <span>Sep 01, 2026</span>
                        <span>5 min read</span>

                    </div>

                </div>

            </article>


            <!-- ARTICLE 4 -->
            <article
                class="blog-card"
                data-category="Home Cleaning"
                data-title="How to Remove Dust From Your Home and Keep It Cleaner for Longer"
            >

                <a
                    href="blog/how-to-remove-dust-from-home.php"
                    class="blog-card-image"
                >

                    <img
                        src="assets/images/blog/dust-cleaning.webp"
                        alt="Dust cleaning tips for home"
                        loading="lazy"
                    >

                </a>

                <div class="blog-card-content">

                    <span class="card-category">
                        Home Cleaning
                    </span>

                    <h3>
                        <a href="blog/how-to-remove-dust-from-home.php">
                            How to Remove Dust From Your Home and Keep It Cleaner for Longer
                        </a>
                    </h3>

                    <p>
                        Practical ways to reduce household dust and
                        maintain cleaner surfaces for longer.
                    </p>

                    <div class="article-meta">

                        <span>Aug 28, 2026</span>
                        <span>4 min read</span>

                    </div>

                </div>

            </article>


            <!-- ARTICLE 5 -->
            <article
                class="blog-card"
                data-category="Deep Cleaning"
                data-title="Move-In Cleaning Checklist Everything to Clean Before You Settle In"
            >

                <a
                    href="blog/move-in-cleaning-checklist.php"
                    class="blog-card-image"
                >

                    <img
                        src="assets/images/blog/move-in-cleaning.webp"
                        alt="Move in cleaning checklist"
                        loading="lazy"
                    >

                </a>

                <div class="blog-card-content">

                    <span class="card-category">
                        Deep Cleaning
                    </span>

                    <h3>
                        <a href="blog/move-in-cleaning-checklist.php">
                            Move-In Cleaning Checklist: Everything to Clean Before You Settle In
                        </a>
                    </h3>

                    <p>
                        A complete cleaning checklist for preparing
                        your new home before moving in.
                    </p>

                    <div class="article-meta">

                        <span>Aug 25, 2026</span>
                        <span>5 min read</span>

                    </div>

                </div>

            </article>


            <!-- ARTICLE 6 -->
            <article
                class="blog-card"
                data-category="Local Guides"
                data-title="Home Cleaning in Noida Complete Guide for Busy Households"
            >

                <a
                    href="blog/home-cleaning-in-noida.php"
                    class="blog-card-image"
                >

                    <img
                        src="assets/images/blog/noida-cleaning.webp"
                        alt="Home cleaning in Noida"
                        loading="lazy"
                    >

                </a>

                <div class="blog-card-content">

                    <span class="card-category">
                        Local Guides
                    </span>

                    <h3>
                        <a href="blog/home-cleaning-in-noida.php">
                            Home Cleaning in Noida: Complete Guide for Busy Households
                        </a>
                    </h3>

                    <p>
                        Helpful home cleaning guidance for busy households
                        living in Noida.
                    </p>

                    <div class="article-meta">

                        <span>Aug 20, 2026</span>
                        <span>6 min read</span>

                    </div>

                </div>

            </article>


            <!-- ARTICLE 7 -->
            <article
                class="blog-card"
                data-category="Local Guides"
                data-title="Best Cleaning Tips for Homes in Greater Noida"
            >

                <a
                    href="blog/cleaning-tips-for-greater-noida-homes.php"
                    class="blog-card-image"
                >

                    <img
                        src="assets/images/blog/greater-noida-cleaning.webp"
                        alt="Cleaning tips for Greater Noida homes"
                        loading="lazy"
                    >

                </a>

                <div class="blog-card-content">

                    <span class="card-category">
                        Local Guides
                    </span>

                    <h3>
                        <a href="blog/cleaning-tips-for-greater-noida-homes.php">
                            Best Cleaning Tips for Homes in Greater Noida
                        </a>
                    </h3>

                    <p>
                        Useful cleaning and home-care tips for modern
                        homes in Greater Noida.
                    </p>

                    <div class="article-meta">

                        <span>Aug 18, 2026</span>
                        <span>5 min read</span>

                    </div>

                </div>

            </article>


            <!-- ARTICLE 8 -->
            <article
                class="blog-card"
                data-category="Cleaning Tips"
                data-title="How to Keep Your Home Fresh and Pet Friendly"
            >

                <a
                    href="#"
                    class="blog-card-image"
                >

                    <img
                        src="assets/images/blog/home-cleaning-checklist.webp"
                        alt="Fresh and pet friendly home"
                        loading="lazy"
                    >

                </a>

                <div class="blog-card-content">

                    <span class="card-category">
                        Cleaning Tips
                    </span>

                    <h3>
                        <a href="#">
                            How to Keep Your Home Fresh and Pet-Friendly
                        </a>
                    </h3>

                    <p>
                        Easy home-care habits for keeping your living
                        space fresh and comfortable for pets and family.
                    </p>

                    <div class="article-meta">

                        <span>Aug 15, 2026</span>
                        <span>4 min read</span>

                    </div>

                </div>

            </article>
            
            <!-- ARTICLE 9 -->
<article
    class="blog-card"
    data-category="Deep Cleaning"
    data-title="Deep Cleaning vs Regular Cleaning What Is the Difference"
>

    <a
        href="blog/deep-cleaning-vs-regular-cleaning.php"
        class="blog-card-image"
    >

        <img
            src="assets/images/blog/deep-cleaning-guide.webp"
            alt="Deep cleaning vs regular cleaning"
            loading="lazy"
        >

    </a>

    <div class="blog-card-content">

        <span class="card-category">
            Deep Cleaning
        </span>

        <h3>
            <a href="blog/deep-cleaning-vs-regular-cleaning.php">
                Deep Cleaning vs Regular Cleaning: What’s the Difference?
            </a>
        </h3>

        <p>
            Understand the difference between regular home cleaning
            and deep cleaning and when each one is useful.
        </p>

        <div class="article-meta">

            <span>Aug 12, 2026</span>
            <span>6 min read</span>

        </div>

    </div>

</article>


        </div>


        <!-- No Results -->
        <div
            class="blog-no-results"
            id="blogNoResults"
            hidden
        >
            <h3>No articles found</h3>
            <p>
                Try another keyword or choose a different category.
            </p>
        </div>

    </section>


    <!-- =========================
         NEWSLETTER CTA
         ========================= -->
    <section class="blog-newsletter-section">

        <div class="blog-container">

            <div class="blog-newsletter">

                <div class="newsletter-icon">
                    ✉
                </div>

                <div class="newsletter-content">

                    <span class="section-mini-label">
                        CLEANNORA JOURNAL
                    </span>

                    <h2>
                        Stay Updated With<br>
                        Cleannora Blog
                    </h2>

                    <p>
                        Get the latest cleaning tips, guides and useful
                        home-care ideas delivered to your inbox.
                    </p>

                </div>

                <form
                    class="newsletter-form"
                    action="#"
                    method="post"
                    onsubmit="return false;"
                >

                    <div class="newsletter-input-wrap">

                        <input
                            type="email"
                            placeholder="Enter your email address..."
                            aria-label="Email address"
                        >

                        <button type="submit">
                            Subscribe
                        </button>

                    </div>

                    <small>
                        🔒 We respect your privacy. No spam, ever.
                    </small>

                </form>

            </div>

        </div>

    </section>

</main>


<!-- =========================================================
     BLOG SEARCH + CATEGORY FILTER
     ========================================================= -->

<script>

document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("blogSearch");
    const searchButton = document.getElementById("blogSearchBtn");
    const categoryTabs = document.querySelectorAll(".category-tab");
    const popularTags = document.querySelectorAll(".popular-tag");
    const articles = document.querySelectorAll(".blog-card");
    const noResults = document.getElementById("blogNoResults");

    let activeCategory = "all";


    function filterArticles() {

        const searchValue = searchInput.value
            .toLowerCase()
            .trim();

        let visibleCount = 0;

        articles.forEach(function (article) {

            const category =
                article.getAttribute("data-category").toLowerCase();

            const title =
                article.getAttribute("data-title").toLowerCase();

            const content =
                article.innerText.toLowerCase();

            const categoryMatch =
                activeCategory === "all" ||
                category === activeCategory.toLowerCase();

            const searchMatch =
                searchValue === "" ||
                title.includes(searchValue) ||
                content.includes(searchValue) ||
                category.includes(searchValue);

            if (categoryMatch && searchMatch) {

                article.style.display = "";

                visibleCount++;

            } else {

                article.style.display = "none";

            }

        });


        if (visibleCount === 0) {

            noResults.hidden = false;

        } else {

            noResults.hidden = true;

        }

    }


    categoryTabs.forEach(function (tab) {

        tab.addEventListener("click", function () {

            categoryTabs.forEach(function (item) {
                item.classList.remove("active");
            });

            this.classList.add("active");

            activeCategory =
                this.getAttribute("data-category");

            searchInput.value = "";

            filterArticles();

        });

    });


    popularTags.forEach(function (tag) {

        tag.addEventListener("click", function () {

            const category =
                this.getAttribute("data-category");

            activeCategory = category;

            categoryTabs.forEach(function (tab) {

                if (
                    tab.getAttribute("data-category").toLowerCase() ===
                    category.toLowerCase()
                ) {

                    categoryTabs.forEach(function (item) {
                        item.classList.remove("active");
                    });

                    tab.classList.add("active");

                }

            });

            searchInput.value = "";

            filterArticles();

            document
                .querySelector(".blog-articles-section")
                .scrollIntoView({
                    behavior: "smooth"
                });

        });

    });


    searchButton.addEventListener("click", function () {

        filterArticles();

        document
            .querySelector(".blog-articles-section")
            .scrollIntoView({
                behavior: "smooth"
            });

    });


    searchInput.addEventListener("input", function () {

        filterArticles();

    });


    searchInput.addEventListener("keydown", function (event) {

        if (event.key === "Enter") {

            event.preventDefault();

            filterArticles();

        }

    });


    document
        .getElementById("viewAllArticles")
        .addEventListener("click", function () {

            activeCategory = "all";

            categoryTabs.forEach(function (tab) {

                tab.classList.remove("active");

                if (
                    tab.getAttribute("data-category") === "all"
                ) {
                    tab.classList.add("active");
                }

            });

            searchInput.value = "";

            filterArticles();

            document
                .querySelector(".blog-articles-section")
                .scrollIntoView({
                    behavior: "smooth"
                });

        });


    document
        .getElementById("seeMoreArticles")
        .addEventListener("click", function () {

            activeCategory = "all";

            categoryTabs.forEach(function (tab) {

                tab.classList.remove("active");

                if (
                    tab.getAttribute("data-category") === "all"
                ) {
                    tab.classList.add("active");
                }

            });

            searchInput.value = "";

            filterArticles();

            document
                .querySelector(".blog-articles-section")
                .scrollIntoView({
                    behavior: "smooth"
                });

        });


});

</script>


<?php include 'includes/footer.php'; ?>