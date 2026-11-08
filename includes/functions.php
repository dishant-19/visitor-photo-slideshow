<?php
require __DIR__.'/../config/config.php';
require __DIR__.'/csrf.php';
require __DIR__.'/auth.php';
const CATEGORIES=['General','Portrait','Group','Family','Event','Other'];
function e($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
function json_out($d,$c=200){http_response_code($c);header('Content-Type: application/json');echo json_encode($d);exit;}
function setting($k,$d=''){global $pdo;$s=$pdo->prepare('SELECT v FROM settings WHERE k=?');$s->execute([$k]);$v=$s->fetchColumn();return $v===false?$d:$v;}
function flash($m=null,$t='success'){if($m){$_SESSION['f']=[$m,$t];return;}$f=$_SESSION['f']??null;unset($_SESSION['f']);return $f?'<div class="alert alert-'.$f[1].' shadow-sm alert-auto">'.e($f[0]).'</div>':'';}
function register_visitor(array $in):array{global $pdo;
 $name=trim($in['name']??'');$email=strtolower(trim($in['email']??''));$mob=preg_replace('/[\s\-()]/','',$in['mobile']??'');$priv=!empty($in['privacy']);$disp=!empty($in['display']);$err=[];
 if(mb_strlen($name)<2||mb_strlen($name)>100)$err[]='Enter your full name (2-100 characters).';
 if($email!==''&&!filter_var($email,FILTER_VALIDATE_EMAIL))$err[]='Invalid email address.';
 if($mob!==''&&!preg_match('/^\+?\d{7,15}$/',$mob))$err[]='Invalid mobile number.';
 if(!$priv)$err[]='You must accept the privacy policy.';
 if($err)return['ok'=>false,'errors'=>$err];
 $v=null;
 if($email!==''||$mob!==''){$s=$pdo->prepare('SELECT * FROM visitors WHERE (email IS NOT NULL AND email=?) OR (mobile IS NOT NULL AND mobile=?) LIMIT 1');$s->execute([$email?:null,$mob?:null]);$v=$s->fetch();}
 if($v){$pdo->prepare('UPDATE visitors SET visits=visits+1,display_consent=?,privacy_consent=1,name=? WHERE id=?')->execute([(int)$disp,$name,$v['id']]);$id=$v['id'];flash('Welcome back, '.$name.'! Visit #'.($v['visits']+1).'.');}
 else{$pdo->prepare('INSERT INTO visitors(code,name,email,mobile,privacy_consent,display_consent) VALUES(?,?,?,?,1,?)')->execute(['V'.strtoupper(bin2hex(random_bytes(4))),$name,$email?:null,$mob?:null,(int)$disp]);$id=$pdo->lastInsertId();flash('Registration successful!');}
 session_regenerate_id(true);$_SESSION['visitor']=(int)$id;return['ok'=>true,'errors'=>[]];}
function delete_photo($id):bool{global $pdo;$s=$pdo->prepare('SELECT filename FROM photos WHERE id=?');$s->execute([$id]);$fn=$s->fetchColumn();if(!$fn)return false;
 $p=realpath(__DIR__.'/../uploads/photos').DIRECTORY_SEPARATOR.basename($fn);if(is_file($p))unlink($p);$pdo->prepare('DELETE FROM photos WHERE id=?')->execute([$id]);return true;}
function set_consent($visitorId,$value){global $pdo;$pdo->prepare('UPDATE visitors SET display_consent=? WHERE id=?')->execute([(int)(bool)$value,$visitorId]);}
function save_settings($d,$o,$a){global $pdo;$q=$pdo->prepare('REPLACE INTO settings VALUES(?,?)');$q->execute(['duration',max(2,min(120,(int)$d))]);$q->execute(['order',$o==='random'?'random':'chronological']);$q->execute(['auto_approve',$a?'1':'0']);}
function head($t,$b=''){$title=$t;$base=$b;include __DIR__.'/header.php';include __DIR__.'/navbar.php';echo '<main class="container py-4 py-md-5 fade-in">'.flash();}
function foot($b=''){$base=$b;include __DIR__.'/footer.php';}
