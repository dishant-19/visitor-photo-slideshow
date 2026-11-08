<?php require __DIR__.'/../includes/functions.php';
header('Content-Type: application/json');
function out($ok,$m,$c=200){http_response_code($c);echo json_encode(['ok'=>$ok,'message'=>$m]);exit;}
if($_SERVER['REQUEST_METHOD']!=='POST'||!csrf_ok())out(false,'Invalid request token.',403);
if(empty($_SESSION['visitor']))out(false,'Please register first.',401);
if(empty($_FILES['photos']))out(false,'No files received.',400);
$ext=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];$f=$_FILES['photos'];$n=0;$errs=[];
$status=setting('auto_approve','0')==='1'?'approved':'pending';
$fi=new finfo(FILEINFO_MIME_TYPE);$cat=in_array($_POST['category']??'',CATEGORIES,true)?$_POST['category']:'General';
foreach($f['name'] as $i=>$orig){
 if($f['error'][$i]!==UPLOAD_ERR_OK){$errs[]="$orig: upload failed.";continue;}
 if($f['size'][$i]>5*1024*1024){$errs[]="$orig: larger than 5 MB.";continue;}
 $mime=$fi->file($f['tmp_name'][$i]);
 if(!isset($ext[$mime])||@getimagesize($f['tmp_name'][$i])===false){$errs[]="$orig: not a valid JPG/PNG/WebP image.";continue;}
 $name=bin2hex(random_bytes(16)).'.'.$ext[$mime];
 $dest=__DIR__.'/../uploads/photos/'.$name;$saved=false;
 if(function_exists('imagecreatefromstring')&&($im=@imagecreatefromstring(file_get_contents($f['tmp_name'][$i])))){ // re-encode: strips metadata and any embedded payload
  if($mime==='image/jpeg'&&function_exists('exif_read_data')){$ex=@exif_read_data($f['tmp_name'][$i]);$ang=[3=>180,6=>-90,8=>90][$ex['Orientation']??1]??0;if($ang&&($rot=imagerotate($im,$ang,0))){imagedestroy($im);$im=$rot;}} // keep phone photos upright
  imagealphablending($im,false);imagesavealpha($im,true);
  $saved=$mime==='image/png'?imagepng($im,$dest):($mime==='image/webp'?imagewebp($im,$dest,88):imagejpeg($im,$dest,88));
  imagedestroy($im);
 }elseif(!function_exists('imagecreatefromstring'))$saved=move_uploaded_file($f['tmp_name'][$i],$dest);
 if(!$saved){$errs[]="$orig: could not process image.";continue;}
 $pdo->prepare('INSERT INTO photos(visitor_id,filename,original,status,category) VALUES(?,?,?,?,?)')->execute([$_SESSION['visitor'],$name,mb_substr(basename($orig),0,255),$status,$cat]);$n++;
}
$_SESSION['uploaded']=$n;
out($n>0,$n>0?"$n photo(s) uploaded.".($errs?' '.implode(' ',$errs):''):implode(' ',$errs),$n>0?200:422);
