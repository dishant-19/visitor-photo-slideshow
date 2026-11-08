<?php
// Database connection. Defaults match stock XAMPP; override with a git-ignored .env (see .env.example).
$env=@parse_ini_file(__DIR__.'/../.env')?:[];
define('DB_HOST',$env['DB_HOST']??'localhost');define('DB_NAME',$env['DB_NAME']??'visitor_photo_slideshow');
define('DB_USER',$env['DB_USER']??'root');define('DB_PASS',$env['DB_PASS']??'');
$pdo=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
