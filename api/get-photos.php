<?php require __DIR__.'/../includes/functions.php';
header('Content-Type: application/json');header('Cache-Control: no-store');
$r=$pdo->query("SELECT p.id,p.filename,p.created_at,v.name FROM photos p JOIN visitors v ON v.id=p.visitor_id WHERE p.status='approved' AND v.display_consent=1 AND v.privacy_consent=1 ORDER BY p.created_at")->fetchAll();
echo json_encode(['photos'=>$r,'duration'=>max(2,(int)setting('duration','10')),'order'=>setting('order','chronological')]);
