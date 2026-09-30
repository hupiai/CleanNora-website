<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__.'/../includes/nora-wallet.php';
function walletReply(bool $success,string $message,array $extra=[]): never {echo json_encode(array_merge(['success'=>$success,'message'=>$message],$extra));exit;}
try{
 $uid=verifyFirebaseIdToken((string)($_POST['idToken']??''));
 noraEnsureWallet($uid);
 if(($_POST['action']??'')==='apply_referral'){noraLinkReferral($uid,(string)($_POST['referralCode']??''));}
 $wallet=noraEnsureWallet($uid);
 $ledger=[];$docs=noraWalletRef($uid)->collection('ledger')->documents();
 foreach($docs as $doc){if($doc->exists()){$d=$doc->data();$ledger[]=['id'=>$doc->id(),'type'=>(string)($d['type']??''),'amount'=>(float)($d['amount']??0),'direction'=>(string)($d['direction']??'credit')];}}
 walletReply(true,'Wallet loaded.',['wallet'=>['balance'=>(float)($wallet['balance']??0),'referralCode'=>(string)($wallet['referralCode']??noraReferralCode($uid)),'referredByCode'=>(string)($wallet['referredByCode']??''),'coinValue'=>NORA_COIN_INR_VALUE],'ledger'=>$ledger]);
}catch(Throwable $e){error_log('Nora wallet error: '.$e->getMessage());walletReply(false,$e instanceof InvalidArgumentException?$e->getMessage():'Unable to load wallet.');}