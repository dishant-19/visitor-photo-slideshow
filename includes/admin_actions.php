<?php // Shared POST handler for admin pages (non-AJAX path). Include after admin_only().
if($_SERVER['REQUEST_METHOD']==='POST'){
 $page=basename($_SERVER['PHP_SELF']);
 if(!csrf_ok()){flash('Invalid security token.','danger');header('Location: '.$page);exit;}
 $id=(int)($_POST['id']??0);$do=$_POST['do']??'';$back=$page.(($do==='delete'&&!empty($_POST['vid']))?'?id='.(int)$_POST['vid']:($do==='edit_visitor'?'?id='.$id:''));
 if(in_array($do,['approved','rejected'],true))$pdo->prepare('UPDATE photos SET status=? WHERE id=?')->execute([$do,$id]);
 elseif($do==='delete')delete_photo($id);
 elseif($do==='withdraw')set_consent($id,0);
 elseif($do==='settings')save_settings($_POST['duration']??10,$_POST['order']??'',isset($_POST['auto']));
 elseif($do==='edit_visitor'){$n=trim($_POST['name']??'');$em=strtolower(trim($_POST['email']??''));$mo=preg_replace('/[\s\-()]/','',$_POST['mobile']??'');
  if(mb_strlen($n)<2||mb_strlen($n)>100||($em!==''&&!filter_var($em,FILTER_VALIDATE_EMAIL))||($mo!==''&&!preg_match('/^\+?\d{7,15}$/',$mo))){flash('Please enter a valid name, email and mobile.','danger');header('Location: '.$back);exit;}
  try{$pdo->prepare('UPDATE visitors SET name=?,email=?,mobile=? WHERE id=?')->execute([$n,$em?:null,$mo?:null,$id]);}catch(PDOException $x){flash('That email or mobile belongs to another visitor.','danger');header('Location: '.$back);exit;}}
 elseif($do==='password'){$s=$pdo->prepare('SELECT * FROM admins WHERE username=?');$s->execute([$_SESSION['admin']]);$a=$s->fetch();$n=$_POST['new']??'';
  if(!$a||!password_verify($_POST['old']??'',$a['password_hash'])){flash('Current password is wrong.','danger');header('Location: profile.php');exit;}
  if(strlen($n)<8){flash('New password must be at least 8 characters.','danger');header('Location: profile.php');exit;}
  $pdo->prepare('UPDATE admins SET password_hash=? WHERE id=?')->execute([password_hash($n,PASSWORD_DEFAULT),$a['id']]);}
 flash('Saved.');header('Location: '.$back);exit;
}
