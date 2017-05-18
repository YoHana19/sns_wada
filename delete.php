<?php 
session_start();
require('dbconnect.php');

// ログインチェック
if (isset($_SESSION['login_member_id'])) {

  // 指定されたIDのツイートデータが、ログインユーザー本人のものかチェック
  $sql = 'SELECT * FROM `haikus` WHERE `haiku_id`=?';
  $data = array($_GET['haiku_id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($record['member_id'] == $_SESSION['login_member_id']) {
    $sql = 'DELETE FROM `haikus` WHERE `haiku_id`=?';
    $data = array($_GET['haiku_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
  }
}

header('Location: timeline.php');
exit();
?>