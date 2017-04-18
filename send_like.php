<?php
session_start();
require('dbconnect.php');

// ajaxでPOST送信したデータは、送信先で$_POSTとして受け取れる
// $_POST['task_id'] = 1;

// いいね！済みかどうかの判定処理
$sql = 'SELECT * FROM `likes` WHERE `member_id`=? AND `tweet_id`=?';
$data = array($_SESSION['login_member_id'],$_POST['tweet_id']);
$is_like_stmt = $dbh->prepare($sql);
$is_like_stmt->execute($data);

if ($is_like = $is_like_stmt->fetch(PDO::FETCH_ASSOC)) {
    // いいねデータが存在する
    // いいねを取り消す処理
    $sql = 'DELETE FROM `likes` WHERE `member_id`=? AND `tweet_id`=?';
    $data = array($_SESSION['login_member_id'],$_POST['tweet_id']);
    $like_stmt = $dbh->prepare($sql);
    $like_stmt->execute($data);
    $state = 'unlike';

} else {
    // いいねデータが存在しない
    // いいねを追加する処理
    $sql = 'INSERT INTO `likes` set `member_id`=?,
                                    `tweet_id`=?
                                    ';
    $data = array($_SESSION['login_member_id'],$_POST['tweet_id']);
    $like_stmt = $dbh->prepare($sql);
    $like_stmt->execute($data);
    $state = 'like';
}

// いいね！数カウント処理
$sql = 'SELECT count(*) AS total FROM `likes` WHERE `tweet_id`=?';
$data = array($_POST['tweet_id']);
$count_stmt = $dbh->prepare($sql);
$count_stmt->execute($data);
$count = $count_stmt->fetch(PDO::FETCH_ASSOC);

// 画面の表示を切り替えるためのデータを作成
$data = array('id' => $_POST['tweet_id'],
              'state' => $state,
              'like_cnt' => $count['total']
             );

header("Content-type: text/plain; charset=UTF-8");
//ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）
echo json_encode($data); // PHPとJS間でデータのやり取りを行うためにjson形式（{"hoge":"hoge","hoge":"hoge",....}）でデータを送る
?>
