<?php
session_start();

include 'includes/db.php';

/*
|--------------------------------------------------------------------------
| CLEANNORA SERVICE BOOKING PAGE
|--------------------------------------------------------------------------
| Example:
| booking-service.php?service=Instant%20Maid
|--------------------------------------------------------------------------
*/


/* =========================================================
   GET SELECTED SERVICE
========================================================= */

$requestedService = isset($_GET['service'])
    ? trim($_GET['service'])
    : 'Instant Maid';
    
    // Normalize service name used in URLs with database service names
if ($requestedService === 'Instant Maid') {
    $requestedService = 'Instant Maid Service';
}

$serviceName = $requestedService;

/*
|--------------------------------------------------------------------------
| DISPLAY / PACKAGE SERVICE NAME
|--------------------------------------------------------------------------
| Database name can be "Instant Maid Service"
| but package data uses "Instant Maid".
|--------------------------------------------------------------------------
*/
$packageServiceName = ($serviceName === 'Instant Maid Service')
    ? 'Instant Maid'
    : $serviceName;

/* =========================================================
   SERVICE IMAGE MAP
========================================================= */

$serviceImages = [

    'Instant Maid' =>
        '/assets/images/services/instant-maid.webp',

    'Instant Maid Service' =>
        '/assets/images/services/instant-maid.webp',

    'Cook' =>
        '/assets/images/services/cook.webp',

    'Home Cleaning' =>
        '/assets/images/services/home-cleaning.webp',

    'Deep Cleaning' =>
        '/assets/images/services/deep-cleaning.webp',

    'Kitchen Cleaning' =>
        '/assets/images/services/kitchen-cleaning.webp',

    'Bathroom Cleaning' =>
        '/assets/images/services/bathroom-cleaning.webp',

    'Sofa Cleaning' =>
        '/assets/images/services/sofa-cleaning.webp',

    'Carpet Cleaning' =>
        '/assets/images/services/carpet-cleaning.webp',

    'Window Cleaning' =>
        '/assets/images/services/window-cleaning.webp',

    'Office Cleaning' =>
        '/assets/images/services/office-cleaning.webp',

    'Car Cleaning' =>
        '/assets/images/services/car-cleaning.webp',

    'Move In / Out Cleaning' =>
        '/assets/images/services/move-in-out-cleaning.webp',

    'AC Service & Repair' =>
        '/assets/images/services/ac-service.webp',

    'Electrician' =>
        '/assets/images/services/electrician.webp',

    'Plumber' =>
        '/assets/images/services/plumber.webp',

    'Chimney & Hob' =>
        '/assets/images/services/chimney.webp',

    'Product AMC' =>
        '/assets/images/services/product-amc.webp',

    'Salon Services' =>
        '/assets/images/services/salon.webp'

];


/* =========================================================
   DEFAULT IMAGE
========================================================= */

$defaultImage =
    '/assets/images/services/services-hero.webp';


/* =========================================================
   GET SERVICE FROM DATABASE
========================================================= */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id, service_name, description, price, status
     FROM services
     WHERE service_name = ?
     LIMIT 1"
);

if ($stmt) {

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $requestedService
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {

        $serviceId =
            (int) $row['id'];

        $serviceName =
            $row['service_name'];

        $serviceDescription =
            $row['description'] ?? '';

        $servicePrice =
            (float) $row['price'];

        $serviceStatus =
            (int) $row['status'];
    }

    mysqli_stmt_close($stmt);
}


/* =========================================================
   SERVICE IMAGE
========================================================= */

$serviceImage =
    $serviceImages[$serviceName]
    ?? $defaultImage;
    
    $displayServiceName = $serviceName;

if ($serviceName === 'Instant Maid Service') {
    $displayServiceName = 'Instant Maid';
}


/* =========================================================
   GET ALL SERVICES FOR SIDEBAR
========================================================= */

$allServices = [];

$servicesQuery = mysqli_query(
    $conn,
    "SELECT id, service_name, description, price, status
     FROM services
     ORDER BY id ASC"
);

if ($servicesQuery) {

    while ($serviceRow = mysqli_fetch_assoc($servicesQuery)) {

        $allServices[] = $serviceRow;
    }
}


/* =========================================================
   EXACT PACKAGE DATA FROM REFERENCE
========================================================= */

