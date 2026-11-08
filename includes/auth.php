<?php
function admin_only(){if(empty($_SESSION['admin'])){header('Location: login.php');exit;}}
// Brute-force protection: 5 failed logins per IP in 15 minutes blocks further attempts.
function login_blocked(){global $pdo;try{$s=$pdo->prepare('SELECT COUNT(*) FROM login_attempts WHERE ip=? AND attempted_at>NOW()-INTERVAL 15 MINUTE');$s->execute([$_SERVER['REMOTE_ADDR']??'']);return (int)$s->fetchColumn()>=5;}catch(Throwable $e){return false;}}
function admin_login($u,$p){global $pdo;$ip=$_SERVER['REMOTE_ADDR']??'';$s=$pdo->prepare('SELECT * FROM admins WHERE username=?');$s->execute([$u]);$a=$s->fetch();
 if($a&&password_verify($p,$a['password_hash'])){session_regenerate_id(true);$_SESSION['admin']=$a['username'];try{$pdo->prepare('DELETE FROM login_attempts WHERE ip=?')->execute([$ip]);}catch(Throwable $e){}return true;}
 try{$pdo->prepare('INSERT INTO login_attempts(ip) VALUES(?)')->execute([$ip]);}catch(Throwable $e){}return false;}
// For JSON endpoints that need an admin: POST + CSRF + admin session.
function api_admin_guard(){header('Content-Type: application/json');
 if($_SERVER['REQUEST_METHOD']!=='POST'){json_out(['ok'=>false,'message'=>'POST required.'],405);}
 if(!csrf_ok()){json_out(['ok'=>false,'message'=>'Invalid token.'],403);}
 if(empty($_SESSION['admin'])){json_out(['ok'=>false,'message'=>'Admin login required.'],401);}}
