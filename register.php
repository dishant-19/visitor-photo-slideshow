<?php require 'includes/functions.php';
$err=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
 if(!csrf_ok())$err[]='Invalid session token. Reload and try again.';
 else{$r=register_visitor($_POST);if($r['ok']){header('Location: upload.php');exit;}$err=$r['errors'];}
}
head('Register');?>
<div class="glass p-4 p-md-5 rounded-4 mx-auto" style="max-width:560px"><h2 class="mb-3">Visitor registration</h2>
<div id="reg-errors"><?php foreach($err as $x)echo '<div class="alert alert-danger">'.e($x).'</div>';?></div>
<form method="post" id="register-form" novalidate><?=csrf_field()?>
<input class="form-control mb-3" name="name" placeholder="Full name" value="<?=e($_POST['name']??'')?>" required>
<input class="form-control mb-3" type="email" name="email" placeholder="Email (optional)" value="<?=e($_POST['email']??'')?>">
<input class="form-control mb-3" name="mobile" placeholder="Mobile (optional)" value="<?=e($_POST['mobile']??'')?>">
<p class="small text-secondary">Your unique visitor ID is generated after registration. Returning visitors are recognised by email or mobile.</p>
<div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="privacy" id="p" required><label class="form-check-label" for="p">I accept the privacy policy (<a href="privacy.php" target="_blank">read policy</a>).</label></div>
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="display" id="d"><label class="form-check-label" for="d">I agree my photos may be shown on the public slideshow (can be withdrawn on request).</label></div>
<button class="btn btn-primary rounded-pill w-100">Continue</button></form></div>
<?php foot();
