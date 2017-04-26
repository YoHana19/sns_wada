<?php
session_start();
require('dbconnect.php');

// ログインチェック
if (isset($_SESSION['login_member_id'])) {

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
    $data = array($_SESSION['login_member_id'],$_POST['up_haiku'],$_POST['md_haiku'],$_POST['lw_haiku'],$_FILES['photo_file']['name'],$_POST['short_comment']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    header('Location: timeline.php');
  }
}
exit();
?>