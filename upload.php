<?php require 'includes/functions.php';
if(empty($_SESSION['visitor'])){header('Location: register.php');exit;}
$s=$pdo->prepare('SELECT code FROM visitors WHERE id=?');$s->execute([$_SESSION['visitor']]);$code=$s->fetchColumn();
head('Upload photos');?>
<div class="glass p-4 rounded-4 mx-auto" style="max-width:720px"><h2>Upload photos</h2><p class="text-secondary">Your visitor ID: <b><?=e($code)?></b></p>
<div id="drop" class="drop text-center p-5 rounded-4"><i class="fa-solid fa-cloud-arrow-up fa-3x mb-2"></i><p class="mb-1">Drag &amp; drop photos or click to browse</p><small class="text-secondary">JPG, PNG, WebP · max 5 MB each</small><input id="files" type="file" accept=".jpg,.jpeg,.png,.webp" multiple hidden></div>
<select id="cat" class="form-select mt-3" aria-label="Category"><?php foreach(CATEGORIES as $c)echo "<option>".e($c)."</option>";?></select><div id="previews" class="row g-2 mt-3"></div><div id="msg" class="mt-3"></div>
<div class="progress mt-3 d-none"><div id="bar" class="progress-bar progress-bar-striped progress-bar-animated" style="width:0"></div></div>
<button id="go" class="btn btn-primary rounded-pill w-100 mt-3" disabled>Upload</button></div>
<script>const CSRF="<?=csrf()?>";</script><script src="assets/js/upload.js"></script>
<?php foot();
