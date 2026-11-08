<?php require __DIR__.'/../includes/functions.php';
api_admin_guard();
$id=(int)($_POST['visitor_id']??0);$v=($_POST['value']??'')==='1'?1:0;
$s=$pdo->prepare('SELECT COUNT(*) FROM visitors WHERE id=?');$s->execute([$id]);
if(!$s->fetchColumn())json_out(['ok'=>false,'message'=>'Visitor not found.'],404);
set_consent($id,$v);json_out(['ok'=>true,'display_consent'=>$v]);