$packageData = [

    'Instant Maid' => [

        [
            'id' => 'instant-maid-1-hour',
            'name' => 'Instant Maid – 1 Hour',
            'rating' => '4.8',
            'reviews' => '3.2k',
            'duration' => '60 min',
            'price' => 199,
            'description' =>
                'On-demand verified professional for sweeping, mopping, dishes and light household tasks.',
            'included' => [
                'Sweeping & mopping',
                'Dish washing',
                'Light dusting'
            ],
            'not_included' => [
                'Deep cleaning',
                'Heavy lifting'
            ]
        ],

        [
            'id' => 'instant-maid-2-hours',
            'name' => 'Instant Maid – 2 Hours',
            'rating' => '4.8',
            'reviews' => '2.1k',
            'duration' => '120 min',
            'price' => 349,
            'description' =>
                'Extended household assistance for multiple rooms and daily household chores.',
            'included' => [
                'Floor cleaning',
                'Dish washing',
                'Kitchen platform cleaning',
                'Dusting'
            ],
            'not_included' => [
                'Specialized deep cleaning'
            ]
        ]

    ],


    'Cook' => [

        [
            'id' => 'cook-one-meal',
            'name' => 'Home Cook – One Meal',
            'rating' => '4.7',
            'reviews' => '980',
            'duration' => '90 min',
            'price' => 399,
            'description' =>
                'Professional cook service for preparing one family meal using ingredients available at home.',
            'included' => [
                'Meal preparation',
                'Basic kitchen assistance',
                'Cooking using customer-provided ingredients'
            ],
            'not_included' => [
                'Grocery purchase'
            ]
        ]

    ],


    'Home Cleaning' => [

        [
            'id' => 'home-cleaning-1bhk',
            'name' => '1 BHK Deep Cleaning',
            'rating' => '4.9',
            'reviews' => '1.7k',
            'duration' => '3 hrs',
            'price' => 2499,
            'description' =>
                'Full 1 BHK intensive home cleaning with professional equipment and detailed surface cleaning.',
            'included' => [
                'Dusting',
                'Floor cleaning',
                'Kitchen surface cleaning',
                'Bathroom cleaning'
            ],
            'not_included' => [
                'Exterior window cleaning'
            ]
        ],

        [
            'id' => 'home-cleaning-2bhk',
            'name' => '2 BHK Deep Cleaning',
            'rating' => '4.9',
            'reviews' => '2.4k',
            'duration' => '4 hrs',
            'price' => 3299,
            'description' =>
                'Comprehensive furnished-home deep cleaning for 2 BHK residences.',
            'included' => [
                'Complete dusting',
                'Floor cleaning',
                'Kitchen cleaning',
                'Bathroom cleaning'
            ],
            'not_included' => [
                'Exterior window cleaning'
            ]
        ]

    ],


    'Bathroom Cleaning' => [

        [
            'id' => 'bathroom-intensive',
            'name' => 'Bathroom Intensive Cleaning',
            'rating' => '4.9',
            'reviews' => '5.8k',
            'duration' => '60 min',
            'price' => 449,
            'description' =>
                'Intensive cleaning of tiles, WC, fittings, floor and hard-water stains.',
            'included' => [
                'Floor cleaning',
                'Tile cleaning',
                'WC cleaning',
                'Fittings cleaning'
            ],
            'not_included' => [
                'Major plumbing repairs'
            ]
        ],

        [
            'id' => 'bathroom-two-combo',
            'name' => '2 Bathrooms Combo',
            'rating' => '4.9',
            'reviews' => '3.9k',
            'duration' => '90 min',
            'price' => 799,
            'description' =>
                'Value combo for two bathrooms with machine-assisted deep cleaning.',
            'included' => [
                'Two bathroom cleaning',
                'Floor cleaning',
                'Tile cleaning',
                'WC and fittings cleaning'
            ],
            'not_included' => [
                'Plumbing repairs'
            ]
        ]

    ],


    'Kitchen Cleaning' => [

        [
            'id' => 'kitchen-deep-cleaning',
            'name' => 'Kitchen Deep Cleaning',
            'rating' => '4.8',
            'reviews' => '2.8k',
            'duration' => '2 hrs',
            'price' => 1199,
            'description' =>
                'Professional grease removal and surface deep cleaning for modular kitchens.',
            'included' => [
                'Platform cleaning',
                'Grease removal',
                'Cabinet exterior cleaning',
                'Tile cleaning'
            ],
            'not_included' => [
                'Internal appliance repair'
            ]
        ]

    ],


    'Sofa Cleaning' => [

        [
            'id' => 'sofa-up-to-5-seats',
            'name' => 'Sofa Cleaning – Up to 5 Seats',
            'rating' => '4.8',
            'reviews' => '2.3k',
            'duration' => '75 min',
            'price' => 799,
            'description' =>
                'Professional vacuuming, shampooing and extraction cleaning for fabric sofas.',
            'included' => [
                'Vacuuming',
                'Shampoo cleaning',
                'Extraction cleaning'
            ],
            'not_included' => [
                'Leather repair'
            ]
        ]

    ],


    'AC Service & Repair' => [

        [
            'id' => 'ac-power-service',
            'name' => 'AC Power Service',
            'rating' => '4.8',
            'reviews' => '6.1k',
            'duration' => '45 min',
            'price' => 649,
            'description' =>
                'Detailed AC cleaning and performance check at home.',
            'included' => [
                'AC cleaning',
                'Performance check',
                'Basic inspection'
            ],
            'not_included' => [
                'Replacement parts'
            ]
        ],

        [
            'id' => 'ac-repair-visit',
            'name' => 'AC Repair Visit',
            'rating' => '4.7',
            'reviews' => '4.2k',
            'duration' => '30 min',
            'price' => 299,
            'description' =>
                'Inspection and diagnosis by a verified AC technician. Repair quote shared before work.',
            'included' => [
                'Technician visit',
                'Inspection',
                'Diagnosis'
            ],
            'not_included' => [
                'Replacement parts',
                'Repair labour beyond visit'
            ]
        ]

    ],


    'Electrician' => [

        [
            'id' => 'electrician-visit',
            'name' => 'Electrician Visit',
            'rating' => '4.8',
            'reviews' => '4.4k',
            'duration' => '30 min',
            'price' => 149,
            'description' =>
                'General electrical inspection and minor electrical fixes.',
            'included' => [
                'Technician visit',
                'Basic inspection',
                'Minor electrical fixes'
            ],
            'not_included' => [
                'Major rewiring',
                'Material cost'
            ]
        ],

        [
            'id' => 'fan-installation',
            'name' => 'Fan Installation',
            'rating' => '4.8',
            'reviews' => '1.9k',
            'duration' => '45 min',
            'price' => 249,
            'description' =>
                'Safe ceiling or wall fan installation by a verified electrician.',
            'included' => [
                'Fan installation',
                'Basic fitting',
                'Electrical connection check'
            ],
            'not_included' => [
                'New wiring material'
            ]
        ]

    ],


    'Plumber' => [

        [
            'id' => 'plumber-visit',
            'name' => 'Plumber Visit',
            'rating' => '4.7',
            'reviews' => '3.8k',
            'duration' => '30 min',
            'price' => 149,
            'description' =>
                'Diagnosis and minor plumbing fixes by a verified professional.',
            'included' => [
                'Technician visit',
                'Basic inspection',
                'Minor plumbing fixes'
            ],
            'not_included' => [
                'Replacement material'
            ]
        ],

        [
            'id' => 'tap-mixer-repair',
            'name' => 'Tap / Mixer Repair',
            'rating' => '4.8',
            'reviews' => '2.2k',
            'duration' => '45 min',
            'price' => 249,
            'description' =>
                'Repair or replacement assistance for taps and mixers.',
            'included' => [
                'Inspection',
                'Minor repair',
                'Installation assistance'
            ],
            'not_included' => [
                'Replacement parts'
            ]
        ]

    ],


    'Chimney & Hob' => [

        [
            'id' => 'chimney-deep-cleaning',
            'name' => 'Chimney Deep Cleaning',
            'rating' => '4.8',
            'reviews' => '1.6k',
            'duration' => '90 min',
            'price' => 899,
            'description' =>
                'Deep degreasing of chimney filters and accessible surfaces.',
            'included' => [
                'Filter cleaning',
                'Grease removal',
                'Accessible surface cleaning'
            ],
            'not_included' => [
                'Electrical repair',
                'Replacement parts'
            ]
        ]

    ],


    'Car Cleaning' => [

        [
            'id' => 'car-exterior-interior',
            'name' => 'Car Exterior + Interior Clean',
            'rating' => '4.7',
            'reviews' => '1.1k',
            'duration' => '60 min',
            'price' => 399,
            'description' =>
                'Convenient at-home basic car exterior and interior cleaning.',
            'included' => [
                'Exterior cleaning',
                'Interior vacuuming',
                'Dashboard cleaning'
            ],
            'not_included' => [
                'Paint correction',
                'Major stain restoration'
            ]
        ]

    ],


    'Product AMC' => [

        [
            'id' => 'home-appliance-amc',
            'name' => 'Home Appliance AMC',
            'rating' => '4.6',
            'reviews' => '620',
            'duration' => '12 months',
            'price' => 1499,
            'description' =>
                'Annual service support plan for selected household appliances.',
            'included' => [
                'Annual maintenance support',
                'Scheduled inspection',
                'Basic service assistance'
            ],
            'not_included' => [
                'Replacement parts'
            ]
        ]

    ]

];


