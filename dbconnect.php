<?php  
$dsn = 'mysql:dbname=sns_wada;host=localhost';
$user = 'root';
$password = '';

$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// PDOExceptionが使用可能になる。この中にエラー文が格納される
$dbh->query('SET NAMES utf8');

?>