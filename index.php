<?php require 'includes/functions.php';
$c=fn($q)=>(int)$pdo->query($q)->fetchColumn();
$st=['Visitors'=>$c('SELECT COUNT(*) FROM visitors'),'Photos shared'=>$c("SELECT COUNT(*) FROM photos p JOIN visitors v ON v.id=p.visitor_id WHERE p.status='approved' AND v.display_consent=1"),'Returning visitors'=>$c('SELECT COUNT(*) FROM visitors WHERE visits>1')];
head('Home');?>
<section id="hero" class="hero glass"><div class="hero-bg on"></div><div class="hero-bg"></div>
<div class="hero-grid"><div class="hero-content text-center text-lg-start"><p class="eyebrow">Welcome</p><h1 class="display-3 gold mb-3">Moments Worth Remembering</h1><p class="lead mb-4">Share your visit, see yourself on the big screen, and browse the gallery.</p>
<a class="btn btn-primary btn-lg rounded-pill me-2 mb-2" href="gallery.php"><i class="fa-regular fa-images"></i> Explore Gallery</a><a class="btn btn-outline-secondary btn-lg rounded-pill mb-2" href="register.php">Join as a visitor</a></div>
<div id="stage" class="stage" aria-hidden="true"><div id="ring" class="ring"></div></div></div></section>
<section class="row g-3 my-4"><?php foreach($st as $k=>$v)echo '<div class="col-12 col-md-4 reveal"><div class="glass p-4 rounded-4 text-center"><div class="display-5 gold count" data-n="'.$v.'">0</div><div class="text-secondary">'.$k.'</div></div></div>';?></section>
<section class="row g-3"><?php foreach([['fa-user-plus','Register','Tell us who you are and choose how your photos may be used.'],['fa-cloud-arrow-up','Upload','Drag and drop photos with live preview and progress.'],['fa-tv','Watch','Approved photos appear on the full-screen slideshow.']] as $f)echo '<div class="col-md-4 reveal"><div class="glass p-4 rounded-4 h-100"><i class="fa-solid '.$f[0].' gold fa-2x mb-3"></i><h5>'.$f[1].'</h5><p class="text-secondary mb-0">'.$f[2].'</p></div></div>';?></section>
<?php foot();
