<?php
declare(strict_types=1);

session_start();

include 'includes/header.php';
?>

<section class="cn-section">
    <div class="container">

        <div class="cn-section-head text-center">
            <span class="cn-badge">Book Now</span>

            <h1 class="cn-section-title">
                Book a Cleaning or Maid Service
            </h1>

            <p class="cn-section-subtitle">
                Choose a regular slot or Instant Priority. Instant requests are dispatched first to a nearby eligible professional.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="cn-booking-box">

                    <!-- Firebase message -->
                    <div id="booking-message"></div>

                    <form id="cleannora-booking-form">

                        <div class="row g-3">

                            <!-- NAME -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="booking-name"
                                    class="form-control"
                                    placeholder="Enter your name"
                                    required
                                    autocomplete="name"
                                >
                            </div>


                            <!-- PHONE -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Phone Number
                                </label>

                                <input
                                    type="tel"
                                    name="phone"
                                    id="booking-phone"
                                    class="form-control"
                                    placeholder="Enter phone number"
                                    maxlength="10"
                                    required
                                    autocomplete="tel"
                                >
                            </div>


                            <!-- CITY -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    City / Area
                                </label>

                                <input
                                    type="text"
                                    name="city"
                                    id="booking-city"
                                    class="form-control"
                                    placeholder="Noida / Greater Noida / Sector"
                                    required
                                >
                            </div>


                            <!-- DATE -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Preferred Date
                                </label>

                                <input
                                    type="date"
                                    name="preferred_date"
                                    id="booking-date"
                                    class="form-control"
                                >
                            </div>


                            <!-- SERVICE -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Select Service
                                </label>

                                <select
                                    name="service"
                                    id="booking-service"
                                    class="form-select"
                                    required
                                >
                                    <option value="">
                                        Choose a service
                                    </option>

                                    <option>Instant Maid</option>
                                    <option>Home Cleaning</option>
                                    <option>Deep Cleaning</option>
                                    <option>Kitchen Cleaning</option>
                                    <option>Bathroom Cleaning</option>
                                    <option>Sofa Cleaning</option>
                                    <option>Carpet Cleaning</option>
                                    <option>Window Cleaning</option>
                                    <option>Office Cleaning</option>
                                    <option>Move In / Out Cleaning</option>
                                </select>
                            </div>


                            <!-- PLAN -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Select Plan
                                </label>

                                <select
                                    name="plan"
                                    id="booking-plan"
                                    class="form-select"
                                    required
                                >
                                    <option value="">
                                        Choose a plan
                                    </option>

                                    <option value="2 Hours">
                                        2 Hours — ₹399
                                    </option>

                                    <option value="4 Hours">
                                        4 Hours — ₹699
                                    </option>

                                    <option value="8 Hours">
                                        8 Hours — ₹1199
                                    </option>
                                </select>
                            </div>


                            <!-- SLOT -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Preferred Slot
                                </label>

                                <select
                                    name="slot"
                                    id="booking-slot"
                                    class="form-select"
                                    required
                                >
                                    <option value="">
                                        Choose a slot
                                    </option>

                                    <option>8 AM – 10 AM</option>
                                    <option>10 AM – 12 PM</option>
                                    <option>12 PM – 2 PM</option>
                                    <option>2 PM – 4 PM</option>
                                    <option>4 PM – 6 PM</option>
                                    <option>6 PM – 8 PM</option>
                                </select>
                            </div>


                            <!-- ADDRESS -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    Address
                                </label>

                                <input
                                    type="text"
                                    name="address"
                                    id="booking-address"
                                    class="form-control"
                                    placeholder="House / Flat / Society"
                                    required
                                >
                            </div>


                            <!-- NOTES -->
                            <div class="col-12">
                                <label class="form-label">
                                    Additional Notes
                                </label>

                                <textarea
                                    name="message"
                                    id="booking-message-input"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Tell us any special requirement..."
                                ></textarea>
                            </div>


                            <!-- LOGIN STATUS -->
                            <div class="col-12">

                                <div
                                    id="firebase-booking-status"
                                    class="small text-center"
                                ></div>

                            </div>


                            <!-- SUBMIT -->
                            <div class="col-12 text-center mt-2">

                                <button
                                    type="submit"
                                    id="booking-submit-btn"
                                    class="btn btn-book px-5"
                                >
                                    Confirm Booking
                                </button>

                            </div>

                        </div>

                    </form>


                    <!-- OTP SECTION -->
                    <div
                        id="booking-otp-section"
                        class="mt-4"
                        style="display:none;"
                    >

                        <div class="border rounded-4 p-4">

                            <h4 class="text-center mb-2">
                                Verify Your Mobile Number
                            </h4>

                            <p class="text-center text-muted mb-4">
                                Enter your mobile number and verify OTP to confirm booking.
                            </p>


                            <div id="booking-otp-message"></div>


                            <!-- PHONE -->
                            <div id="booking-phone-step">

                                <input
                                    type="tel"
                                    id="booking-auth-phone"
                                    class="form-control mb-3"
                                    placeholder="Enter 10-digit mobile number"
                                    maxlength="10"
                                    autocomplete="tel"
                                >

                                <button
                                    type="button"
                                    id="booking-send-otp"
                                    class="btn btn-success w-100"
                                >
                                    Send OTP
                                </button>

                            </div>


                            <!-- OTP -->
                            <div
                                id="booking-otp-step"
                                style="display:none;"
                            >

                                <input
                                    type="text"
                                    id="booking-otp"
                                    class="form-control mb-3"
                                    placeholder="Enter 6-digit OTP"
                                    maxlength="6"
                                    inputmode="numeric"
                                    autocomplete="one-time-code"
                                >

                                <button
                                    type="button"
                                    id="booking-verify-otp"
                                    class="btn btn-success w-100"
                                >
                                    Verify OTP & Continue
                                </button>

                                <button
                                    type="button"
                                    id="booking-change-phone"
                                    class="btn btn-link w-100 mt-2"
                                >
                                    Change Phone Number
                                </button>

                            </div>


                            <div id="booking-recaptcha"></div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
