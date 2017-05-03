<?php
session_start();
require('dbconnect.php');

$sql = 'SELECT * FROM `rooms`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

?>