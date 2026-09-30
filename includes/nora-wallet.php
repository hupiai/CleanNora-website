<?php
declare(strict_types=1);
require_once __DIR__.'/firebase.php';

/*
 CleanNora Nora Coin wallet rules
 - 1 Nora Coin = INR 1 redemption value.
 - Successful referral signup/link: referrer receives 50 coins once.
 - Every COMPLETED booking by referred customer: referrer receives 0.50 coin.
 - Wallet ledger uses deterministic event IDs to prevent duplicate rewards.
 - Coins can be redeemed against eligible CleanNora services/products.
*/
const NORA_REFERRAL_BONUS = 50.0;
const NORA_COMPLETED_BOOKING_REWARD = 0.50;
const NORA_COIN_INR_VALUE = 1.0;

function noraWalletRef(string $uid) {
    return firebaseFirestore()->collection('wallets')->document($uid);
}
function noraReferralCode(string $uid): string {
    return 'NORA'.strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/','',$uid),0,8));
}
function noraEnsureWallet(string $uid): array {
    $ref=noraWalletRef($uid); $snap=$ref->snapshot();
    if(!$snap->exists()){
        $data=['customerId'=>$uid,'referralCode'=>noraReferralCode($uid),'balance'=>0.0,'lifetimeEarned'=>0.0,'lifetimeSpent'=>0.0];
        $ref->set($data); return $data;
    }
    return $snap->data();
}
function noraCreditOnce(string $uid,string $eventId,float $amount,string $type,array $meta=[]): bool {
    if($amount<=0) return false;
    $db=firebaseFirestore(); $wallet=$db->collection('wallets')->document($uid);
    $event=$wallet->collection('ledger')->document($eventId);
    if($event->snapshot()->exists()) return false;
    $current=noraEnsureWallet($uid); $balance=(float)($current['balance']??0);
    $earned=(float)($current['lifetimeEarned']??0);
    $event->set(array_merge(['type'=>$type,'amount'=>$amount,'direction'=>'credit','createdAt'=>new Google\Cloud\Core\Timestamp(new DateTimeImmutable('now',new DateTimeZone('UTC'))) ],$meta));
    $wallet->set(['balance'=>$balance+$amount,'lifetimeEarned'=>$earned+$amount],['merge'=>true]);
    return true;
}
function noraLinkReferral(string $customerUid,string $code): array {
    $code=strtoupper(trim($code)); if($code==='') return ['linked'=>false];
    $db=firebaseFirestore(); $matches=$db->collection('wallets')->where('referralCode','=',$code)->documents();
    $referrer=null; foreach($matches as $doc){if($doc->exists()){$referrer=$doc->id();break;}}
    if(!$referrer || $referrer===$customerUid) throw new InvalidArgumentException('Invalid referral code.');
    $customer=noraEnsureWallet($customerUid);
    if(!empty($customer['referredBy'])) return ['linked'=>false,'alreadyLinked'=>true];
    noraWalletRef($customerUid)->set(['referredBy'=>$referrer,'referredByCode'=>$code],['merge'=>true]);
    noraCreditOnce($referrer,'referral-'.$customerUid,NORA_REFERRAL_BONUS,'referral_bonus',['referredCustomerId'=>$customerUid]);
    return ['linked'=>true];
}
function noraRewardCompletedBooking(string $bookingId,array $booking): bool {
    $customer=(string)($booking['customerId']??''); if($customer==='') return false;
    $wallet=noraEnsureWallet($customer); $referrer=(string)($wallet['referredBy']??''); if($referrer==='') return false;
    return noraCreditOnce($referrer,'completed-'.$bookingId,NORA_COMPLETED_BOOKING_REWARD,'referral_booking_reward',['bookingId'=>$bookingId,'referredCustomerId'=>$customer]);
}
