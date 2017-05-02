<?php
session_start();
require('dbconnect.php');

if ($_POST['state'] == 'admit') {
  $sql = 'UPDATE `friends` SET `state`=1 WHERE `friend_id`=?';
  $data = array($_POST['friend_id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $state = 'admit';
} else {
  $sql = 'DELETE FROM `friends` WHERE `friend_id`=?';
  $data = array($_POST['friend_id']);
  $friend_stmt = $dbh->prepare($sql);
  $friend_stmt->execute($data);
  $state = 'reject';
}

// 画面の表示を切り替えるためのデータを作成
$data = array('id' => $_POST['friend_id'],
              'state' => $state
              );

header("Content-type: text/plain; charset=UTF-8");
//ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）
echo json_encode($data); // PHPとJS間でデータのやり取りを行うためにjson形式（{"hoge":"hoge","hoge":"hoge",....}）でデータを送る
?>