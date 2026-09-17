<?php
include 'includes/db.php';
$pageTitle = 'Become a CleanNora Service Partner | Join Us';
$pageDescription = 'Apply to become a CleanNora service partner for maid, cook, beautician, electrician, plumber, cleaning and other home services.';
$success=false; $error='';
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['partner_apply'])) {
    $name=trim($_POST['name']??''); $phone=preg_replace('/\D+/','',$_POST['phone']??''); $email=trim($_POST['email']??'');
    $city=trim($_POST['city']??''); $area=trim($_POST['area']??''); $service=trim($_POST['service']??''); $experience=trim($_POST['experience']??'');
    if($name==='' || strlen($phone)<10 || $city==='' || $service===''){ $error='Please complete all required fields.'; }
    else {
        mysqli_query($conn,"CREATE TABLE IF NOT EXISTS partner_applications (id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(120) NOT NULL,phone VARCHAR(20) NOT NULL,email VARCHAR(160) NULL,city VARCHAR(100) NOT NULL,area VARCHAR(160) NULL,service VARCHAR(100) NOT NULL,experience VARCHAR(80) NULL,status VARCHAR(30) DEFAULT 'new',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
        $stmt=mysqli_prepare($conn,"INSERT INTO partner_applications(name,phone,email,city,area,service,experience) VALUES(?,?,?,?,?,?,?)");
        if($stmt){ mysqli_stmt_bind_param($stmt,'sssssss',$name,$phone,$email,$city,$area,$service,$experience); $success=mysqli_stmt_execute($stmt); mysqli_stmt_close($stmt); }
        if(!$success && !$error) $error='Application could not be submitted. Please call +91 92050 80012.';
    }
}
include 'includes/header.php';
?>
<style>.partner-hero{background:linear-gradient(135deg,#063a29,#0a5039);color:#fff;padding:62px 0}.partner-wrap{max-width:980px;margin:auto;padding:0 20px}.partner-hero h1{font-size:clamp(36px,5vw,60px);font-weight:850}.partner-hero span{color:#f4bf19}.partner-form{max-width:760px;margin:45px auto;background:#fff;border:1px solid #e2ebe7;border-radius:22px;padding:28px;box-shadow:0 12px 40px rgba(6,58,41,.08)}.partner-form label{font-weight:700;margin:10px 0 6px}.partner-form input,.partner-form select{width:100%;padding:13px;border:1px solid #ccd9d3;border-radius:10px}.partner-form button{width:100%;margin-top:20px;border:0;border-radius:12px;background:#f4bf19;color:#17372d;font-weight:800;padding:14px}.partner-msg{padding:15px;border-radius:12px;margin-bottom:18px}.ok{background:#e8f7ef;color:#135c36}.err{background:#fff0f0;color:#8c2020}</style>
<main><section class="partner-hero"><div class="partner-wrap"><h1>Become a <span>CleanNora Partner</span></h1><p>Join CleanNora as an independent service professional. Submit your details and our team will review your application.</p></div></section><div class="partner-wrap"><form method="post" class="partner-form">
<?php if($success): ?><div class="partner-msg ok"><strong>Application submitted successfully.</strong><br>Our team will contact you shortly.</div><?php elseif($error): ?><div class="partner-msg err"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<label>Full Name *</label><input name="name" required maxlength="120" value="<?= htmlspecialchars($_POST['name']??'') ?>">
<label>Mobile Number *</label><input name="phone" inputmode="numeric" required maxlength="15" placeholder="10-digit mobile number" value="<?= htmlspecialchars($_POST['phone']??'') ?>">
<label>Email</label><input type="email" name="email" maxlength="160" value="<?= htmlspecialchars($_POST['email']??'') ?>">
<label>City *</label><select name="city" required><option value="">Select city/area</option><option>Noida</option><option>Greater Noida</option><option>Gaur City / Greater Noida West</option><option>Indirapuram</option><option>Other</option></select>
<label>Sector / Locality</label><input name="area" maxlength="160" placeholder="e.g. Sector 76, Gaur City 2, Indirapuram">
<label>Service you want to join *</label><select name="service" required><option value="">Select service</option><option>Instant Maid</option><option>Instant Cook</option><option>Beautician</option><option>Electrician</option><option>Plumber</option><option>House Cleaning</option><option>Toilet Cleaning</option><option>Car Cleaning</option><option>Other Home Service</option></select>
<label>Experience</label><select name="experience"><option>Fresher</option><option>Less than 1 year</option><option>1–3 years</option><option>3–5 years</option><option>5+ years</option></select>
<button type="submit" name="partner_apply">Submit Application</button><p style="text-align:center;margin-top:15px">Need help? Call <a href="tel:+919205080012">+91 92050 80012</a></p></form></div></main>
<?php include 'includes/footer.php'; ?>
