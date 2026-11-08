<?php require '../includes/functions.php';require '../includes/admin_ui.php';admin_only();require '../includes/admin_actions.php';
$q=trim($_GET['q']??'');$s=$pdo->prepare('SELECT * FROM visitors WHERE name LIKE ? OR email LIKE ? OR mobile LIKE ? OR code LIKE ? ORDER BY id DESC LIMIT 200');$l="%$q%";$s->execute([$l,$l,$l,$l]);$vis=$s->fetchAll();
admin_head('Visitors');?>
<a class="btn btn-sm btn-outline-success rounded-pill mb-3" href="export.php?type=visitors"><i class="fa-solid fa-file-csv"></i> Export CSV</a>
<form class="mb-3"><input class="form-control" name="q" placeholder="Search name, email, mobile or ID" value="<?=e($q)?>"></form>
<div class="table-responsive glass rounded-4 p-2"><table class="table align-middle"><tr><th>ID</th><th>Name</th><th>Contact</th><th>Visits</th><th>Display consent</th><th>Joined</th><th></th></tr>
<?php foreach($vis as $v){?><tr><td><?=e($v['code'])?></td><td><?=e($v['name'])?></td><td><?=e($v['email']?:$v['mobile'])?></td><td><?=$v['visits']?></td><td><?=$v['display_consent']?'Yes':'No'?></td><td><?=e($v['created_at'])?></td><td class="d-flex gap-1"><a class="btn btn-sm btn-outline-primary" href="visitor-details.php?id=<?=$v['id']?>">Details</a><?php if($v['display_consent']){?><form method="post"><?=csrf_field()?><input type="hidden" name="id" value="<?=$v['id']?>"><button name="do" value="withdraw" class="btn btn-sm btn-outline-secondary">Withdraw</button></form><?php }?></td></tr><?php }if(!$vis)echo '<tr><td colspan="7" class="text-center text-secondary p-4">No visitors found.</td></tr>';?></table></div>
<?php foot('../');
