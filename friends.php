<?php
session_start();
require('dbconnect.php');
require('function.php');

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

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <!-- for Bootstrap -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <!-- For Modal Window -->
  <link rel="stylesheet" type="text/css" href="assets/css/mw_haiku_input.css">
  <!-- 全ページ共通 -->
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- 各ページ -->
  <link rel="stylesheet" type="text/css" href="assets/css/ranking.css">
</head>
<body>

  <!-- ヘッダー -->
  <?php require('header.php'); ?>

  <div class="container">
    <div class="row whole-content">
      <div class="col-md-3 left-content">
        <?php require('friends_left.php'); ?>
      </div>

      <div class="col-md-8 right-content" style="margin-top: 0;">
        <?php require('friends_ranking.php'); ?>
      </div>
    </div>
  </div>

  <!-- フッター -->
  <?php require('footer.php') ?>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/friend.js"></script>
  <script src="assets/js/likes.js"></script>
  <script src="assets/js/dislikes.js"></script>
  <script src="assets/js/comment.js"></script>

</body>
</html>