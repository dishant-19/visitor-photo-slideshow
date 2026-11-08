<?php require '../includes/functions.php';
$first=(int)$pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn()===0;$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $u=trim($_POST['u']??'');$p=$_POST['p']??'';
 if(!csrf_ok())$err='Invalid token.';
 elseif($first){if($u===''||strlen($p)<8)$err='Username required and password min 8 characters.';else{$pdo->prepare('INSERT INTO admins(username,password_hash) VALUES(?,?)')->execute([$u,password_hash($p,PASSWORD_DEFAULT)]);flash('Admin created. Please log in.');header('Location: login.php');exit;}}
 elseif(login_blocked())$err='Too many failed attempts. Try again in 15 minutes.';
 elseif(admin_login($u,$p)){header('Location: dashboard.php');exit;}
 else $err='Invalid username or password.';
}
head($first?'Create admin':'Admin login','../');?>
<div class="glass p-4 rounded-4 mx-auto" style="max-width:400px"><h2><?=$first?'Create first admin':'Admin login'?></h2><?php if($err)echo '<div class="alert alert-danger">'.e($err).'</div>';?>
<form method="post"><?=csrf_field()?><input class="form-control mb-3" name="u" placeholder="Username" required><input class="form-control mb-3" type="password" name="p" placeholder="Password" required><button class="btn btn-primary rounded-pill w-100"><?=$first?'Create admin':'Log in'?></button></form></div>
<?php foot('../');
