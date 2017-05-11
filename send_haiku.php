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
  if ($_POST['up_haiku'] != 5) {
    $bozu_point += 1;
  }
  // 中の句
  if ($_POST['md_haiku'] != 7) {
    $bozu_point += 1;
  }
  // 下の句
  if ($_POST['lw_haiku'] != 5) {
    $bozu_point += 1;
  }

  $picture_name = '';
  // 画像アップロード処理
  if (isset($_FILES['photo_file']['name']) && !empty($_FILES['photo_file']['name'])) {
    $picture_name = date('YmdHis') . $_FILES['photo_file']['name'];
    // 20170308152500hogehoge.jpg←画像ファイル名作成
    move_uploaded_file($_FILES['photo_file']['tmp_name'], 'assets/images/' . $picture_name);
  }

  if ($_POST['page'] == 'chat') { // チャット

    // 初チャットの判定
    if (!empty($_POST['room'])) { // チャット済み
      // 最新チャットroomの更新
      $sql = 'UPDATE `rooms` SET `modified`=NOW() WHERE `room_id`=?';
      $data = array($_POST['room']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

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
      $data = array($_SESSION['login_member_id'],$_POST['friend_id'],$_POST['room'],$_POST['up_haiku'],$_POST['md_haiku'],$_POST['lw_haiku'],$picture_name);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

    } else { // 初チャット
      $sql = 'INSERT INTO `rooms` set `room_id`=NULL,
                                      `member_id_1`=?,
                                      `member_id_2`=?,
                                      `created`=NOW()
                                       ';
      $data = array($_SESSION['login_member_id'],$_POST['friend_id']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      // room_idの取得
      $sql = 'SELECT `room_id` FROM `rooms` WHERE `member_id_1`=? AND `member_id_2`=?';
      $data = array($_SESSION['login_member_id'],$_POST['friend_id']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $room = $stmt->fetch(PDO::FETCH_ASSOC);

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
      $data = array($_SESSION['login_member_id'],$_POST['friend_id'],$room['room_id'],$_POST['up_haiku'],$_POST['md_haiku'],$_POST['lw_haiku'],$picture_name);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
    }

    // 坊主ポイントDB登録
    $sql = 'UPDATE `members` SET `bozu_points`=? WHERE `member_id`=?';
    $data = array($bozu_point, $_SESSION['login_member_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $url = 'chat.php?friend_id=' . $_POST['friend_id'];

    header('Location: ' . $url);
  
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
    $data = array($_SESSION['login_member_id'],$_POST['up_haiku'],$_POST['md_haiku'],$_POST['lw_haiku'],$picture_name,$_POST['short_comment']);
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