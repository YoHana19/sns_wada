<?php
session_start();
require('dbconnect.php');
// var_dump($_FILES['photo_file']['name']);

// ログインチェック
if (isset($_SESSION['login_member_id'])) {

  // 坊主ポイント
  $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $data = array($_SESSION['login_member_id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  $bozu_point = $record['bozu_points'];

  // 上の句
  if (!$_POST['up_haiku'] == 5) {
    $bozu_point += 1;
  }
  // 中の句
  if (!$_POST['md_haiku'] == 7) {
    $bozu_point += 1;
  }
  // 下の句
  if (!$_POST['lw_haiku'] == 5) {
    $bozu_point += 1;
  }

  if ($_POST['page'] == 'chat') { // チャット
  
    // 送られてきた俳句をDBに追加
    $sql = 'INSERT INTO `chats` set `chat_id`=NULL,
                                    `sender_id`=?,
                                    `reciever_id`=?,
                                    `room_id`=?,
                                    `chat_1`=?,
                                    `chat_2`=?,
                                    `chat_3`=?,
                                    `back_img`=?,
                                    `created`=NOW()
                                    ';
    $data = array($_SESSION['login_member_id'],$_POST['friend_id'],$_POST['room'],$_POST['up_haiku'],$_POST['md_haiku'],$_POST['lw_haiku'],$_FILES['photo_file']['name']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // 坊主ポイントDB登録
    $sql = 'UPDATE `members` SET `bozu_points`=? WHERE `member_id`=?';
    $data = array($bozu_point, $_SESSION['login_member_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    header('Location: chat.php');
  
  } else { // タイムライン

    // 送られてきた俳句をDBに追加
    $sql = 'INSERT INTO `haikus` set `haiku_id`=NULL,
                                     `member_id`=?,
                                     `haiku_1`=?,
                                     `haiku_2`=?,
                                     `haiku_3`=?,
                                     `back_img`=?,
                                     `short_comment`=?,
                                     `created`=NOW()
                                     ';
    $data = array($_SESSION['login_member_id'],$_POST['up_haiku'],$_POST['md_haiku'],$_POST['lw_haiku'],$_FILES['photo_file']['name'],$_POST['short_comment']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // 坊主ポイントDB登録
    $sql = 'UPDATE `members` SET `bozu_points`=? WHERE `member_id`=?';
    $data = array($bozu_point, $_SESSION['login_member_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    header('Location: timeline.php');
  }
}
exit();
?>