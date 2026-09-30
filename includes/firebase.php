<?php

declare(strict_types=1);

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Google\Cloud\Firestore\FirestoreClient;

require_once '/home/u345631720/cleannora-firebase/vendor/autoload.php';

/**
 * Create/reuse Firebase Factory.
 */
function firebaseFactory(): Factory
{
    static $factory = null;

    if ($factory instanceof Factory) {
        return $factory;
    }

    $credentials = '/home/u345631720/cleannora-firebase/firebase-service-account.json';

    if (!is_readable($credentials)) {
        throw new RuntimeException(
            'Firebase credentials are not available.'
        );
    }

    $factory = (new Factory)
        ->withServiceAccount($credentials);

    return $factory;
}

/**
 * Get Firebase Auth client.
 */
function firebaseAuth(): Auth
{
    static $auth = null;

    if ($auth instanceof Auth) {
        return $auth;
    }

    $auth = firebaseFactory()->createAuth();

    return $auth;
}

/**
 * Verify Firebase ID token sent by browser.
 *
 * Returns verified Firebase UID.
 */
function verifyFirebaseIdToken(string $idToken): string
{
    $idToken = trim($idToken);

    if ($idToken === '') {
        throw new InvalidArgumentException(
            'Firebase ID token is missing.'
        );
    }

    $verifiedIdToken = firebaseAuth()->verifyIdToken($idToken);

    $uid = $verifiedIdToken->claims()->get('sub');

    if (!is_string($uid) || $uid === '') {
        throw new RuntimeException(
            'Firebase UID could not be verified.'
        );
    }

    return $uid;
}

/**
 * Get the actual Google Cloud Firestore client.
 *
 * Important:
 * createFirestore() returns Kreait's Firestore component.
 * ->database() returns Google\Cloud\Firestore\FirestoreClient.
 */
function firebaseFirestore(): FirestoreClient
{
    static $firestore = null;

    if ($firestore instanceof FirestoreClient) {
        return $firestore;
    }

    $firestoreComponent = firebaseFactory()->createFirestore();

    $firestore = $firestoreComponent->database();

    return $firestore;
}