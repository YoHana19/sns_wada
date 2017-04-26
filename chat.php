<?php
session_start();
require('dbconnect.php');
$_SESSION['login_member_id'] = 1;
$friend_id = 2;

$sql = sprintf('SELECT c.*, m.nick_name, m.user_picture_path FROM `chats` AS c LEFT JOIN `members` AS m ON c.sender_id=m.member_id WHERE c.sender_id LIKE %d AND c.reciever_id LIKE %d OR c.sender_id LIKE %d AND c.reciever_id LIKE %d ORDER BY c.created DESC', $_SESSION['login_member_id'], $friend_id, $friend_id, $_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute();

// 空の配列を定義
$chats = array();

while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
  // whileの外に用意した配列に入れる
  $chats[] = $record;
}

// 縦書きにする関数
function tateGaki($haiku) {
  $matches = preg_split("//u", $haiku, -1, PREG_SPLIT_NO_EMPTY);
  $v_haiku = '';
  foreach ($matches as $letter) {
    $v_haiku .= $letter . "<br>";
  }
  return rtrim($v_haiku, "<br>");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <!-- Bootstrap -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/css/font-awesome.css" rel="stylesheet">
</head>
<body>

  <?php foreach ($chats as $chat) { ?>

    <?php if ($chat['sender_id'] == $_SESSION['login_member_id']): ?>
      <!-- ログインユーザーは右表示 -->
      <div class="login_user" style="float: right;">
        <div><?php echo $chat['nick_name']; ?></div>
        <img src="assets/images/<?php echo $chat['user_picture_path']; ?>" width="100" height="100"><br>
        <div><?php echo $chat['chat_1']; ?></div>
        <div><?php echo $chat['chat_2']; ?></div>
        <div><?php echo $chat['chat_3']; ?></div>
        <?php echo tateGaki($chat['chat_1']); ?>
      </div>
    <?php else: ?>
      <!-- 友達は左表示 -->
      <div class="friend" style="float: left;">
        <div><?php echo $chat['nick_name']; ?></div>
        <img src="assets/images/<?php echo $chat['user_picture_path']; ?>" width="100" height="100"><br>
        <div><?php echo $chat['chat_1']; ?></div>
        <div><?php echo $chat['chat_2']; ?></div>
        <div><?php echo $chat['chat_3']; ?></div>
        <?php echo tateGaki($chat['chat_1']); ?>
      </div>
    <?php endif; ?>

  <?php } ?> <!-- 繰り返し文終了 -->

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>