/* =========================================================
   ADD TO CART
========================================================= */

$added = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_cart_item'])) {

    $removeIndex = isset($_POST['remove_cart_index'])
        ? (int) $_POST['remove_cart_index']
        : -1;

    if (isset($_SESSION['cn_cart'][$removeIndex])) {
        unset($_SESSION['cn_cart'][$removeIndex]);

        $_SESSION['cn_cart'] = array_values($_SESSION['cn_cart']);
    }

    header('Location: booking-service.php?service=' . urlencode($serviceName));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $packageId =
        trim($_POST['package_id'] ?? '');

    $selectedPackage = null;

    if (!empty($packageData[$packageServiceName])) {

    foreach (
        $packageData[$packageServiceName]
        as $package
    ) {

            if ($package['id'] === $packageId) {

                $selectedPackage = $package;
                break;
            }
        }
    }


    if ($selectedPackage) {

        if (!isset($_SESSION['cn_cart'])) {
            $_SESSION['cn_cart'] = [];
        }


        $_SESSION['cn_cart'][] = [

            'service_id' =>
                $serviceId,

            'service_name' =>
                $serviceName,

            'package_id' =>
                $selectedPackage['id'],

            'package_name' =>
                $selectedPackage['name'],

            'duration' =>
                $selectedPackage['duration'],

            'price' =>
                $selectedPackage['price'],

            'image' =>
                $serviceImage
        ];


        $added = true;
    }
}


/* =========================================================
   CURRENT CART
========================================================= */

$cart =
    $_SESSION['cn_cart'] ?? [];

$cartTotal = 0;