</section>


<!-- FEATURES -->
<section class="cn-section cn-soft-bg">

    <div class="container">

        <div class="row g-4 text-center">

            <div class="col-lg-4">
                <div class="cn-feature-card">
                    <h4>Quick Confirmation</h4>

                    <p>
                        Your booking request is securely submitted
                        and our team can process it quickly.
                    </p>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="cn-feature-card">
                    <h4>Flexible Plans</h4>

                    <p>
                        Choose from 2-hour, 4-hour and 8-hour
                        service plans depending on your requirement.
                    </p>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="cn-feature-card">
                    <h4>Trusted Support</h4>

                    <p>
                        Secure phone verification helps keep
                        your booking account connected to you.
                    </p>
                </div>
            </div>

        </div>

    </div>

</section>


<script type="module">

import {
    getAuth,
    onAuthStateChanged,
    RecaptchaVerifier,
    signInWithPhoneNumber
} from "https://www.gstatic.com/firebasejs/12.1.0/firebase-auth.js";


/*
|--------------------------------------------------------------------------
| Firebase
|--------------------------------------------------------------------------
*/

const auth = window.cleannoraFirebaseAuth;

if (!auth) {

    console.error(
        "CleanNora Firebase Auth is not initialized."
    );

}


/*
|--------------------------------------------------------------------------
| Elements
|--------------------------------------------------------------------------
*/

const bookingForm =
    document.getElementById("cleannora-booking-form");

const bookingSubmitBtn =
    document.getElementById("booking-submit-btn");

const bookingMessage =
    document.getElementById("booking-message");

const bookingStatus =
    document.getElementById("firebase-booking-status");

const otpSection =
    document.getElementById("booking-otp-section");

const phoneStep =
    document.getElementById("booking-phone-step");

const otpStep =
    document.getElementById("booking-otp-step");

const authPhoneInput =
    document.getElementById("booking-auth-phone");

const otpInput =
    document.getElementById("booking-otp");

const sendOtpBtn =
    document.getElementById("booking-send-otp");

const verifyOtpBtn =
    document.getElementById("booking-verify-otp");

const changePhoneBtn =
    document.getElementById("booking-change-phone");

