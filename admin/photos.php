<?php require '../includes/functions.php';require '../includes/admin_ui.php';admin_only();require '../includes/admin_actions.php';
$st=in_array($_GET['s']??'',['pending','approved','rejected'],true)?$_GET['s']:'';
$s=$pdo->prepare('SELECT p.*,v.name,v.display_consent FROM photos p JOIN visitors v ON v.id=p.visitor_id '.($st?'WHERE p.status=? ':'').'ORDER BY p.id DESC LIMIT 120');$s->execute($st?[$st]:[]);$ph=$s->fetchAll();
admin_head('Photos');?>
<a class="btn btn-sm btn-outline-success rounded-pill mb-3" href="export.php?type=photos"><i class="fa-solid fa-file-csv"></i> Export CSV</a>
<div class="mb-3"><?php foreach([''=>'All','pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected'] as $k=>$l)echo '<a class="btn btn-sm rounded-pill me-1 '.($st===$k?'btn-dark':'btn-outline-dark').'" href="photos.php'.($k?'?s='.$k:'').'">'.$l.'</a>';?></div>
<div class="row g-3"><?php foreach($ph as $p)photo_card($p);if(!$ph)echo '<div class="text-center text-secondary p-5"><i class="fa-regular fa-images fa-3x mb-2"></i><p>No photos here yet.</p></div>';?></div>
<?php foot('../');
