<?php require '../includes/functions.php';require '../includes/admin_ui.php';admin_only();require '../includes/admin_actions.php';
$c=fn($q)=>(int)$pdo->query($q)->fetchColumn();
$stats=['Visitors'=>$c('SELECT COUNT(*) FROM visitors'),'Photos'=>$c('SELECT COUNT(*) FROM photos'),'Approved'=>$c("SELECT COUNT(*) FROM photos WHERE status='approved'"),'Pending'=>$c("SELECT COUNT(*) FROM photos WHERE status='pending'"),'Returning'=>$c('SELECT COUNT(*) FROM visitors WHERE visits>1')];
$rows=$pdo->query('SELECT DATE(created_at) d,COUNT(*) n FROM photos WHERE created_at>=CURDATE()-INTERVAL 6 DAY GROUP BY d')->fetchAll(PDO::FETCH_KEY_PAIR);
$days=[];for($i=6;$i>=0;$i--){$d=date('Y-m-d',strtotime("-$i day"));$days[$d]=(int)($rows[$d]??0);}
$max=max(1,...array_values($days));
$recent=$pdo->query('SELECT v.name,v.code,v.visits,v.created_at,(SELECT COUNT(*) FROM photos p WHERE p.visitor_id=v.id) n FROM visitors v ORDER BY v.id DESC LIMIT 6')->fetchAll();
admin_head('Dashboard');?>
<div class="row g-3 mb-4"><?php foreach($stats as $k=>$v)echo '<div class="col-6 col-md reveal"><div class="glass p-3 rounded-4 text-center"><div class="fs-2 fw-bold count" data-n="'.$v.'">0</div><small>'.$k.'</small></div></div>';?></div>
<div class="row g-3"><div class="col-md-6"><div class="glass p-3 rounded-4 h-100"><h5>Uploads, last 7 days</h5><div class="d-flex align-items-end gap-2" style="height:140px"><?php foreach($days as $d=>$n){?><div class="flex-fill text-center small"><div class="bar" style="height:0" data-h="<?=round($n/$max*100)?>" title="<?=$n?>"></div><?=$n?><br><?=date('D',strtotime($d))?></div><?php }?></div></div></div>
<div class="col-md-6"><div class="glass p-3 rounded-4 h-100"><h5>Recent visitors</h5><table class="table table-sm mb-0"><?php foreach($recent as $r)echo '<tr><td>'.e($r['name']).'</td><td>'.e($r['code']).'</td><td>'.$r['n'].' photos</td></tr>';if(!$recent)echo '<tr><td class="text-secondary">No visitors yet.</td></tr>';?></table></div></div></div>
<?php foot('../');
