<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Manual Bookings | CleanNora Customer Care</title>
<style>
:root{color-scheme:light;font:16px system-ui,sans-serif;color:#192d25;background:#f3f6f2}
*{box-sizing:border-box}
[hidden]{display:none!important}
body{margin:0}
header{background:#143b2d;color:#fff;padding:1rem max(1.25rem,calc((100% - 1160px)/2));display:flex;justify-content:space-between;align-items:center}
.brand{color:#f2cf86;font-weight:800;letter-spacing:.06em}
main{max-width:1200px;margin:auto;padding:2rem 1.25rem}
h1{margin:0;font-size:clamp(1.8rem,4vw,2.7rem)}
h2{font-size:1.2rem;margin:0 0 1rem}
p{line-height:1.5}
.intro{color:#455f53}
.layout{display:grid;grid-template-columns:minmax(0, .9fr) minmax(0, 1.1fr);gap:1.25rem;align-items:start}
.panel{background:#fff;border:1px solid #dce6de;border-radius:14px;padding:1.25rem}
#login{max-width:400px}
form,.fields{display:grid;gap:.8rem}
.fields{grid-template-columns:repeat(2,minmax(0,1fr))}
.full{grid-column:1/-1}
label{display:grid;gap:.25rem;font-size:.9rem;font-weight:650}
input,select,textarea,button,.button{font:inherit}
input,select,textarea{width:100%;min-height:42px;border:1px solid #9cafa3;border-radius:7px;padding:.55rem;color:inherit;background:white}
textarea{resize:vertical}
button,.button{display:inline-block;border:1px solid #276548;background:#276548;color:white;border-radius:7px;padding:.55rem .8rem;cursor:pointer;text-decoration:none}
.secondary{color:#1e5139;background:#fff}
button:disabled{opacity:.55;cursor:wait}
:focus-visible{outline:3px solid #ad7400;outline-offset:2px}
.row,.actions{display:flex;gap:.55rem;align-items:center;flex-wrap:wrap}
.actions{margin-top:.8rem}
#message{min-height:1.5rem;overflow-wrap:anywhere}
.error{color:#a22121}
#list{display:grid;gap:.7rem;margin-top:1rem}
article{border:1px solid #dce6de;padding:.85rem;border-radius:9px;overflow-wrap:anywhere}
article p{margin:.35rem 0}
.meta{font-size:.86rem;color:#455f53}
.status{background:#e7f2e9;border-radius:20px;padding:.2rem .55rem;font-size:.8rem}
dialog{width:min(95vw,440px);border:1px solid #dce6de;border-radius:14px;padding:1.25rem}
dialog::backdrop{background:#143b2d88}
.check{display:flex;align-items:center}
.check input{width:auto;min-height:0}
@media(max-width:800px){.layout{grid-template-columns:1fr}}
</style>
<script type="module" src="./manual-bookings.js"></script>
</head>
<body>
<header><span class="brand">CleanNora</span><button class="secondary" id="logout" type="button" hidden>Sign out</button></header>
<main>
<h1>Customer Care Bookings</h1>
<p class="intro">Manage phone, WhatsApp and website callback bookings. All service times are in IST.</p>
<p id="message" role="status" aria-live="polite">Loading staff sign-in…</p>
<form class="panel" id="login" hidden>
<h2>Staff sign-in</h2>
<label>Work email<input name="email" type="email" autocomplete="username" required></label>
<label>Password<input name="password" type="password" autocomplete="current-password" required></label>
<button>Sign in</button>
</form>
<div class="layout" id="workspace" hidden>
<section class="panel">
<h2>New booking</h2>
<form id="new-booking">
<div class="fields">
<label>Customer name<input name="customer_name" maxlength="100" required></label>
<label>Mobile number<input name="phone" inputmode="numeric" pattern="[6-9][0-9]{9}" maxlength="10" placeholder="10 digits" required></label>
<label class="full">Sector / society<input name="area" maxlength="120" placeholder="e.g. Sector 75, Noida" required></label>
<label class="full">Full service address<textarea name="address" maxlength="500" rows="2" required></textarea></label>
<label>Service<input name="service" list="services" maxlength="100" required></label>
<datalist id="services">
<option value="Instant Maid"><option value="Cook"><option value="Home Cleaning"><option value="Deep Cleaning"><option value="Bathroom Cleaning"><option value="Kitchen Cleaning"><option value="Sofa Cleaning"><option value="Carpet Cleaning"><option value="Window Cleaning"><option value="Office Cleaning"><option value="Car Cleaning"><option value="Move In / Out Cleaning"><option value="Plumber"><option value="Salon Services">
</datalist>
<label>Package / duration<input name="plan" maxlength="120" required></label>
<label>Requested date and time<input name="starts_at" type="datetime-local" required></label>
<label>Source<select name="source"><option>Call</option><option>WhatsApp</option><option>Website callback</option></select></label>
<label>Final quoted total (₹)<input name="total" inputmode="decimal" pattern="[0-9]{1,6}(\.[0-9]{1,2})?" required></label>
<label class="full">Internal notes<textarea name="notes" maxlength="500" rows="2"></textarea></label>
</div>
<button>Save pending booking</button>
</form>
</section>
<section class="panel">
<h2>Booking queue</h2>
<form id="filters">
<div class="fields">
<label>Service date<input name="day" type="date" required></label>
<label>Find by phone across dates<input name="phone" inputmode="numeric" pattern="[6-9][0-9]{9}" maxlength="10"></label>
</div>
<button class="secondary">Find bookings</button>
</form>
<div id="list" aria-live="polite"></div>
</section>
</div>
<dialog id="action">
<form>
<h2 id="action-title"></h2>
<label class="check" id="check-row" hidden><input name="availability_checked" type="checkbox">I checked availability for this slot.</label>
<label id="partner-row" hidden>Partner name / ID<input name="partner" maxlength="120"></label>
<label id="slot-row" hidden>New date and time (IST)<input name="starts_at" type="datetime-local"></label>
<p id="action-error" class="error" role="alert" hidden></p>
<div class="row"><button>Save change</button><button class="secondary" type="button" id="close-action">Back</button></div>
</form>
</dialog>
</main>
</body>
</html>
