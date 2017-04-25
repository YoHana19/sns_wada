<?php
session_start();
require('dbconnect.php');

// var_dump($_FILES['photo_file']['name']);

// ログインチェック
if (isset($_SESSION['login_member_id'])) {

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

}

header('Location: timeline.php');
exit();
?>