foreach ($cart as $cartItem) {

    $cartTotal +=
        (float) ($cartItem['price'] ?? 0);
}


/* =========================================================
   PAGE TITLE
========================================================= */

$pageTitle =
    $serviceName . ' | Cleannora';

$pageDescription =
    'Book trusted ' .
    $serviceName .
    ' services with Cleannora.';


include 'includes/header.php';

?>


<style>

/* =========================================================
   CLEANNORA SERVICE BOOKING
========================================================= */

.cn-service-page {

    background: #f8faf8;

    min-height: 100vh;

    padding:
        24px 0 70px;
}


.cn-service-container {

    width:
        min(1180px, calc(100% - 30px));

    margin:
        0 auto;
}


/* =========================================================
   BREADCRUMB
========================================================= */

.cn-service-breadcrumb {

    margin-bottom: 18px;

    color: #77847e;

    font-size: 12px;
}

.cn-service-breadcrumb a {

    color: #557267;

    text-decoration: none;
}

.cn-service-breadcrumb span {

    margin:
        0 7px;
}


/* =========================================================
   MAIN LAYOUT
========================================================= */

.cn-service-layout {

    display: grid;

    grid-template-columns:
        190px minmax(0, 1fr) 240px;

    gap: 18px;

    align-items: start;
}


/* =========================================================
   LEFT SIDEBAR
========================================================= */

.cn-service-sidebar {

    background: #ffffff;

    border:
        1px solid #e1e9e4;

    border-radius: 16px;

    padding: 8px;

    position: sticky;

    top: 90px;
}


.cn-service-sidebar-title {

    padding:
        9px 10px 7px;

    color: #083d2b;

    font-size: 13px;

    font-weight: 850;
}


.cn-service-side-link {

    display: flex;

    align-items: center;

    gap: 7px;

    min-height: 38px;

    padding:
        8px 10px;

    border-radius: 9px;

    color: #1e2924;

    text-decoration: none;

    font-size: 11px;

    font-weight: 650;

    transition:
        .2s ease;
}


.cn-service-side-link:hover {

    background:
        #eef8f2;

    color:
        #08733d;
}


.cn-service-side-link.active {

    background:
        #e9f7ee;

    color:
        #08733d;

    font-weight: 800;
}


.cn-service-side-link.soon {

    color:
        #68746f;
}


.cn-service-side-link.soon:hover {

    background:
        #f4f5f4;

    color:
        #68746f;
}


.cn-service-soon-badge {

    margin-left:
        auto;

    padding:
        2px 5px;

    border-radius:
        20px;

    background:
        #f1f2f1;

    color:
        #7c8581;

    font-size:
        8px;

    font-weight:
        800;
}


/* =========================================================
   CENTER
========================================================= */

.cn-service-main {

    min-width:
        0;
}


/* =========================================================
   SERVICE HEADER
========================================================= */

.cn-service-header {

    display:
        flex;

    align-items:
        center;

    gap:
        15px;

    padding:
        13px;

    margin-bottom:
        17px;

    background:
        #ffffff;

    border:
        1px solid #e1e9e4;

    border-radius:
        16px;
}


.cn-service-header-image {

    width:
        150px;

    height:
        92px;

    flex:
        0 0 150px;

    overflow:
        hidden;

    border-radius:
        12px;
}


.cn-service-header-image img {

    width:
        100%;

    height:
        100%;

    display:
        block;

    object-fit:
        cover;
}


.cn-service-header h1 {

    margin:
        0 0 5px;

    color:
        #083d2b;

    font-size:
        27px;

    font-weight:
        900;
}


.cn-service-header p {

    margin:
        0;

    color:
        #68756f;

    font-size:
        11px;

    line-height:
        1.5;
}


/* =========================================================
   SECTION TITLE
========================================================= */

.cn-service-title {

    margin:
        0 0 12px;

    color:
        #083d2b;

    font-size:
        17px;

    font-weight:
        900;
}


/* =========================================================
   PACKAGE CARD
========================================================= */

.cn-package {

    display:
        grid;

    grid-template-columns:
        minmax(0, 1fr) 95px;

    gap:
        14px;

    padding:
        14px;

    margin-bottom:
        13px;

    background:
        #ffffff;

    border:
        1px solid #e1e9e4;

    border-radius:
        16px;

    transition:
        .2s ease;
}


.cn-package:hover {

    border-color:
        rgba(20,143,85,.35);

    box-shadow:
        0 10px 25px rgba(8,61,43,.06);
}


.cn-package h2 {

    margin:
        0 0 6px;

    color:
        #123d2f;

    font-size:
        14px;

    font-weight:
        850;
}


.cn-package-meta {

    margin-bottom:
        9px;

    color:
        #77827d;

    font-size:
        9px;
}


.cn-package-description {

    margin:
        0 0 9px;

    color:
        #68756f;

    font-size:
        10px;

    line-height:
        1.5;
}


.cn-package-price {

    margin-bottom:
        9px;

    color:
        #083d2b;

    font-size:
        16px;

    font-weight:
        900;
}


.cn-package-image {

    width:
        95px;

    height:
        80px;

    overflow:
        hidden;

    border-radius:
        10px;
}


