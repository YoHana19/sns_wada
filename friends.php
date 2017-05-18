<?php
session_start();
require('dbconnect.php');
require('function.php');

// ログイン判定&ログインユーザー情報取得
$login_member = loginJudge();

// ログインユーザーの友達idの情報取得
$sql = 'SELECT `login_member_id`, `friend_member_id` FROM `friends` WHERE (`login_member_id`=? OR `friend_member_id`=?) AND `state`=1';
$data = array($_SESSION['login_member_id'], $_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$friends_id = array();
while ($friend_id = $stmt->fetch(PDO::FETCH_ASSOC)){
  $friends_id[] = $friend_id;
}

$friends_name = array();
$search_word_f = '';
foreach ($friends_id as $friend_id) {
  // 友達のニックネーム取得
  // 友達検索の場合
  if (isset($_GET['search_word']) && !empty($_GET['search_word'])) {
    // 検索の場合の処理
    if ($friend_id['login_member_id'] == $_SESSION['login_member_id']) {
      $sql = 'SELECT `nick_name` FROM `members` WHERE `member_id`=? AND `nick_name` LIKE ?';
      $word = '%' . $_GET['search_word'] . '%';
      $data = array($friend_id['friend_member_id'], $word);
    } else {
      $sql = 'SELECT `nick_name` FROM `members` WHERE `member_id`=? AND `nick_name` LIKE ?';
      $word = '%' . $_GET['search_word'] . '%';
      $data = array($friend_id['login_member_id'], $word);
    }
    $search_word_f = $_GET['search_word'];

  // 通常の処理
  } else {
    if ($friend_id['login_member_id'] == $_SESSION['login_member_id']) {
      $sql = 'SELECT `nick_name` FROM `members` WHERE `member_id`=?';
      $data = array($friend_id['friend_member_id']);
    } else {
      $sql = 'SELECT `nick_name` FROM `members` WHERE `member_id`=?';
      $data = array($friend_id['login_member_id']);
    }
  }
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  if ($friend_name = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $friends_name[] = $friend_name['nick_name'];
  }
}

// 名前順にソート
sort($friends_name);

// 友達数カウント
$num_friends = count($friends_name);

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

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>

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

  <script src="assets/js/friend.js"></script>
  <script src="assets/js/likes.js"></script>
  <script src="assets/js/dislikes.js"></script>
  <script src="assets/js/comment.js"></script>
  <!-- スクロール固定 -->
  <script src="assets/js/scroll_fix.js"></script>

</body>
</html>