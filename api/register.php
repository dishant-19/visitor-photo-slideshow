<?php require __DIR__.'/../includes/functions.php';
if($_SERVER['REQUEST_METHOD']!=='POST')json_out(['ok'=>false,'errors'=>['POST required.']],405);
if(!csrf_ok())json_out(['ok'=>false,'errors'=>['Invalid session token. Reload the page.']],403);
$r=register_visitor($_POST);
json_out($r+['redirect'=>'upload.php'],$r['ok']?200:422);