.cn-package-image img {

    width:
        100%;

    height:
        100%;

    display:
        block;

    object-fit:
        cover;
}


.cn-package-actions {

    display:
        flex;

    align-items:
        center;

    gap:
        8px;
}


.cn-view-details {

    border:
        0;

    padding:
        5px 0;

    background:
        transparent;

    color:
        #148f55;

    font-size:
        10px;

    font-weight:
        800;

    cursor:
        pointer;
}


.cn-add-button {

    padding:
        6px 13px;

    border:
        1px solid #148f55;

    border-radius:
        8px;

    background:
        #ffffff;

    color:
        #148f55;

    font-size:
        10px;

    font-weight:
        850;

    cursor:
        pointer;

    transition:
        .2s ease;
}


.cn-add-button:hover {

    background:
        #148f55;

    color:
        #ffffff;
}


/* =========================================================
   COMING SOON
========================================================= */

.cn-coming-soon {

    padding:
        40px 20px;

    text-align:
        center;

    background:
        #ffffff;

    border:
        1px solid #e1e9e4;

    border-radius:
        16px;
}


.cn-coming-soon-icon {

    font-size:
        35px;

    margin-bottom:
        10px;
}


.cn-coming-soon h2 {

    margin:
        0 0 7px;

    color:
        #083d2b;

    font-size:
        20px;

    font-weight:
        900;
}


.cn-coming-soon p {

    max-width:
        450px;

    margin:
        0 auto;

    color:
        #68756f;

    font-size:
        12px;

    line-height:
        1.6;
}


/* =========================================================
   CART
========================================================= */

.cn-cart {

    position:
        sticky;

    top:
        90px;

    min-height:
        155px;

    padding:
        17px;

    background:
        #ffffff;

    border:
        1px solid #e1e9e4;

    border-radius:
        16px;
}


.cn-cart h2 {

    margin:
        0 0 25px;

    color:
        #083d2b;

    font-size:
        15px;

    font-weight:
        900;
}


.cn-cart-empty {

    padding:
        12px 3px 20px;

    text-align:
        center;

    color:
        #77827d;

    font-size:
        10px;
}


.cn-cart-icon {

    margin-bottom:
        7px;

    font-size:
        21px;
}


.cn-cart-item {

    padding:
        9px 0;

    border-bottom:
        1px solid #edf1ee;
}


.cn-cart-item strong {

    display:
        block;

    color:
        #083d2b;

    font-size:
        10px;
}


.cn-cart-item span {

    color:
        #718078;

    font-size:
        9px;
}


.cn-cart-total {

    display:
        flex;

    justify-content:
        space-between;

    margin-top:
        13px;

    color:
        #083d2b;

    font-size:
        11px;

    font-weight:
        900;
}


/* =========================================================
   ADDED MESSAGE
========================================================= */

.cn-added {

    margin-bottom:
        15px;

    padding:
        9px 12px;

    border:
        1px solid #bce6ce;

    border-radius:
        9px;

    background:
        #effbf3;

    color:
        #08733d;

    font-size:
        11px;

    font-weight:
        750;
}


/* =========================================================
   MODAL
========================================================= */

.cn-modal-overlay {

    position:
        fixed;

    z-index:
        99999;

    inset:
        0;

    display:
        none;

    align-items:
        center;

    justify-content:
        center;

    padding:
        18px;

    background:
        rgba(0,0,0,.55);
}


.cn-modal-overlay.active {

    display:
        flex;
}


.cn-modal {

    width:
        min(430px, 100%);

    max-height:
        88vh;

    overflow:
        auto;

    border-radius:
        18px;

    background:
        #ffffff;
}


.cn-modal-image {

    width:
        100%;

    height:
        175px;

    overflow:
        hidden;
}


.cn-modal-image img {

    width:
        100%;

    height:
        100%;

    object-fit:
        cover;
}


.cn-modal-content {

    padding:
        18px;
}


.cn-modal-heading {

    display:
        flex;

    justify-content:
        space-between;

    gap:
        12px;
}


.cn-modal-heading h2 {

    margin:
        0;

    color:
        #083d2b;

    font-size:
        18px;

    font-weight:
        900;
}


.cn-modal-close {

    width:
        28px;

    height:
        28px;

    border:
        0;

    border-radius:
        50%;

    background:
        #f0f3f1;

    color:
        #083d2b;

    cursor:
        pointer;
}


.cn-modal-price {

    margin:
        12px 0;

    color:
        #083d2b;

    font-size:
        17px;

    font-weight:
        900;
}


.cn-modal-content p,
.cn-modal-content li {

    color:
        #65736d;

    font-size:
        11px;

    line-height:
        1.6;
}


