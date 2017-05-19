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
    // 句の削除
    $sql = 'DELETE FROM `haikus` WHERE `haiku_id`=?';
    $data = array($_GET['haiku_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // よしの削除
    $sql = 'DELETE FROM `likes` WHERE `haiku_id`=?';
    $data = array($_GET['haiku_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // あしの削除
    $sql = 'DELETE FROM `dislikes` WHERE `haiku_id`=?';
    $data = array($_GET['haiku_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // コメントの削除
    $sql = 'DELETE FROM `comments` WHERE `haiku_id`=?';
    $data = array($_GET['haiku_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
  }


}

header('Location: timeline.php');
exit();
?>