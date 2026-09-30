<section class="cn-help-services" aria-labelledby="cn-help-title">
<style>
.cn-help-services{padding:72px 0 78px;background:#fff;color:#153b2e}
.cn-help-wrap{width:min(1180px,calc(100% - 32px));margin:auto}
.cn-help-head{display:flex;align-items:end;justify-content:space-between;gap:24px;margin-bottom:30px}
.cn-help-kicker{display:block;margin-bottom:8px;color:#b88900;font-size:12px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase}
.cn-help-head h2{margin:0;color:#083d2b;font-size:clamp(30px,4vw,46px);font-weight:800;letter-spacing:-1.2px}
.cn-help-head p{max-width:520px;margin:0;color:#6b7772;font-size:14px;line-height:1.65}
.cn-help-grid{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:14px}
.cn-help-card{position:relative;min-height:168px;padding:18px 14px 15px;border:1px solid #e4eae6;border-radius:18px;background:#fff;color:#153b2e;text-decoration:none;box-shadow:0 6px 22px rgba(8,61,43,.055);transition:.2s ease}
.cn-help-card:hover{transform:translateY(-4px);border-color:#d9b53c;box-shadow:0 15px 34px rgba(8,61,43,.11)}
.cn-help-icon{width:58px;height:58px;display:grid;place-items:center;margin-bottom:18px;border-radius:16px;background:#f2f7f4;color:#083d2b;font-size:26px}
.cn-help-card h3{margin:0 0 7px;font-size:15px;line-height:1.3;font-weight:800}
.cn-help-price{font-size:12px;color:#69756f}.cn-help-price strong{color:#083d2b}
.cn-help-arrow{position:absolute;right:14px;bottom:14px;width:28px;height:28px;display:grid;place-items:center;border-radius:50%;background:#083d2b;color:#f4bf19;font-size:14px}
.cn-help-card.salon{border-color:rgba(212,175,55,.55);background:linear-gradient(145deg,#fff 0%,#fffbef 100%)}
.cn-help-live{position:absolute;right:12px;top:12px;padding:5px 8px;border-radius:999px;background:#083d2b;color:#fff;font-size:9px;font-weight:800;letter-spacing:.5px;text-transform:uppercase}
.cn-help-all{text-align:center;margin-top:28px}.cn-help-all a{display:inline-flex;align-items:center;gap:8px;padding:12px 20px;border:1px solid #083d2b;border-radius:999px;color:#083d2b;text-decoration:none;font-size:13px;font-weight:800}
@media(max-width:1100px){.cn-help-grid{grid-template-columns:repeat(4,1fr)}}
@media(max-width:760px){.cn-help-services{padding:48px 0}.cn-help-head{display:block}.cn-help-head p{margin-top:10px}.cn-help-grid{grid-template-columns:repeat(2,1fr);gap:10px}.cn-help-card{min-height:155px;padding:14px}.cn-help-icon{width:50px;height:50px;font-size:23px;margin-bottom:14px}}
</style>
<div class="cn-help-wrap">
  <div class="cn-help-head">
    <div><span class="cn-help-kicker">CleanNora Home Services</span><h2 id="cn-help-title">What do you need help with?</h2></div>
    <p>Book trained professionals for everyday home services in Noida. Clear pricing, convenient slots and support from booking to completion.</p>
  </div>
  <div class="cn-help-grid">
<?php
$homeServices = [
 ['Instant Maid','99','bi-person-check','Instant Maid'],
 ['Cook','299','bi-cup-hot','Cook'],
 ['House Cleaning','2999','bi-house-door','Home Cleaning'],
 ['Bathroom Cleaning','449','bi-droplet','Bathroom Cleaning'],
 ['Kitchen Cleaning','699','bi-grid','Kitchen Cleaning'],
 ['Sofa Cleaning','399','bi-house-heart','Sofa Cleaning'],
 ['AC Service & Repair','399','bi-snow','AC Service & Repair'],
 ['Electrician','299','bi-lightning-charge','Electrician'],
 ['Plumber','299','bi-wrench-adjustable','Plumber'],
 ['Chimney & Hob','499','bi-fire','Chimney & Hob'],
 ['Car Cleaning','299','bi-car-front','Car Cleaning'],
 ['Product AMC','999','bi-tools','Product AMC'],
 ['Home Salon','299','bi-scissors','Salon Services']
];
foreach ($homeServices as $s):
 $isSalon = $s[0] === 'Home Salon';
?>
    <a class="cn-help-card<?= $isSalon ? ' salon' : '' ?>" href="booking-service.php?service=<?= urlencode($s[3]) ?>">
      <?php if($isSalon): ?><span class="cn-help-live">Now Live</span><?php endif; ?>
      <div class="cn-help-icon"><i class="bi <?= htmlspecialchars($s[2]) ?>"></i></div>
      <h3><?= htmlspecialchars($s[0]) ?></h3>
      <div class="cn-help-price">Starts at <strong>₹<?= htmlspecialchars($s[1]) ?></strong></div>
      <span class="cn-help-arrow">→</span>
    </a>
<?php endforeach; ?>
  </div>
  <div class="cn-help-all"><a href="services.php">Explore all services <span>→</span></a></div>
</div>
</section>