.cn-modal-content h3 {

    margin:
        15px 0 6px;

    color:
        #17372d;

    font-size:
        12px;

    font-weight:
        850;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1050px) {

    .cn-service-layout {

        grid-template-columns:
            175px minmax(0,1fr);

    }

    .cn-cart {

        grid-column:
            2;

        position:
            static;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 700px) {

    .cn-service-page {

        padding:
            18px 0 50px;
    }

    .cn-service-container {

        width:
            calc(100% - 20px);
    }

    .cn-service-layout {

        display:
            flex;

        flex-direction:
            column;
    }

    .cn-service-sidebar {

        position:
            static;

        width:
            100%;

        overflow-x:
            auto;

        white-space:
            nowrap;

        display:
            flex;

        gap:
            4px;

        padding:
            6px;

        scrollbar-width:
            thin;
    }

    .cn-service-sidebar-title {

        display:
            none;
    }

    .cn-service-side-link {

        flex:
            0 0 auto;

        min-height:
            34px;

        padding:
            7px 10px;

        font-size:
            10px;
    }

    .cn-service-soon-badge {

        display:
            none;
    }

    .cn-service-header {

        align-items:
            flex-start;

        flex-direction:
            column;
    }

    .cn-service-header-image {

        width:
            100%;

        height:
            150px;

        flex:
            none;
    }

    .cn-service-header h1 {

        font-size:
            23px;
    }

    .cn-package {

        grid-template-columns:
            1fr;
    }

    .cn-package-image {

        order:
            -1;

        width:
            100%;

        height:
            145px;
    }

    .cn-cart {

        width:
            100%;
    }

}


/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 430px) {

    .cn-package-actions {

        flex-wrap:
            wrap;
    }

    .cn-service-header {

        padding:
            11px;
    }

}

/* PROFESSIONAL CART ITEM */
.cn-cart-item {
    position: relative;
    padding: 12px 42px 12px 0;
    border-bottom: 1px solid #e8eee9;
}

.cn-cart-item:last-child {
    border-bottom: 0;
}

.cn-cart-item strong {
    display: block;
    color: #083D2B;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 5px;
    line-height: 1.35;
}

.cn-cart-item span {
    display: block;
    color: #7a8580;
    font-size: 11px;
    line-height: 1.4;
}

/* Small professional remove action */
.cn-cart-item form {
    margin: 0;
}

.cn-cart-item .cn-remove-btn {
    position: absolute;
    top: 10px;
    right: 0;

    border: 1px solid #f0b4b4;
    background: #fff5f5;
    color: #c62828;

    border-radius: 6px;
    padding: 4px 8px;

    font-size: 10px;
    font-weight: 700;

    cursor: pointer;
    line-height: 1;
    transition: all 0.2s ease;
}

.cn-cart-item .cn-remove-btn:hover {
    background: #c62828;
    color: #ffffff;
    border-color: #c62828;
}
}

.cn-cart-item .cn-remove-btn:hover {
    color: #dc3545;
    background: transparent;
}

