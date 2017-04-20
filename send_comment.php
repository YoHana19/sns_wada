<?php
session_start();
require('dbconnect.php');

// コメントをDBに挿入
$sql = 'INSERT INTO `comments` set `comment_id`=NULL,
                                   `member_id`=?,
                                   `haiku_id`=?,
                                   `comment`=?,
                                   `created`=NOW()
                                   ';
$data = array($_SESSION['login_member_id'],$_POST['haiku_id'],$_POST['comment']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// コメントした人の情報の取得
$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$com_user = $stmt->fetch(PDO::FETCH_ASSOC);

// コメントを表示を表示させるためのデータを作成
$data = array('id' => $_POST['haiku_id'],
              'nick_name' => $com_user['nick_name'],
              'user_picture_path' => $com_user['user_picture_path'],
              'created' => $com_user['created'],
              'comment' => $_POST['comment']
             );

header("Content-type: text/plain; charset=UTF-8");
echo json_encode($data); // PHPとJS間でデータのやり取りを行うためにjson形式（{"hoge":"hoge","hoge":"hoge",....}）でデータを送る
?>