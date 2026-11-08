<?php require __DIR__.'/../includes/functions.php';
api_admin_guard();
$ok=delete_photo((int)($_POST['id']??0));
json_out($ok?['ok'=>true]:['ok'=>false,'message'=>'Photo not found.'],$ok?200:404);