.cn-checkout-btn {
    display: block;
    width: 100%;
    margin-top: 14px;
    padding: 11px 16px;
    background: #F4BF19;
    color: #083D2B;
    text-align: center;
    text-decoration: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.cn-checkout-btn:hover {
    background: #083D2B;
    color: #ffffff;
    text-decoration: none;
}

</style>


<main class="cn-service-page">

    <div class="cn-service-container">


        <!-- =================================================
             BREADCRUMB
        ================================================== -->

        <div class="cn-service-breadcrumb">

            <a href="/index.php">
                Home
            </a>

            <span>›</span>

            <a href="/services.php">
                Services
            </a>

            <span>›</span>

            <strong>
    <?= htmlspecialchars($displayServiceName); ?>
</strong>

        </div>


        <!-- =================================================
             ADDED MESSAGE
        ================================================== -->

        <?php if ($added): ?>

            <div class="cn-added">

                ✓
                <?= htmlspecialchars($serviceName); ?>
                package added successfully.

            </div>

        <?php endif; ?>


        <div class="cn-service-layout">


            <!-- =================================================
                 LEFT SIDEBAR
            ================================================== -->

            <aside class="cn-service-sidebar">

                <div class="cn-service-sidebar-title">
                    Explore Services
                </div>


                <?php foreach ($allServices as $sideService): ?>

                    <?php

                    $sideName =
                        $sideService['service_name'];

                    $sideStatus =
                        (int) $sideService['status'];

                    $isActive =
                        ($sideName === $serviceName);

                    ?>


                    <a
                        href="booking-service.php?service=<?= urlencode($sideName); ?>"
                        class="
                            cn-service-side-link
                            <?= $isActive ? 'active' : ''; ?>
                            <?= $sideStatus === 0 ? 'soon' : ''; ?>
                        "
                    >

                        <span>

                            <?php

                            $iconMap = [

                                'Instant Maid' => '🧹',
                                'Instant Maid Service' => '🧹',
                                'Cook' => '👩‍🍳',
                                'Home Cleaning' => '🏠',
                                'Deep Cleaning' => '🧽',
                                'Bathroom Cleaning' => '🚿',
                                'Kitchen Cleaning' => '🍳',
                                'Sofa Cleaning' => '🛋️',
                                'Carpet Cleaning' => '🧹',
                                'Window Cleaning' => '🪟',
                                'Office Cleaning' => '🏢',
                                'Car Cleaning' => '🚗',
                                'Move In / Out Cleaning' => '📦',
                                'AC Service & Repair' => '❄️',
                                'Electrician' => '💡',
                                'Plumber' => '🔧',
                                'Chimney & Hob' => '🍳',
                                'Product AMC' => '🧰',
                                'Salon Services' => '💇'

                            ];

                            echo
                                $iconMap[$sideName]
                                ?? '✨';

                            ?>

                        </span>


                        <span>
                            <?= htmlspecialchars($sideName); ?>
                        </span>


                        <?php if ($sideStatus === 0): ?>

                            <small class="cn-service-soon-badge">
                                Soon
                            </small>

                        <?php endif; ?>

                    </a>

                <?php endforeach; ?>

            </aside>


            <!-- =================================================
                 CENTER CONTENT
            ================================================== -->

            <section class="cn-service-main">


                <!-- SERVICE HEADER -->

                <div class="cn-service-header">

                    <div class="cn-service-header-image">

                        <img
                            src="<?= htmlspecialchars($serviceImage); ?>"
                            alt="<?= htmlspecialchars($serviceName); ?>"
                        >

                    </div>


                    <div>

                        <h1>
    <?= htmlspecialchars($displayServiceName); ?>
</h1>

                        <p>
                            <?= !empty($serviceDescription)
                                ? htmlspecialchars($serviceDescription)
                                : 'Choose a service. Transparent pricing and verified professionals.';
                            ?>
                        </p>

                    </div>

                </div>


                <?php if ($serviceStatus === 0): ?>


                    <!-- =================================================
                         COMING SOON
                    ================================================== -->

                    <div class="cn-coming-soon">

                        <div class="cn-coming-soon-icon">
                            🚀
                        </div>

                        <h2>
                            <?= htmlspecialchars($displayServiceName); ?>
is Coming Soon
                        </h2>

                        <p>
                            We are preparing this service for
                            Cleannora customers. Booking will be
                            available soon.
                        </p>

                    </div>


                <?php else: ?>


                    <?php

                    $packages =
    $packageData[$packageServiceName]
    ?? [];

                    ?>


                    <?php if (!empty($packages)): ?>


                        <h2 class="cn-service-title">
                            Choose a service
                        </h2>


                        <?php foreach ($packages as $package): ?>


                            <article class="cn-package">


                                <div>

                                    <h2>
                                        <?= htmlspecialchars(
                                            $package['name']
                                        ); ?>
                                    </h2>


                                    <div class="cn-package-meta">

                                        ★
                                        <?= htmlspecialchars(
                                            $package['rating']
                                        ); ?>

                                        ·

                                        <?= htmlspecialchars(
                                            $package['reviews']
                                        ); ?>
                                        reviews

                                        ·

                                        <?= htmlspecialchars(
                                            $package['duration']
                                        ); ?>

                                    </div>


                                    <p class="cn-package-description">

                                        <?= htmlspecialchars(
                                            $package['description']
                                        ); ?>

                                    </p>


                                    <div class="cn-package-price">

                                        ₹<?= number_format(
                                            $package['price']
                                        ); ?>

                                    </div>


                                    <div class="cn-package-actions">


                                        <button
                                            type="button"
                                            class="cn-view-details"
                                            onclick='openPackageDetails(
                                                <?= json_encode(
                                                    $package,
                                                    JSON_HEX_TAG |
                                                    JSON_HEX_APOS |
                                                    JSON_HEX_QUOT |
                                                    JSON_HEX_AMP
                                                ); ?>
                                            )'
                                        >
                                            View details
                                        </button>


                                        <form
                                            method="post"
                                            style="margin:0;"
                                        >

                                            <input
                                                type="hidden"
                                                name="package_id"
                                                value="<?= htmlspecialchars(
                                                    $package['id']
                                                ); ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="cn-add-button"
                                            >
                                                Add
                                            </button>

                                        </form>


                                    </div>

                                </div>


                                <div class="cn-package-image">

                                    <img
                                        src="<?= htmlspecialchars(
                                            $serviceImage
                                        ); ?>"
                                        alt="<?= htmlspecialchars(
                                            $package['name']
                                        ); ?>"
                                        loading="lazy"
                                    >

                                </div>


                            </article>


                        <?php endforeach; ?>


                    <?php else: ?>


                        <!-- =================================================
                             DATABASE SERVICE WITHOUT PACKAGE DATA
                        ================================================== -->

                        <h2 class="cn-service-title">
                            Service Details
                        </h2>


                        <div class="cn-package">

                            <div>

                                <h2>
                                    <?= htmlspecialchars(
                                        $serviceName
                                    ); ?>
                                </h2>


                                <p class="cn-package-description">

                                    <?= !empty($serviceDescription)
                                        ? htmlspecialchars(
                                            $serviceDescription
                                        )
                                        : 'Professional service by Cleannora.'
                                    ?>

                                </p>


                                <?php if ($servicePrice > 0): ?>

                                    <div class="cn-package-price">

                                        Starting from
                                        ₹<?= number_format(
                                            $servicePrice
                                        ); ?>

                                    </div>

                                <?php endif; ?>


                                <div class="cn-package-actions">

                                    <span
                                        style="
                                            color:#68756f;
                                            font-size:10px;
                                        "
                                    >
                                        Booking details available
                                        on confirmation.
                                    </span>

                                </div>

                            </div>


                            <div class="cn-package-image">

                                <img
                                    src="<?= htmlspecialchars(
                                        $serviceImage
                                    ); ?>"
                                    alt="<?= htmlspecialchars(
                                        $serviceName
                                    ); ?>"
                                >

                            </div>

                        </div>


                    <?php endif; ?>


                <?php endif; ?>


            </section>


            <!-- =================================================
                 CART
            ================================================== -->

            <aside class="cn-cart">

                <h2>
                    Your cart
                </h2>


                <?php if (empty($cart)): ?>


                    <div class="cn-cart-empty">

                        <div class="cn-cart-icon">
                            🛒
                        </div>

                        Your cart is empty.

                        <br>

                        Add a service to continue.

                    </div>


                <?php else: ?>


                    <?php foreach ($cart as $cartIndex => $item): ?>

                        <div class="cn-cart-item">
                            
                            <form method="post" class="cn-cart-remove-form">
    <input type="hidden" name="remove_cart_index" value="<?= (int)$cartIndex ?>">
    <button
    type="submit"
    name="remove_cart_item"
    value="1"
    class="cn-remove-btn"
    title="Remove item"
