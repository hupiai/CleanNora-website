<?php

declare(strict_types=1);

use Google\Cloud\Core\Timestamp;

require_once __DIR__ . '/firebase.php';

/**
 * Create a service booking in the existing CleanNora Firestore architecture.
 *
 * Collection:
 * /bookings/{bookingId}
 *
 * This matches the existing Customer App booking structure.
 */
function createFirebaseServiceBooking(
    string $firebaseUid,
    array $bookingData,
    array $privateCustomerData
): string {
    $firebaseUid = trim($firebaseUid);

    if ($firebaseUid === '') {
        throw new InvalidArgumentException(
            'Authenticated Firebase UID is required.'
        );
    }

    /*
     * Get Firestore client.
     */
    $firestore = firebaseFirestore();

    /*
     * Generate a Firestore document reference first.
     * The document is not written until ->set().
     */
    $bookingRef = $firestore
        ->collection('bookings')
        ->newDocument();

    $bookingId = $bookingRef->id();

    /*
     * Existing Customer App contract:
     *
     * code = CN-{first 6 characters of bookingId}
     */
    $bookingData['code'] = 'CN-' . substr($bookingId, 0, 6);

    /*
     * Firebase UID must always come from the
     * verified Firebase ID token.
     */
    $bookingData['customerId'] = $firebaseUid;

    /*
     * Initial partner state.
     * Existing Cloud Function will handle dispatch.
     */
    $bookingData['partnerId'] = null;
    $bookingData['partnerName'] = null;
    $bookingData['partnerPhone'] = null;

    /*
     * Initial payment / booking state.
     */
    $bookingData['paymentStatus'] = 'pending';
    $bookingData['state'] = 'requested';

    /*
     * Initial lifecycle flags.
     */
    $bookingData['checklistComplete'] = false;
    $bookingData['beforeProof'] = false;
    $bookingData['afterProof'] = false;
    $bookingData['startOtpVerified'] = false;
    $bookingData['completionOtpVerified'] = false;

    /*
     * Default values expected by the Customer App.
     */
    if (!array_key_exists('addOns', $bookingData)) {
        $bookingData['addOns'] = 0.0;
    }

    if (!array_key_exists('distanceKm', $bookingData)) {
        $bookingData['distanceKm'] = 0.0;
    }

    /*
     * Use Firestore-compatible Timestamp objects.
     */
    $now = new Timestamp(new DateTimeImmutable('now', new DateTimeZone('UTC')));

    $bookingData['createdAt'] = $now;
    $bookingData['updatedAt'] = $now;

    /*
     * Create main booking document.
     */
    $bookingRef->set($bookingData);

    /*
     * Store exact customer/address information
     * inside the private/customer sub-document.
     */
    if (!empty($privateCustomerData)) {

        $privateCustomerData['customerId'] = $firebaseUid;
        $privateCustomerData['bookingId'] = $bookingId;
        $privateCustomerData['updatedAt'] = $now;

        $bookingRef
            ->collection('private')
            ->document('customer')
            ->set($privateCustomerData);
    }

    return $bookingId;
}