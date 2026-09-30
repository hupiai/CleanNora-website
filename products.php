<?php
$pageTitle = 'InstaMart Products | Home Cleaning Products by CleanNora';
$pageDescription = 'Explore available CleanNora home-care and cleaning products in InstaMart.';
include 'includes/header.php';
include 'includes/db.php';

$products = [];

$sql = "
    SELECT *
    FROM mart_products
    ORDER BY id DESC
";

$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}
?>

<style>
/* =========================================================
   INSTAMART ALL PRODUCTS PAGE
   ========================================================= */

.cm-products-page {
    background: #f8faf9;
    min-height: 100vh;
    padding: 55px 0 80px;
}

.cm-products-header {
    text-align: center;
    margin-bottom: 45px;
}

.cm-products-header .eyebrow {
    display: inline-block;
    color: #b8860b;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.cm-products-header h1 {
    margin: 0;
    color: #083d2b;
    font-size: 42px;
    font-weight: 800;
    line-height: 1.15;
}

.cm-products-header p {
    max-width: 650px;
    margin: 14px auto 0;
    color: #66736e;
    font-size: 16px;
}

/* TOP BAR */

.cm-products-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 30px;
}

.cm-products-count {
    color: #083d2b;
    font-size: 15px;
    font-weight: 700;
}

.cm-products-search {
    width: 320px;
    position: relative;
}

.cm-products-search input {
    width: 100%;
    height: 46px;
    border: 1px solid #dce5e1;
    border-radius: 12px;
    padding: 0 45px 0 16px;
    outline: none;
    background: #fff;
    font-size: 14px;
}

.cm-products-search input:focus {
    border-color: #083d2b;
}

.cm-products-search i {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #718078;
}

/* GRID */

.cm-products-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 22px;
}

/* CARD */

.cm-product-card {
    background: #fff;
    border: 1px solid #e3eae7;
    border-radius: 18px;
    overflow: hidden;
    transition: .25s ease;
    height: 100%;
    position: relative;
}

.cm-product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 35px rgba(8, 61, 43, .10);
}

.cm-product-image {
    height: 285px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
}

.cm-product-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.cm-product-info {
    padding: 18px;
}

.cm-product-name {
    color: #083d2b;
    font-size: 16px;
    font-weight: 750;
    line-height: 1.4;
    min-height: 45px;
    margin-bottom: 9px;
}

.cm-product-rating {
    color: #f4bf19;
    font-size: 13px;
    margin-bottom: 9px;
}

.cm-product-rating span {
    color: #8a9691;
    font-size: 11px;
    margin-left: 4px;
}

.cm-product-price {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 15px;
}

.cm-product-sale {
    color: #111;
    font-size: 19px;
    font-weight: 800;
}

.cm-product-mrp {
    color: #9aa39f;
    text-decoration: line-through;
    font-size: 12px;
}

.cm-product-btn {
    width: 100%;
    height: 43px;
    border: 1px solid #083d2b;
    border-radius: 10px;
    background: #083d2b;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    transition: .2s ease;
}

.cm-product-btn:hover {
    background: #f4bf19;
    border-color: #f4bf19;
    color: #083d2b;
}

/* EMPTY */

.cm-no-products {
    text-align: center;
    padding: 70px 20px;
    color: #66736e;
}

/* RESPONSIVE */

@media (max-width: 1199px) {
    .cm-products-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 767px) {

    .cm-products-page {
        padding: 40px 0 60px;
    }

    .cm-products-header h1 {
        font-size: 32px;
    }

    .cm-products-toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .cm-products-search {
        width: 100%;
    }

    .cm-products-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .cm-product-image {
        height: 210px;
        padding: 12px;
    }

    .cm-product-info {
        padding: 13px;
    }

    .cm-product-name {
        font-size: 14px;
        min-height: 40px;
    }

    .cm-product-sale {
        font-size: 17px;
    }
}