>
    Remove
</button>
</form>

                            <strong>
                                <?= htmlspecialchars(
                                    $item['package_name']
                                ); ?>
                            </strong>

                            <span>

                                <?= htmlspecialchars(
                                    $item['duration']
                                ); ?>

                                ·

                                ₹<?= number_format(
                                    $item['price']
                                ); ?>

                            </span>

                        </div>

                    <?php endforeach; ?>


                    <div class="cn-cart-total">

                        <span>
                            Total
                        </span>

                        <strong>
                            ₹<?= number_format(
                                $cartTotal
                            ); ?>
                        </strong>

                    </div>
                    
                    <?php if (!empty($cart)): ?>
    <a href="book-now.php" class="cn-checkout-btn">
    Proceed to Book
</a>
<?php endif; ?>


                <?php endif; ?>

            </aside>


        </div>

    </div>

</main>


<!-- =========================================================
     DETAILS MODAL
========================================================= -->

<div
    id="cnPackageModal"
    class="cn-modal-overlay"
    onclick="closePackageModal(event)"
>

    <div
        class="cn-modal"
        onclick="event.stopPropagation()"
    >

        <div class="cn-modal-image">

            <img
                id="cnModalImage"
                src="<?= htmlspecialchars(
                    $serviceImage
                ); ?>"
                alt=""
            >

        </div>


        <div class="cn-modal-content">

            <div class="cn-modal-heading">

                <h2 id="cnModalTitle">
                    Service Details
                </h2>

                <button
                    type="button"
                    class="cn-modal-close"
                    onclick="closePackageModal()"
                >
                    ×
                </button>

            </div>


            <div
                id="cnModalPrice"
                class="cn-modal-price"
            ></div>


            <p id="cnModalDescription"></p>


            <h3>
                What's included
            </h3>

            <ul id="cnModalIncluded"></ul>


            <h3>
                Not included
            </h3>

            <ul id="cnModalNotIncluded"></ul>


            <h3>
                Service assurance
            </h3>

            <p>
                Verified professional · transparent service
                details · customer support available.
            </p>

        </div>

    </div>

</div>


<script>

/* =========================================================
   PACKAGE DETAILS MODAL
========================================================= */

function openPackageDetails(packageData) {

    document.getElementById(
        'cnModalTitle'
    ).textContent =
        packageData.name;


    document.getElementById(
        'cnModalPrice'
    ).textContent =
        '₹' +
        Number(packageData.price)
            .toLocaleString('en-IN') +
        ' · ' +
        packageData.duration;


    document.getElementById(
        'cnModalDescription'
    ).textContent =
        packageData.description;


    const included =
        document.getElementById(
            'cnModalIncluded'
        );

    included.innerHTML = '';


    (packageData.included || [])
        .forEach(function(item) {

            const li =
                document.createElement('li');

            li.textContent =
                item;

            included.appendChild(li);

        });


    const notIncluded =
        document.getElementById(
            'cnModalNotIncluded'
        );

    notIncluded.innerHTML = '';


    (packageData.not_included || [])
        .forEach(function(item) {

            const li =
                document.createElement('li');

            li.textContent =
                item;

            notIncluded.appendChild(li);

        });


    document.getElementById(
        'cnPackageModal'
    ).classList.add('active');


    document.body.style.overflow =
        'hidden';

}


/* =========================================================
   CLOSE MODAL
========================================================= */

function closePackageModal(event) {

    if (
        event &&
        event.target &&
        event.target.id !==
        'cnPackageModal'
    ) {
        return;
    }


    document.getElementById(
        'cnPackageModal'
    ).classList.remove('active');


    document.body.style.overflow =
        '';

}


/* =========================================================
   ESC KEY
========================================================= */

document.addEventListener(
    'keydown',
    function(event) {

        if (event.key === 'Escape') {

            document.getElementById(
                'cnPackageModal'
            ).classList.remove('active');

            document.body.style.overflow =
                '';

        }

    }
);

</script>


<?php include 'includes/footer.php'; ?>