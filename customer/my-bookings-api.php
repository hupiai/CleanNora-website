<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__.'/../includes/firebase.php';
function respond(bool $success,string $message,array $data=[]): never {echo json_encode(array_merge(['success'=>$success,'message'=>$message],$data));exit;}
if($_SERVER['REQUEST_METHOD']!=='POST') respond(false,'Invalid request.');
try{
 $uid=verifyFirebaseIdToken((string)($_POST['idToken']??''));
 $docs=firebaseFirestore()->collection('bookings')->where('customerId','=',$uid)->documents();
 $items=[];
 foreach($docs as $doc){if(!$doc->exists())continue;$d=$doc->data();$state=strtolower((string)($d['state']??'requested'));$labels=['requested'=>'Booking Received','pending'=>'Booking Received','accepted'=>'Partner Assigned','assigned'=>'Partner Assigned','on_the_way'=>'Partner On The Way','arrived'=>'Partner Arrived','in_progress'=>'Service In Progress','completed'=>'Service Completed','cancelled'=>'Booking Cancelled'];$items[]=['id'=>$doc->id(),'code'=>(string)($d['code']??''),'service'=>(string)($d['service']??''),'state'=>$state,'statusLabel'=>$labels[$state]??ucwords(str_replace('_',' ',$state)),'bookingType'=>(string)($d['bookingType']??'scheduled'),'preferredDate'=>(string)($d['preferredDate']??''),'slot'=>(string)($d['slot']??''),'gross'=>(float)($d['gross']??0),'partnerName'=>(string)($d['partnerName']??''),'paymentStatus'=>(string)($d['paymentStatus']??'pending')];}
 respond(true,'Bookings loaded.',['bookings'=>$items]);
}catch(Throwable $e){error_log('CleanNora account bookings error: '.$e->getMessage());respond(false,'Unable to load bookings right now.');}