@media (max-width: 430px) {

    .cm-products-grid {
        grid-template-columns: 1fr 1fr;
    }

    .cm-product-image {
        height: 175px;
    }

    .cm-product-info {
        padding: 11px;
    }

    .cm-product-btn {
        height: 40px;
        font-size: 13px;
    }
}
</style>

<main class="cm-products-page">

    <div class="container">

        <!-- HEADER -->

        <div class="cm-products-header">

            <span class="eyebrow">INSTAMART COLLECTION</span>

            <h1>All Cleaning Products</h1>

            <p>
                Discover our complete collection of premium cleaning
                products for a cleaner, fresher and happier home.
            </p>

        </div>

        <!-- TOOLBAR -->

        <div class="cm-products-toolbar">

            <div class="cm-products-count">
                <?php echo count($products); ?> Products
            </div>

            <div class="cm-products-search">

                <input
                    type="search"
                    id="cmProductSearch"
                    placeholder="Search products..."
                    autocomplete="off"
                >

                <i class="bi bi-search"></i>

            </div>

        </div>

        <!-- PRODUCTS -->

        <?php if (!empty($products)) { ?>

            <div class="cm-products-grid" id="cmProductsGrid">

                <?php foreach ($products as $product) { ?>

                    <?php
                    $productName = $product['name'] ?? 'InstaMart Product';

                    $image = $product['main_image'] ?? '';

                    $salePrice = $product['sale_price'] ?? 0;

                    $mrp = $product['mrp'] ?? 0;

                    if ($image === '') {
                        $image = 'assets/images/cleanmart/hero.webp';
                    }
                    ?>

                    <article
                        class="cm-product-card"
                        data-product-name="<?php echo htmlspecialchars(
                            strtolower($productName)
                        ); ?>"
                    >

                        <div class="cm-product-image">

                            <img
                                src="<?php echo htmlspecialchars($image); ?>"
                                alt="<?php echo htmlspecialchars($productName); ?>"
                                loading="lazy"
                            >

                        </div>

                        <div class="cm-product-info">

                            <div class="cm-product-name">
                                <?php echo htmlspecialchars($productName); ?>
                            </div>

                            <div class="cm-product-rating">
                                ★★★★★
                                <span>(0)</span>
                            </div>

                            <div class="cm-product-price">

                                <span class="cm-product-sale">
                                    ₹<?php echo number_format((float)$salePrice, 0); ?>
                                </span>

                                <?php if ((float)$mrp > (float)$salePrice) { ?>

                                    <span class="cm-product-mrp">
                                        ₹<?php echo number_format((float)$mrp, 0); ?>
                                    </span>

                                <?php } ?>

                            </div>

                            <button
                                type="button"
                                class="cm-product-btn"
                                data-product-id="<?php echo (int)$product['id']; ?>"
                            >
                                Add to Cart
                            </button>

                        </div>

                    </article>

                <?php } ?>

            </div>

            <div
                id="cmNoSearchResults"
                class="cm-no-products"
                style="display:none;"
            >
                No products found.
            </div>

        <?php } else { ?>

            <div class="cm-no-products">

                <h3>No Products Available</h3>

                <p>
                    Products will appear here once they are added
                    to InstaMart.
                </p>

            </div>

        <?php } ?>

    </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('cmProductSearch');
    const cards = document.querySelectorAll('.cm-product-card');
    const noResults = document.getElementById('cmNoSearchResults');

    if (searchInput) {

        searchInput.addEventListener('input', function () {

            const search = this.value.trim().toLowerCase();
            let visible = 0;

            cards.forEach(function (card) {

                const name =
                    card.getAttribute('data-product-name') || '';

                if (name.includes(search)) {

                    card.style.display = '';

                    visible++;

                } else {

                    card.style.display = 'none';

                }

            });

            if (noResults) {
                noResults.style.display =
                    visible === 0 ? 'block' : 'none';
            }

        });

    }

});
</script>

<?php include 'includes/footer.php'; ?>