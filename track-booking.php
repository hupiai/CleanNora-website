<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/firebase.php';

/*
|--------------------------------------------------------------------------
| CleanNora Firebase Booking Tracking
|--------------------------------------------------------------------------
| Reads the SAME Firestore /bookings/{bookingId} document
| used by Customer App and Partner App.
|
| No MySQL booking table is used here.
|--------------------------------------------------------------------------
*/

function cleanNoraTrackingResponse(
    bool $success,
    string $message,
    array $data = []
): never {
    header('Content-Type: application/json; charset=utf-8');

    echo json_encode(
        array_merge(
            [
                'success' => $success,
                'message' => $message,
            ],
            $data
        ),
        JSON_UNESCAPED_UNICODE
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| STATUS NORMALIZATION
|--------------------------------------------------------------------------
| Customer/Partner App uses the Firestore "state" field.
| We support common state names without changing the Firestore value.
|--------------------------------------------------------------------------
*/

function normalizeBookingState(string $state): string
{
    $state = strtolower(trim($state));

    $map = [

        // Initial
        'requested' => 'requested',
        'pending' => 'requested',

        // Partner accepted / assigned
        'accepted' => 'assigned',
        'assigned' => 'assigned',
        'partner_assigned' => 'assigned',
        'partner-assigned' => 'assigned',

        // Partner on the way
        'ontheway' => 'on_the_way',
        'on_the_way' => 'on_the_way',
        'on-the-way' => 'on_the_way',
        'onway' => 'on_the_way',

        // Partner arrived
        'arrived' => 'arrived',
        'partner_arrived' => 'arrived',
        'partner-arrived' => 'arrived',

        // Service started
        'inprogress' => 'in_progress',
        'in_progress' => 'in_progress',
        'in-progress' => 'in_progress',
        'started' => 'in_progress',

        // Service completed
        'completed' => 'completed',
        'complete' => 'completed',

        // Cancelled
        'cancelled' => 'cancelled',
        'canceled' => 'cancelled',
    ];

    return $map[$state] ?? $state;
}

/*
|--------------------------------------------------------------------------
| STATUS LABEL
|--------------------------------------------------------------------------
*/

function bookingStatusLabel(string $state): string
{
    $state = normalizeBookingState($state);

    return match ($state) {
        'requested'   => 'Booking Received',
        'assigned'    => 'Partner Assigned',
        'on_the_way'  => 'Partner On The Way',
        'arrived'     => 'Partner Arrived',
        'in_progress' => 'Service In Progress',
        'completed'   => 'Service Completed',
        'cancelled'   => 'Booking Cancelled',
        default       => ucwords(str_replace('_', ' ', $state)),
    };
}


/*
|--------------------------------------------------------------------------
| READ FIRESTORE BOOKING
|--------------------------------------------------------------------------
*/

function getFirebaseBooking(string $bookingInput): ?array
{
    $bookingInput = trim($bookingInput);

    if ($bookingInput === '') {
        return null;
    }

    $firestore = firebaseFirestore();

    $bookingCollection = $firestore->collection('bookings');

    /*
     * --------------------------------------------------------------
     * 1. Try exact Firestore document ID first.
     * --------------------------------------------------------------
     */

    $document = $bookingCollection
        ->document($bookingInput)
        ->snapshot();

    if ($document->exists()) {

        $data = $document->data();

        return [
            'id'   => $document->id(),
            'data' => is_array($data) ? $data : [],
        ];
    }


    /*
     * --------------------------------------------------------------
     * 2. If user enters CN-XXXXXX,
     *    find booking using Firestore "code".
     * --------------------------------------------------------------
     */

    $query = $bookingCollection
        ->where('code', '=', $bookingInput);

    $documents = $query->documents();

    foreach ($documents as $doc) {

        if (!$doc->exists()) {
            continue;
        }

        $data = $doc->data();

        return [
            'id'   => $doc->id(),
            'data' => is_array($data) ? $data : [],
        ];
    }


    return null;
}


/*
|--------------------------------------------------------------------------
| AJAX TRACKING REQUEST
|--------------------------------------------------------------------------
| JavaScript polls this same page every few seconds.
| This gives the website near-live status updates from Firestore.
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['ajax_tracking'])
) {

    try {

        $bookingInput = trim(
            (string)($_POST['booking_id'] ?? '')
        );

        if ($bookingInput === '') {
            cleanNoraTrackingResponse(
                false,
                'Please enter your Booking ID.'
            );
        }

        $booking = getFirebaseBooking($bookingInput);

        if (!$booking) {
            cleanNoraTrackingResponse(
                false,
                'Booking not found. Please check your Booking ID.'
            );
        }

        $data = $booking['data'];

        $state = normalizeBookingState(
            (string)($data['state'] ?? 'requested')
        );

        cleanNoraTrackingResponse(
            true,
            'Booking found.',
            [
                'bookingId'     => $booking['id'],
                'code'          => (string)($data['code'] ?? ''),
                'state'         => $state,
                'statusLabel'   => bookingStatusLabel($state),

                'customerName'  => (string)($data['customerName'] ?? ''),
                'service'       => (string)($data['service'] ?? ''),
                'gross'         => (float)($data['gross'] ?? 0),
                'paymentMethod' => (string)($data['paymentMethod'] ?? ''),
                'paymentStatus' => (string)($data['paymentStatus'] ?? 'pending'),
                'slot'          => (string)($data['slot'] ?? ''),

                'partnerName'   => (string)($data['partnerName'] ?? ''),
                'partnerPhone'  => (string)($data['partnerPhone'] ?? ''),
            ]
        );

    } catch (Throwable $e) {

        error_log(
            'CleanNora tracking error: ' .
            $e->getMessage()
        );

        cleanNoraTrackingResponse(
            false,
            'Unable to load booking status right now.'
        );
    }
}

?>

<?php

require_once __DIR__ . '/includes/header.php';

?>

<style>
    .cn-track-page {
        padding: 70px 0 80px;
        min-height: 65vh;
    }

    .cn-track-title {
        color: #083D2B;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .cn-track-subtitle {
        color: #64748b;
        margin-bottom: 35px;
    }

    .cn-track-search {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 10px 35px rgba(8, 61, 43, 0.08);
        border: 1px solid #e8eee9;
    }

    .cn-track-search input {
        min-height: 52px;
        border-radius: 12px;
    }

    .cn-track-btn {
        min-height: 52px;
        border: 0;
        border-radius: 12px;
        background: #083D2B;
        color: #ffffff;
        font-weight: 700;
    }

    .cn-track-btn:hover {
        background: #062f22;
        color: #ffffff;
    }

    .cn-track-card {
        background: #ffffff;
        border-radius: 22px;
        padding: 28px;
        margin-top: 30px;
        box-shadow: 0 12px 40px rgba(8, 61, 43, 0.09);
        border: 1px solid #e7eee9;
    }

    .cn-booking-top {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: center;
        margin-bottom: 25px;
    }

    .cn-booking-id {
        color: #083D2B;
        font-size: 20px;
        font-weight: 800;
        word-break: break-all;
    }

    .cn-booking-amount {
        color: #0f9d58;
        font-size: 28px;
        font-weight: 800;
        white-space: nowrap;
    }

    .cn-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 35px;
    }

    .cn-info-box {
        background: #f7faf8;
        border-radius: 14px;
        padding: 16px;
    }

    .cn-info-label {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .cn-info-value {
        color: #083D2B;
        font-weight: 700;
    }

    .cn-progress-title {
        color: #083D2B;
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 25px;
    }

    .cn-timeline {
        position: relative;
        padding-left: 48px;
    }

    .cn-timeline::before {
        content: "";
        position: absolute;
        left: 16px;
        top: 12px;
        bottom: 12px;
        width: 3px;
        background: #e2e8f0;
        border-radius: 5px;
    }

    .cn-step {
        position: relative;
        min-height: 82px;
    }

    .cn-step-dot {
        position: absolute;
        left: -48px;
        top: 2px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #ffffff;
        border: 3px solid #d5dde5;
        z-index: 2;
    }

    .cn-step.completed .cn-step-dot,
    .cn-step.current .cn-step-dot {
        background: #0f9d58;
        border-color: #0f9d58;
    }

    .cn-step.completed .cn-step-dot::after,
    .cn-step.current .cn-step-dot::after {
        content: "✓";
        color: #ffffff;
        font-size: 16px;
        font-weight: 800;
        position: absolute;
        left: 7px;
        top: 2px;
    }

    .cn-step-title {
        color: #475569;
        font-size: 17px;
        font-weight: 700;
    }

    .cn-step.current .cn-step-title {
        color: #083D2B;
    }

    .cn-step.completed .cn-step-title {
        color: #0f9d58;
    }

    .cn-step-status {
        color: #94a3b8;
        font-size: 14px;
        margin-top: 3px;
    }

    .cn-step.current .cn-step-status {
        color: #0f9d58;
        font-weight: 600;
    }

    .cn-partner-box {
        background: #f2faf5;
        border: 1px solid #ccebd7;
        border-radius: 16px;
        padding: 18px;
        margin-top: 10px;
    }

    .cn-partner-name {
        color: #083D2B;
        font-weight: 800;
    }

    .cn-alert {
        border-radius: 14px;
        margin-top: 20px;
    }

    @media (max-width: 767px) {

        .cn-track-page {
            padding: 40px 0 60px;
        }

        .cn-track-card {
            padding: 20px;
        }

        .cn-booking-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .cn-booking-amount {
            font-size: 25px;
        }

        .cn-info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>


<section class="cn-track-page">

    <div class="container">

        <div class="text-center">

            <h1 class="cn-track-title">
                Track Booking
            </h1>

            <p class="cn-track-subtitle">
                Track your CleanNora service status in real time.
            </p>

        </div>


        <!-- SEARCH -->

        <div class="cn-track-search">

            <form
                id="trackingForm"
                class="row g-2"
                autocomplete="off"
            >

                <div class="col-md-10">

                    <input
                        type="text"
                        id="booking_id"
                        class="form-control"
                        placeholder="Enter Booking ID or Booking Code"
                        required
                    >

                </div>

                <div class="col-md-2">

                    <button
                        type="submit"
                        id="trackButton"
                        class="btn cn-track-btn w-100"
                    >
                        Track
                    </button>

                </div>

            </form>

            <div id="trackingMessage"></div>

        </div>


        <!-- RESULT -->

        <div
            id="trackingResult"
            style="display:none;"
        ></div>

    </div>

</section>


<script>
(function () {

    const form = document.getElementById('trackingForm');
    const input = document.getElementById('booking_id');
    const button = document.getElementById('trackButton');
    const message = document.getElementById('trackingMessage');
    const result = document.getElementById('trackingResult');

    let currentBookingId = '';
    let pollingTimer = null;


    function escapeHtml(value) {

        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }


    function showMessage(text, type = 'danger') {

        message.innerHTML =
            '<div class="alert alert-' +
            type +
            ' cn-alert">' +
            escapeHtml(text) +
            '</div>';
    }


    function getSteps() {

        return [
            {
                state: 'requested',
                title: 'Booking Received'
            },
            {
                state: 'assigned',
                title: 'Partner Assigned'
            },
            {
                state: 'on_the_way',
                title: 'Partner On The Way'
            },
            {
                state: 'arrived',
                title: 'Partner Arrived'
            },
            {
                state: 'in_progress',
                title: 'Service In Progress'
            },
            {
                state: 'completed',
                title: 'Service Completed'
            }
        ];

    }


function getStateIndex(state) {

    state = String(state || '').trim().toLowerCase();

    const stateMap = {
        'requested': 'requested',
        'pending': 'requested',

        'accepted': 'assigned',
        'assigned': 'assigned',
        'partner_assigned': 'assigned',

        'on_the_way': 'on_the_way',
        'on-the-way': 'on_the_way',
        'ontheway': 'on_the_way',

        'arrived': 'arrived',
        'partner_arrived': 'arrived',

        'in_progress': 'in_progress',
        'in-progress': 'in_progress',
        'inprogress': 'in_progress',
        'started': 'in_progress',

        'completed': 'completed',
        'complete': 'completed'
    };

    const normalizedState = stateMap[state] || state;

    const states = [
        'requested',
        'assigned',
        'on_the_way',
        'arrived',
        'in_progress',
        'completed'
    ];

    return states.indexOf(normalizedState);
}


    function renderTracking(data) {

        const rawState = String(data.state || 'requested')
    .trim()
    .toLowerCase();

const stateMap = {
    'pending': 'requested',
    'requested': 'requested',

    'accepted': 'assigned',
    'assigned': 'assigned',
    'partner_assigned': 'assigned',

    'on_the_way': 'on_the_way',
    'on-the-way': 'on_the_way',
    'ontheway': 'on_the_way',

    'arrived': 'arrived',
    'partner_arrived': 'arrived',

    'in_progress': 'in_progress',
    'in-progress': 'in_progress',
    'inprogress': 'in_progress',
    'started': 'in_progress',

    'completed': 'completed',
    'complete': 'completed'
};

const currentState = stateMap[rawState] || rawState;

        const currentIndex = getStateIndex(currentState);

        let timelineHtml = '';

        getSteps().forEach(function (step, index) {

            let className = '';

            let statusText = 'Pending';

            if (currentState === 'cancelled') {

                if (index === 0) {
                    className = 'completed';
                    statusText = 'Booking Received';
                }

            } else if (index < currentIndex) {

                className = 'completed';
                statusText = 'Completed';

            } else if (index === currentIndex) {

                className = 'current';
                statusText = 'Current status';

            }

            timelineHtml +=
                '<div class="cn-step ' + className + '">' +

                    '<div class="cn-step-dot"></div>' +

                    '<div class="cn-step-title">' +
                        escapeHtml(step.title) +
                    '</div>' +

                    '<div class="cn-step-status">' +
                        escapeHtml(statusText) +
                    '</div>' +

                '</div>';

        });


        let partnerHtml = '';

        if (data.partnerName) {

            partnerHtml =
                '<div class="cn-partner-box">' +

                    '<div class="cn-info-label">' +
                        'Assigned Professional' +
                    '</div>' +

                    '<div class="cn-partner-name">' +
                        escapeHtml(data.partnerName) +
                    '</div>' +

                    (
                        data.partnerPhone
                        ?
                        '<div class="mt-1">' +
                            escapeHtml(data.partnerPhone) +
                        '</div>'
                        :
                        ''
                    ) +

                '</div>';

        }


        result.innerHTML =

            '<div class="cn-track-card">' +

                '<div class="cn-booking-top">' +

                    '<div>' +

                        '<div class="cn-info-label">' +
                            'Booking' +
                        '</div>' +

                        '<div class="cn-booking-id">' +
                            escapeHtml(data.bookingId) +
                        '</div>' +

                        (
                            data.code
                            ?
                            '<div class="cn-info-label mt-1">' +
                                'Code: ' +
                                escapeHtml(data.code) +
                            '</div>'
                            :
                            ''
                        ) +

                    '</div>' +

                    '<div class="cn-booking-amount">' +
                        '₹' +
                        Number(data.gross || 0).toLocaleString('en-IN') +
                    '</div>' +

                '</div>' +


                '<div class="cn-info-grid">' +

                    '<div class="cn-info-box">' +

                        '<div class="cn-info-label">' +
                            'Service' +
                        '</div>' +

                        '<div class="cn-info-value">' +
                            escapeHtml(data.service || '-') +
                        '</div>' +

                    '</div>' +


                    '<div class="cn-info-box">' +

                        '<div class="cn-info-label">' +
                            'Slot' +
                        '</div>' +

                        '<div class="cn-info-value">' +
                            escapeHtml(data.slot || '-') +
                        '</div>' +

                    '</div>' +


                    '<div class="cn-info-box">' +

                        '<div class="cn-info-label">' +
                            'Payment' +
                        '</div>' +

                        '<div class="cn-info-value">' +
                            escapeHtml(
                                data.paymentStatus || 'pending'
                            ) +
                        '</div>' +

                    '</div>' +

                '</div>' +


                '<div class="cn-progress-title">' +
                    'Service Progress' +
                '</div>' +

                '<div class="cn-timeline">' +
                    timelineHtml +
                '</div>' +

                partnerHtml +

            '</div>';


        result.style.display = 'block';

    }


    async function fetchTracking(showLoader = false) {

        const bookingId = currentBookingId || input.value.trim();

        if (!bookingId) {
            return;
        }


        if (showLoader) {

            button.disabled = true;
            button.innerText = 'Loading...';

        }


        try {

            const formData = new FormData();

            formData.append(
                'ajax_tracking',
                '1'
            );

            formData.append(
                'booking_id',
                bookingId
            );


            const response = await fetch(
                window.location.pathname,
                {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                }
            );


            const data = await response.json();


            if (!data.success) {

                if (showLoader) {

                    result.style.display = 'none';

                    showMessage(
                        data.message ||
                        'Booking not found.'
                    );

                }

                return;

            }


            message.innerHTML = '';

            currentBookingId = data.bookingId;

            renderTracking(data);

        } catch (error) {

            console.error(
                'CleanNora tracking error:',
                error
            );

            if (showLoader) {

                showMessage(
                    'Unable to load booking status. Please try again.'
                );

            }

        } finally {

            if (showLoader) {

                button.disabled = false;
                button.innerText = 'Track';

            }

        }

    }


    form.addEventListener(
        'submit',
        function (event) {

            event.preventDefault();

            currentBookingId = input.value.trim();

            if (!currentBookingId) {

                showMessage(
                    'Please enter your Booking ID.'
                );

                return;

            }

            fetchTracking(true);

            /*
             * Stop previous polling.
             */

            if (pollingTimer) {

                clearInterval(
                    pollingTimer
                );

            }

            /*
             * Check Firestore every 5 seconds.
             *
             * Partner App changes Firestore state.
             * Website then receives the latest state.
             */

            pollingTimer = setInterval(
                function () {
                    fetchTracking(false);
                },
                5000
            );

        }
    );

})();
</script>


<?php include 'includes/footer.php'; ?>