const otpMessage =
    document.getElementById("booking-otp-message");


/*
|--------------------------------------------------------------------------
| State
|--------------------------------------------------------------------------
*/

let confirmationResult = null;
let recaptchaVerifier = null;
let currentFirebaseUser = null;


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

function showMessage(
    element,
    message,
    type = "danger"
) {

    element.innerHTML =
        `<div class="alert alert-${type}">${message}</div>`;

}


function normalizeIndianPhone(phone) {

    phone = String(phone || "")
        .replace(/\D/g, "");

    if (phone.length !== 10) {

        throw new Error(
            "Please enter a valid 10-digit mobile number."
        );

    }

    return "+91" + phone;

}


function generateRequestKey() {

    if (
        window.crypto &&
        typeof window.crypto.randomUUID === "function"
    ) {

        return window.crypto.randomUUID();

    }

    return (
        Date.now().toString(36) +
        Math.random().toString(36).substring(2)
    );

}


/*
|--------------------------------------------------------------------------
| Date restriction
|--------------------------------------------------------------------------
*/

const dateInput =
    document.getElementById("booking-date");

if (dateInput) {

    const today =
        new Date().toISOString().split("T")[0];

    dateInput.min = today;

}


/*
|--------------------------------------------------------------------------
| Firebase Auth State
|--------------------------------------------------------------------------
*/

if (auth) {

    onAuthStateChanged(
        auth,
        function (user) {

            currentFirebaseUser = user;

            if (user) {

                bookingStatus.innerHTML =
                    '<span class="text-success">✓ Mobile verified. You can confirm your booking.</span>';

                bookingSubmitBtn.innerText =
                    "Confirm Booking";

            } else {

                bookingStatus.innerHTML =
                    '<span class="text-muted">Mobile verification will be required before booking confirmation.</span>';

                bookingSubmitBtn.innerText =
                    "Continue to Booking";

            }

        }
    );

}


/*
|--------------------------------------------------------------------------
| Form submit
|--------------------------------------------------------------------------
*/

bookingForm.addEventListener(
    "submit",
    async function (event) {

        event.preventDefault();

        bookingMessage.innerHTML = "";

        /*
         * If user is not logged in,
         * open OTP section first.
         */

        if (!currentFirebaseUser) {

            const phone =
                document.getElementById(
                    "booking-phone"
                ).value.trim();

            if (!phone) {

                showMessage(
                    bookingMessage,
                    "Please enter your phone number."
                );

                return;

            }

            try {

                const normalizedPhone =
                    normalizeIndianPhone(phone);

                authPhoneInput.value =
                    normalizedPhone.replace("+91", "");

                otpSection.style.display =
                    "block";

                otpSection.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });

                showMessage(
                    otpMessage,
                    "Please verify your mobile number to continue.",
                    "info"
                );

            } catch (error) {

                showMessage(
                    bookingMessage,
                    error.message
                );

            }

            return;

        }


        /*
         * Already authenticated:
         * directly create booking.
         */

        await createBooking();

    }
);


/*
|--------------------------------------------------------------------------
| Send OTP
|--------------------------------------------------------------------------
*/

sendOtpBtn.addEventListener(
    "click",
    async function () {

        try {

            sendOtpBtn.disabled = true;

            sendOtpBtn.innerText =
                "Sending OTP...";

            otpMessage.innerHTML = "";

            const phone =
                normalizeIndianPhone(
                    authPhoneInput.value
                );


            if (!recaptchaVerifier) {

                recaptchaVerifier =
                    new RecaptchaVerifier(
                        auth,
                        "booking-recaptcha",
                        {
                            size: "invisible"
                        }
                    );

            }


            confirmationResult =
                await signInWithPhoneNumber(
                    auth,
                    phone,
                    recaptchaVerifier
                );


            phoneStep.style.display =
                "none";

            otpStep.style.display =
                "block";


            showMessage(
                otpMessage,
                "OTP sent successfully. Please check your phone.",
                "success"
            );


        } catch (error) {

            console.error(
                "Booking OTP error:",
                error
            );

            showMessage(
                otpMessage,
                "OTP could not be sent. Please check the mobile number and try again."
            );

        } finally {

            sendOtpBtn.disabled = false;

            sendOtpBtn.innerText =
                "Send OTP";

        }

    }
);


