<?php
session_start();
require('dbconnect.php');

$_SESSION['login_member_id'] = 1;

// ログインユーザーの情報取得
$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_member = $stmt->fetch(PDO::FETCH_ASSOC);

// ログインユーザーの友達の情報取得
// 友達検索の場合
$search_word = '';
if (isset($_GET['search_word']) && !empty($_GET['search_word'])) {
    // 検索の場合の処理
    $sql = 'SELECT * FROM `friends` AS f LEFT JOIN `members` AS m ON f.friend_member_id=m.member_id WHERE f.login_member_id=? AND m.nick_name LIKE ? ORDER BY m.nick_name';
    $word = '%' . $_GET['search_word'] . '%';
    $data = array($_SESSION['login_member_id'], $word);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $search_word = $_GET['search_word'];

} else {
    // 通常の処理
    $sql = 'SELECT * FROM `friends` AS f LEFT JOIN `members` AS m ON f.friend_member_id=m.member_id WHERE f.login_member_id=? ORDER BY m.nick_name';
    $data = array($_SESSION['login_member_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
}

$friends = array();
while ($friend = $stmt->fetch(PDO::FETCH_ASSOC)){
  $friends[] = $friend;
}

// 友達数カウント
$num_friends = count($friends);

?>


</html>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" type="text/css" href="assets/css/left_sideber.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <link rel="stylesheet" type="text/css" href="assets/css/friends.css">
  <link rel="stylesheet" type="text/css" href="assets/css/chat.css">
</head>

<body>

  <div class="container">
    <div class="row content">
      <div class="col-md-3 left-content">
        <?php require('friends_left.php'); ?>
      </div>

      <div class="col-md-8 right-content">
        <?php require('friends_ranking.php'); ?>
      </div>
    </div>
  </div>

</body>
</html>