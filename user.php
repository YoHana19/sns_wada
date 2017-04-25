<?php
session_start();
require('dbconnect.php');

$_SESSION['login_member_id'] = 1;
$user_id = 5;
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.css" rel="stylesheet">
</head>
<body>

  <?php
    // 友達申請済みかどうかの判定処理
    $sql = 'SELECT * FROM `friends` WHERE `login_member_id`=? AND `friend_member_id`=?';
    $data = array($_SESSION['login_member_id'],$user_id);
    $friend_stmt = $dbh->prepare($sql);
    $friend_stmt->execute($data);
  ?>

  <div>
    <?php if($friend = $friend_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
      <?php if ($friend['state'] == 1) { ?>
        <!-- 友達 -->
        <p>友達</p>
      <?php } else { ?>
        <!-- 申請済み -->
        <input type="submit" value="申請取り消し" id="<?php echo $user_id; ?>" class="friend btn btn-danger btn-xs">
        
      <?php } ?>
    <?php } else { ?>
      <!-- 未申請 -->
      <input type="submit" value="友達申請" id="<?php echo $user_id; ?>" class="friend btn btn-primary btn-xs">
    <?php } ?>
    <!-- 確認メッセージ -->
    <p id="done_msg" style="display: none">友達リクエストを送りました。</p>
    <p id="undone_msg" style="display: none">友達リクエストを取り消しました。</p>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/friend.js"></script>

</body>
</html>