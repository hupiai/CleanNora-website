<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/firebase.php';
require_once __DIR__ . '/../includes/firebase-booking.php';
function replyJson(bool $success,string $message,array $extra=[]): never {
 echo json_encode(array_merge(['success'=>$success,'message'=>$message],$extra)); exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') replyJson(false,'Invalid request.');
try {
 $uid=verifyFirebaseIdToken((string)($_POST['idToken']??''));
 $type=((string)($_POST['booking_type']??'scheduled'))==='instant'?'instant':'scheduled';
 $service=trim((string)($_POST['service']??''));
 $slot=$type==='instant'?'Instant Priority - target 10-15 min':trim((string)($_POST['slot']??''));
 if($service==='') throw new InvalidArgumentException('Please select a service.');
 if($type==='scheduled' && $slot==='') throw new InvalidArgumentException('Please select a slot.');
 $priorityFee=$type==='instant'?99.0:0.0;
 $booking=[
  'customerName'=>trim((string)($_POST['name']??'')),
  'service'=>$service,
  'plan'=>trim((string)($_POST['plan']??'')),
  'slot'=>$slot,
  'preferredDate'=>$type==='instant'?date('Y-m-d'):trim((string)($_POST['preferred_date']??'')),
  'bookingType'=>$type,
  'isInstantPriority'=>$type==='instant',
  'priority'=>$type==='instant'?'high':'normal',
  'targetArrivalMinutes'=>$type==='instant'?15:null,
  'priorityFee'=>$priorityFee,
  'gross'=>$priorityFee,
  'paymentMethod'=>'pending',
  'notes'=>trim((string)($_POST['message']??'')),
  'source'=>'web'
 ];
 $private=[
  'name'=>trim((string)($_POST['name']??'')),
  'phone'=>trim((string)($_POST['phone']??'')),
  'city'=>trim((string)($_POST['city']??'')),
  'address'=>trim((string)($_POST['address']??''))
 ];
 $id=createFirebaseServiceBooking($uid,$booking,$private);
 replyJson(true,'Booking created.',['bookingId'=>$id,'code'=>'CN-'.substr($id,0,6)]);
} catch(Throwable $e) {
 error_log('CleanNora booking endpoint error: '.$e->getMessage());
 replyJson(false,$e instanceof InvalidArgumentException?$e->getMessage():'Booking could not be created.');
}