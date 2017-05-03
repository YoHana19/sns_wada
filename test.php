<?php
session_start();
require('dbconnect.php');

$sql = 'SELECT * FROM `rooms` WHERE `member_id_1`=1';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$records = array();
while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $records[] = $record;
}
?>