/*
|--------------------------------------------------------------------------
| Verify OTP
|--------------------------------------------------------------------------
*/

verifyOtpBtn.addEventListener(
    "click",
    async function () {

        try {

            verifyOtpBtn.disabled = true;

            verifyOtpBtn.innerText =
                "Verifying...";

            otpMessage.innerHTML = "";

            const otp =
                otpInput.value.trim();


            if (!/^\d{6}$/.test(otp)) {

                throw new Error(
                    "Please enter the 6-digit OTP."
                );

            }


            if (!confirmationResult) {

                throw new Error(
                    "Please request an OTP first."
                );

            }


            const result =
                await confirmationResult.confirm(
                    otp
                );


            currentFirebaseUser =
                result.user;


            showMessage(
                otpMessage,
                "Mobile verified successfully.",
                "success"
            );


            /*
             * Now create the actual booking.
             */

            await createBooking();


        } catch (error) {

            console.error(
                "OTP verification error:",
                error
            );

            showMessage(
                otpMessage,
                error.message ||
                "OTP verification failed."
            );

        } finally {

            verifyOtpBtn.disabled = false;

            verifyOtpBtn.innerText =
                "Verify OTP & Continue";

        }

    }
);


/*
|--------------------------------------------------------------------------
| Change phone
|--------------------------------------------------------------------------
*/

changePhoneBtn.addEventListener(
    "click",
    function () {

        otpStep.style.display =
            "none";

        phoneStep.style.display =
            "block";

        otpInput.value = "";

        otpMessage.innerHTML = "";

    }
);


/*
|--------------------------------------------------------------------------
| CREATE BOOKING
|--------------------------------------------------------------------------
*/

async function createBooking() {

    try {

        if (!auth || !auth.currentUser) {

            throw new Error(
                "Please verify your mobile number first."
            );

        }


        bookingSubmitBtn.disabled = true;

        verifyOtpBtn.disabled = true;

        bookingSubmitBtn.innerText =
            "Creating Booking...";


        showMessage(
            bookingMessage,
            "Please wait while we confirm your booking...",
            "info"
        );


        /*
         * Fresh Firebase ID token.
         */

        const idToken =
            await auth.currentUser.getIdToken(
                true
            );


        /*
         * Collect current form.
         */

        const formData =
            new FormData(bookingForm);


        formData.append(
            "idToken",
            idToken
        );


        /*
         * Duplicate-submit protection.
         */

        formData.append(
            "requestKey",
            generateRequestKey()
        );


        /*
         * Send to PHP backend.
         */

       const response = await fetch('customer/firebase-booking.php', {
    method: 'POST',
    body: formData,
    credentials: 'same-origin'
});

const rawResponse = await response.text();

console.log('Firebase booking HTTP status:', response.status);
console.log('Firebase booking raw response:', rawResponse);

let data;

try {
    data = JSON.parse(rawResponse);
} catch (jsonError) {
    throw new Error(
        'Server returned invalid response: ' +
        (rawResponse.trim() || 'EMPTY RESPONSE')
    );
}


        if (!data.success) {

            throw new Error(
                data.message ||
                "Booking could not be created."
            );

        }


        /*
         * Success
         */

        showMessage(
            bookingMessage,
            `
                <strong>✓ Booking Confirmed</strong><br>
                Your booking has been submitted successfully.<br>
                Booking ID:
                <strong>${data.code || data.bookingId}</strong>
            `,
            "success"
        );


        bookingForm.style.display =
            "none";

        otpSection.style.display =
            "none";


        /*
         * Optional redirect after short delay.
         */

        setTimeout(
            function () {

                window.location.href =
                    "track-booking.php";

            },
            2500
        );


    } catch (error) {

        console.error(
            "Booking creation error:",
            error
        );

        showMessage(
            bookingMessage,
            error.message ||
            "Booking could not be created. Please try again."
        );

        bookingSubmitBtn.disabled =
            false;

        bookingSubmitBtn.innerText =
            "Confirm Booking";

    }

}

</script>


<?php include 'includes/footer.php'; ?>