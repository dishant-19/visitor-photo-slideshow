<?php require '../includes/functions.php';admin_only();
$t=$_GET['type']??'';
if(!in_array($t,['visitors','photos'],true)){http_response_code(400);exit('Invalid export type.');}
header('Content-Type: text/csv; charset=utf-8');header('Content-Disposition: attachment; filename="'.$t.'-'.date('Ymd').'.csv"');
$o=fopen('php://output','w');fwrite($o,"\xEF\xBB\xBF");
$safe=fn($v)=>is_string($v)&&$v!==''&&strpos("=+-@\t\r",$v[0])!==false?"'".$v:$v; // block spreadsheet formula injection
$put=fn($row)=>fputcsv($o,array_map($safe,$row),',','"','');
if($t==='visitors'){$put(['ID','Name','Email','Mobile','Visits','Privacy consent','Display consent','Joined']);
 foreach($pdo->query('SELECT code,name,email,mobile,visits,privacy_consent,display_consent,created_at FROM visitors ORDER BY id') as $r)$put([$r['code'],$r['name'],$r['email'],$r['mobile'],$r['visits'],$r['privacy_consent']?'Yes':'No',$r['display_consent']?'Yes':'No',$r['created_at']]);}
else{$put(['Photo ID','Visitor ID','Visitor','File','Status','Uploaded']);
 foreach($pdo->query('SELECT p.id,v.code,v.name,p.filename,p.status,p.created_at FROM photos p JOIN visitors v ON v.id=p.visitor_id ORDER BY p.id') as $r)$put([$r['id'],$r['code'],$r['name'],$r['filename'],$r['status'],$r['created_at']]);}
fclose($o);
