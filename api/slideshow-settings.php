<?php require __DIR__.'/../includes/functions.php';
if($_SERVER['REQUEST_METHOD']==='GET'){header('Cache-Control: no-store');json_out(['duration'=>(int)setting('duration','10'),'order'=>setting('order','chronological'),'auto_approve'=>setting('auto_approve','0')==='1']);}
api_admin_guard();
save_settings($_POST['duration']??10,$_POST['order']??'',($_POST['auto_approve']??'')==='1');
json_out(['ok'=>true]);
