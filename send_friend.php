<?php
session_start();
require('dbconnect.php');

// 友達リクエストを取り消す処理を入れる場合
// 友達申請済みかどうかの判定処理
$sql = 'SELECT * FROM `friends` WHERE `login_member_id`=? AND `friend_member_id`=?';
$data = array($_SESSION['login_member_id'],$_POST['user_id']);
$friend_stmt = $dbh->prepare($sql);
$friend_stmt->execute($data);

if ($friend = $friend_stmt->fetch(PDO::FETCH_ASSOC)) {
    // 申請済み or 友達
    if ($friend['state'] == 0) { // 申請済み
      $sql = 'DELETE FROM `friends` WHERE `login_member_id`=? AND `friend_member_id`=?';
      $data = array($_SESSION['login_member_id'],$_POST['user_id']);
      $friend_stmt = $dbh->prepare($sql);
      $friend_stmt->execute($data);
      $state = 'undone';
    }

} else {
  // 未申請
  $sql = 'INSERT INTO `friends` set `friend_id`=NULL,
                                    `login_member_id`=?,
                                    `friend_member_id`=?
                                    ';
  $data = array($_SESSION['login_member_id'],$_POST['user_id']);
  $like_stmt = $dbh->prepare($sql);
  $like_stmt->execute($data);
  $state = 'done';
}

// 画面の表示を切り替えるためのデータを作成
$data = array('id' => $_POST['user_id'],
              'state' => $state,
             );

header("Content-type: text/plain; charset=UTF-8");
//ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）
echo json_encode($data); // PHPとJS間でデータのやり取りを行うためにjson形式（{"hoge":"hoge","hoge":"hoge",....}）でデータを送る
?>
