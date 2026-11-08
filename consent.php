<?php require 'includes/functions.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
 if(!csrf_ok())flash('Invalid session token. Reload and try again.','danger');
 else{
  $code=strtoupper(trim($_POST['code']??''));$ident=strtolower(trim($_POST['ident']??''));$mob=preg_replace('/[\s\-()]/','',$ident);$do=$_POST['do']??'';
  $s=$pdo->prepare('SELECT id FROM visitors WHERE code=? AND ((email IS NOT NULL AND email=?) OR (mobile IS NOT NULL AND mobile=?))');$s->execute([$code,$ident,$mob]);$id=$s->fetchColumn();
  if(!$id||!in_array($do,['withdraw','grant','delete'],true))flash('We could not match those details. Check your visitor ID and the email or mobile you registered with.','danger');
  else{
   if($do==='grant')set_consent($id,1);
   else{set_consent($id,0);if($do==='delete'){$q=$pdo->prepare('SELECT id FROM photos WHERE visitor_id=?');$q->execute([$id]);foreach($q->fetchAll(PDO::FETCH_COLUMN) as $pid)delete_photo($pid);}}
   flash($do==='grant'?'Display consent granted.':($do==='delete'?'Consent withdrawn and all your photos were deleted.':'Consent withdrawn. Your photos no longer appear on the slideshow.'));
  }
 }
 header('Location: consent.php');exit;
}
head('My consent');?>
<div class="glass p-4 rounded-4 mx-auto" style="max-width:520px"><h2>Manage my photo consent</h2>
<p class="text-secondary">Enter your visitor ID (shown when you upload) and the email or mobile you registered with.</p>
<form method="post"><?=csrf_field()?>
<input class="form-control mb-3" name="code" placeholder="Visitor ID (e.g. V1A2B3C4D)" required>
<input class="form-control mb-3" name="ident" placeholder="Registered email or mobile" required>
<div class="d-grid gap-2"><button name="do" value="withdraw" class="btn btn-warning rounded-pill">Withdraw display consent</button>
<button name="do" value="grant" class="btn btn-success rounded-pill">Grant display consent</button>
<button name="do" value="delete" class="btn btn-danger rounded-pill" onclick="return confirm('Withdraw consent and delete ALL your photos permanently?')">Withdraw and delete my photos</button></div></form></div>
<?php foot();
