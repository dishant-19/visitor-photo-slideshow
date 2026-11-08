<?php require 'includes/functions.php'; head('About');?>
<h1 class="gold mb-4">About the project</h1>
<div class="row g-3"><div class="col-md-6 reveal"><div class="glass p-4 rounded-4 h-100"><h4>Introduction</h4><p class="text-secondary">Visitor Photo Slideshow is a web system where visitors register, upload photos and see them on a full-screen slideshow, with an admin team approving what is shown.</p></div></div>
<div class="col-md-6 reveal"><div class="glass p-4 rounded-4 h-100"><h4>Purpose</h4><p class="text-secondary">Built as a college project to practise secure PHP and MySQL development: consent management, safe image uploads, admin moderation and responsive design.</p></div></div>
<div class="col-12 reveal"><div class="glass p-4 rounded-4"><h4>Technologies</h4><div class="d-flex flex-wrap gap-2"><?php foreach(['PHP 8','MySQL / MariaDB','PDO','HTML5','CSS3','JavaScript','Bootstrap 5','Font Awesome','XAMPP'] as $t)echo '<span class="badge-gold">'.$t.'</span>';?></div></div></div></div>
<?php foot();
