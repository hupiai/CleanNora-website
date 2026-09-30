<?php
declare(strict_types=1);
require_once __DIR__.'/../includes/firebase.php';
$pageTitle='My Account | CleanNora';
include __DIR__.'/../includes/header.php';
?>
<style>
.cn-account{background:#f6f8f6;min-height:75vh;padding:42px 0}.cn-account-shell{max-width:1120px;margin:auto;padding:0 18px}.cn-profile,.cn-booking-card,.cn-login-card{background:#fff;border:1px solid #e4e9e5;border-radius:20px;box-shadow:0 8px 30px rgba(8,61,43,.06)}.cn-profile{padding:22px;display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:22px}.cn-avatar{width:52px;height:52px;border-radius:50%;display:grid;place-items:center;background:#083d2b;color:#fff;font-size:22px}.cn-booking-card{padding:20px;margin-bottom:14px}.cn-pill{display:inline-block;border-radius:999px;padding:5px 10px;background:#eef7f1;color:#083d2b;font-size:12px;font-weight:700}.cn-instant{background:#fff4cf;color:#755700}.cn-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:14px}.cn-k{font-size:12px;color:#7a8580}.cn-v{font-weight:700;color:#17352b}.cn-login-card{max-width:480px;margin:50px auto;padding:28px}.cn-login-card input{min-height:50px}.cn-empty{text-align:center;padding:50px 15px;color:#65736d}@media(max-width:700px){.cn-grid{grid-template-columns:1fr 1fr}.cn-profile{align-items:flex-start;flex-direction:column}}
</style>
<section class="cn-account"><div class="cn-account-shell">
<div id="account-login" class="cn-login-card">
<h2>Login to CleanNora</h2><p class="text-muted">Use the same mobile number as the CleanNora app to see all your bookings.</p>
<div id="login-msg"></div><div id="phone-step"><input id="login-phone" class="form-control mb-3" maxlength="10" inputmode="numeric" placeholder="10-digit mobile number"><button id="send-otp" class="btn btn-success w-100">Send OTP</button></div>
<div id="otp-step" style="display:none"><input id="login-otp" class="form-control mb-3" maxlength="6" inputmode="numeric" placeholder="6-digit OTP"><button id="verify-otp" class="btn btn-success w-100">Verify & Login</button></div><div id="account-recaptcha"></div>
</div>
<div id="account-dashboard" style="display:none">
<div class="cn-profile"><div class="d-flex gap-3 align-items-center"><div class="cn-avatar"><i class="bi bi-person"></i></div><div><h3 class="m-0">My CleanNora</h3><div id="profile-phone" class="text-muted"></div></div></div><button id="logout" class="btn btn-outline-secondary btn-sm">Logout</button></div>
<h4 class="mb-3">My Bookings</h4><div id="bookings"><div class="cn-empty">Loading your bookings…</div></div>
</div></div></section>
<script type="module">
import {onAuthStateChanged,RecaptchaVerifier,signInWithPhoneNumber,signOut} from "https://www.gstatic.com/firebasejs/12.1.0/firebase-auth.js";
const auth=window.cleannoraFirebaseAuth, login=document.getElementById('account-login'), dash=document.getElementById('account-dashboard'), list=document.getElementById('bookings'), msg=document.getElementById('login-msg'); let confirmation=null, recaptcha=null;
const esc=s=>String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));
function message(s){msg.innerHTML='<div class="alert alert-info">'+esc(s)+'</div>'}
async function loadBookings(user){const token=await user.getIdToken(true); const fd=new FormData();fd.append('idToken',token);const r=await fetch('/customer/my-bookings-api.php',{method:'POST',body:fd,credentials:'same-origin'});const d=await r.json();if(!d.success)throw new Error(d.message||'Unable to load bookings.'); if(!d.bookings.length){list.innerHTML='<div class="cn-booking-card cn-empty">No bookings yet. Your web and app bookings will appear here.</div>';return;} list.innerHTML=d.bookings.map(b=>'<div class="cn-booking-card"><div class="d-flex justify-content-between gap-2 flex-wrap"><div><strong>'+esc(b.service||'Service')+'</strong><div class="small text-muted">'+esc(b.code||b.id)+'</div></div><div><span class="cn-pill '+(b.bookingType==='instant'?'cn-instant':'')+'">'+(b.bookingType==='instant'?'⚡ Instant Priority':esc(b.statusLabel))+'</span></div></div><div class="cn-grid"><div><div class="cn-k">Status</div><div class="cn-v">'+esc(b.statusLabel)+'</div></div><div><div class="cn-k">Date</div><div class="cn-v">'+esc(b.preferredDate||'-')+'</div></div><div><div class="cn-k">Slot</div><div class="cn-v">'+esc(b.slot||'-')+'</div></div><div><div class="cn-k">Amount</div><div class="cn-v">₹'+esc(b.gross||0)+'</div></div></div><div class="mt-3"><a class="btn btn-sm btn-outline-success" href="/track-booking.php?booking_id='+encodeURIComponent(b.id)+'">Track booking</a> <a class="btn btn-sm btn-outline-secondary" href="/booking-service.php?service='+encodeURIComponent(b.service||'')+'">Rebook</a></div></div>').join('')}
onAuthStateChanged(auth,async user=>{if(user){login.style.display='none';dash.style.display='block';document.getElementById('profile-phone').textContent=user.phoneNumber||'';try{await loadBookings(user)}catch(e){list.innerHTML='<div class="alert alert-danger">'+esc(e.message)+'</div>'}}else{dash.style.display='none';login.style.display='block'}});
document.getElementById('send-otp').onclick=async()=>{try{let p=document.getElementById('login-phone').value.replace(/\D/g,'');if(p.length!==10)throw new Error('Enter a valid 10-digit mobile number.');if(!recaptcha)recaptcha=new RecaptchaVerifier(auth,'account-recaptcha',{size:'invisible'});confirmation=await signInWithPhoneNumber(auth,'+91'+p,recaptcha);document.getElementById('phone-step').style.display='none';document.getElementById('otp-step').style.display='block';message('OTP sent.')}catch(e){message(e.message)}};
document.getElementById('verify-otp').onclick=async()=>{try{if(!confirmation)throw new Error('Send OTP first.');await confirmation.confirm(document.getElementById('login-otp').value.trim())}catch(e){message(e.message)}};
document.getElementById('logout').onclick=()=>signOut(auth);
</script>
<?php include __DIR__.'/../includes/footer.php'; ?>