<?php require 'includes/functions.php';
$q=trim($_GET['q']??'');$cat=in_array($_GET['cat']??'',CATEGORIES,true)?$_GET['cat']:'';
$w=["p.status='approved'",'v.display_consent=1','v.privacy_consent=1'];$a=[];
if($cat){$w[]='p.category=?';$a[]=$cat;}
if($q!==''){$w[]='v.name LIKE ?';$a[]='%'.$q.'%';}
$s=$pdo->prepare('SELECT p.filename,p.category,p.created_at,v.name FROM photos p JOIN visitors v ON v.id=p.visitor_id WHERE '.implode(' AND ',$w).' ORDER BY p.created_at DESC LIMIT 120');$s->execute($a);$ph=$s->fetchAll();
head('Gallery');?>
<h1 class="gold mb-3">Visitor Gallery</h1>
<form class="row g-2 mb-3"><div class="col"><input class="form-control rounded-pill" name="q" placeholder="Search by visitor name" value="<?=e($q)?>"></div><?php if($cat)echo '<input type="hidden" name="cat" value="'.e($cat).'">';?><div class="col-auto"><button class="btn btn-primary rounded-pill"><i class="fa-solid fa-magnifying-glass"></i></button></div></form>
<div class="chips mb-4"><?php foreach(array_merge([''],CATEGORIES) as $k)echo '<a class="btn btn-sm rounded-pill '.($cat===$k?'btn-primary':'btn-outline-secondary').'" href="gallery.php?'.http_build_query(array_filter(['cat'=>$k,'q'=>$q])).'">'.($k?:'All').'</a> ';?></div>
<div class="gal"><?php foreach($ph as $p){$cap=$p['name'].' · '.date('M j, Y',strtotime($p['created_at']));?>
<figure class="glass gcard reveal"><img loading="lazy" src="uploads/photos/<?=e($p['filename'])?>" alt="Photo by <?=e($p['name'])?>" data-full="uploads/photos/<?=e($p['filename'])?>" data-cap="<?=e($cap)?>"><figcaption><b><?=e($p['name'])?></b><span class="badge-gold"><?=e($p['category'])?></span><small><?=e(date('M j, Y',strtotime($p['created_at'])))?></small></figcaption></figure><?php }?></div>
<?php if(!$ph)echo '<div class="text-center text-secondary p-5"><i class="fa-regular fa-images fa-3x gold mb-3"></i><p>No photos match yet. <a href="register.php">Be the first to share one.</a></p></div>';?>
<div class="modal fade" id="pv" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-xl"><div class="modal-content glass"><div class="modal-body text-center p-2"><img id="pvimg" class="img-fluid rounded-3" alt=""><p id="pvcap" class="gold mt-2 mb-0"></p></div><button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button></div></div></div>
<?php foot();
