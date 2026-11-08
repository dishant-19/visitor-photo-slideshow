<?php $adm=strpos($_SERVER['SCRIPT_NAME'],'/admin/')!==false;?>
</main><footer class="glass mt-5 py-4 text-center"><div class="gold fw-bold mb-2">Visitor Photo Slideshow</div>
<div class="small mb-2"><a href="<?=$base?>gallery.php">Gallery</a> · <a href="<?=$base?>slideshow.php">Slideshow</a> · <a href="<?=$base?>about.php">About</a> · <a href="<?=$base?>privacy.php">Privacy</a> · <a href="<?=$base?>consent.php">My consent</a></div>
<div class="small text-secondary">© <?=date('Y')?> Visitor Photo Slideshow · PHP &amp; MySQL college project</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?=$base?>assets/js/theme.js"></script><script src="<?=$base?>assets/js/main.js"></script><script src="<?=$base?>assets/js/animations.js"></script><?php if($adm)echo '<script src="'.$base.'assets/js/admin.js"></script>';?></body></html>
