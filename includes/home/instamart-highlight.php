<?php
require_once __DIR__ . '/../db.php';
$cnFeaturedProducts=[];
$q=mysqli_query($conn,"SELECT id,name,mrp,sale_price,main_image FROM mart_products WHERE status='active' ORDER BY is_featured DESC,is_best_seller DESC,id DESC LIMIT 8");
if($q){while($r=mysqli_fetch_assoc($q)){$cnFeaturedProducts[]=$r;}}
?>
<?php if($cnFeaturedProducts): ?>
<section class="cn-imart" aria-labelledby="cnImartTitle"><div class="cn-imart-wrap">
<div class="cn-imart-head"><div><span>INSTAMART BY CLEANNORA</span><h2 id="cnImartTitle">Everyday Home-Care Products</h2><p>Discover CleanNora products one by one. Featured products rotate automatically.</p></div><a href="/cleanmart.php">Shop All Products →</a></div>
<div class="cn-imart-stage">
<?php foreach($cnFeaturedProducts as $i=>$p): $sale=(float)$p['sale_price'];$mrp=(float)$p['mrp']; ?>
<article class="cn-imart-product<?= $i===0?' active':'' ?>" data-imart-slide="<?= $i ?>">
<div class="cn-imart-img"><img src="<?= htmlspecialchars($p['main_image']) ?>" alt="<?= htmlspecialchars($p['name']) ?> by CleanNora" loading="<?= $i===0?'eager':'lazy' ?>"></div>
<div class="cn-imart-copy"><span class="cn-imart-pill">Featured Product</span><h3><?= htmlspecialchars($p['name']) ?></h3><div class="cn-imart-price"><strong>₹<?= number_format($sale,0) ?></strong><?php if($mrp>$sale): ?><del>₹<?= number_format($mrp,0) ?></del><?php endif; ?></div><a class="cn-imart-btn" href="/cleanmart.php#products">View in InstaMart</a></div>
</article><?php endforeach; ?>
</div>
<div class="cn-imart-dots"><?php foreach($cnFeaturedProducts as $i=>$p): ?><button type="button" class="<?= $i===0?'active':'' ?>" data-imart-dot="<?= $i ?>" aria-label="Show product <?= $i+1 ?>"></button><?php endforeach; ?></div>
</div></section>
<style>
.cn-imart{padding:64px 20px;background:#f6f8f6}.cn-imart-wrap{max-width:1180px;margin:auto}.cn-imart-head{display:flex;justify-content:space-between;gap:20px;align-items:end;margin-bottom:26px}.cn-imart-head span{font-size:12px;letter-spacing:1.8px;font-weight:900;color:#b8860b}.cn-imart-head h2{font-size:clamp(28px,4vw,42px);color:#083d2b;font-weight:850;margin:7px 0}.cn-imart-head p{margin:0;color:#66736e}.cn-imart-head>a{color:#083d2b;font-weight:800;text-decoration:none}.cn-imart-stage{position:relative;min-height:370px;background:#fff;border:1px solid #e0e8e4;border-radius:26px;overflow:hidden}.cn-imart-product{display:none;grid-template-columns:1fr 1fr;align-items:center;min-height:370px;padding:28px 50px}.cn-imart-product.active{display:grid}.cn-imart-img{height:310px;display:flex;align-items:center;justify-content:center}.cn-imart-img img{max-width:100%;max-height:100%;object-fit:contain}.cn-imart-copy h3{font-size:clamp(25px,4vw,38px);color:#083d2b;font-weight:850}.cn-imart-pill{display:inline-block;background:#083d2b;color:#fff;border-radius:999px;padding:7px 11px;font-size:11px;font-weight:800}.cn-imart-price{display:flex;gap:10px;align-items:center;margin:15px 0 22px}.cn-imart-price strong{font-size:27px}.cn-imart-price del{color:#8c9691}.cn-imart-btn{display:inline-block;background:#083d2b;color:#fff;text-decoration:none;padding:12px 18px;border-radius:12px;font-weight:800}.cn-imart-dots{text-align:center;margin-top:15px}.cn-imart-dots button{width:9px;height:9px;border:0;border-radius:50%;margin:0 4px;background:#b9c5c0}.cn-imart-dots button.active{background:#083d2b;transform:scale(1.3)}@media(max-width:700px){.cn-imart-head{display:block}.cn-imart-head>a{display:inline-block;margin-top:14px}.cn-imart-stage{min-height:520px}.cn-imart-product{grid-template-columns:1fr;padding:24px;min-height:520px}.cn-imart-img{height:260px}.cn-imart-copy{text-align:center}}
</style>
<script>document.addEventListener('DOMContentLoaded',()=>{const s=[...document.querySelectorAll('[data-imart-slide]')],d=[...document.querySelectorAll('[data-imart-dot]')];if(!s.length)return;let i=0;const show=n=>{i=n%s.length;s.forEach((x,k)=>x.classList.toggle('active',k===i));d.forEach((x,k)=>x.classList.toggle('active',k===i));};d.forEach((x,k)=>x.addEventListener('click',()=>show(k)));if(s.length>1)setInterval(()=>show(i+1),4500);});</script>
<?php endif; ?>