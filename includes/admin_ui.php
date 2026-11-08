<?php
function admin_head($t){head($t,'../');$cur=basename($_SERVER['PHP_SELF']);
 echo '<div class="d-flex flex-wrap gap-1 mb-4">';
 foreach(['dashboard'=>'Dashboard','visitors'=>'Visitors','photos'=>'Photos','settings'=>'Settings','profile'=>'Profile'] as $f=>$l)echo '<a class="btn btn-sm rounded-pill '.($cur===$f.'.php'?'btn-primary':'btn-outline-secondary').'" href="'.$f.'.php">'.$l.'</a>';
 echo '<a class="btn btn-sm btn-outline-danger rounded-pill ms-auto" href="logout.php">Logout</a></div>';}
function photo_card($p,$vid=0){?>
<div class="col-6 col-md-3"><div class="glass rounded-4 p-2 h-100"><img class="img-fluid rounded-3 mb-2 zoom" src="../uploads/photos/<?=e($p['filename'])?>" alt=""><div class="small"><b><?=e($p['name'])?></b> · <?=e($p['status'])?><?=$p['display_consent']?'':' · no consent'?></div>
<form method="post" class="d-flex gap-1 mt-1"><?=csrf_field()?><input type="hidden" name="id" value="<?=$p['id']?>"><input type="hidden" name="vid" value="<?=$vid?>"><button name="do" value="approved" class="btn btn-sm btn-success">Approve</button><button name="do" value="rejected" class="btn btn-sm btn-warning">Reject</button><button name="do" value="delete" class="btn btn-sm btn-danger" data-confirm="Delete permanently?">Delete</button></form></div></div>
<?php }
