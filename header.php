<?php
session_start();
require('dbconnect.php');
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
    // 友達申請者リストの取得
    $sql = 'SELECT f.*, m.nick_name, m.user_picture_path FROM `friends` AS f LEFT JOIN `members` AS m ON f.friend_member_id=m.member_id WHERE `login_member_id`=? AND `state`=0 ORDER BY f.created DESC';
    $data = array($_SESSION['login_member_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // 空の配列を定義
    $friends = array();

    while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
      // whileの外に用意した配列に入れる
      $friends[] = $record;
      // 配列名の後に[]をつけると最後の段を指定する]
    }
  ?>
    

  <!-- 友達リクエスト表示 -->
  <div class="preview">
    <!-- リクエスト表示ボタン -->
    <button class="request_button">友達リクエスト</button>

    <!-- 友達リクエスト表示欄 -->
    <div id="requests" style="text-align: center; color: white; background-color: rgb(0, 153, 255); display: none;">
      
      <!-- 友達リクエストの内容 -->
      <div id="request_cont">
        <?php if(!empty($friends)): ?>
          <?php foreach ($friends as $friend) { ?>
            <div id="<?php echo $friend['friend_id']; ?>_cont">
              <p><?php echo $friend['nick_name'] ?></p>
              <img src="assets/images/<?php echo $friend['user_picture_path'] ?>" width="48" height="48">
              <button type="button" id="<?php echo $friend['friend_id']; ?>_a" class="button_request">許可</button>
              <button type="button" id="<?php echo $friend['friend_id']; ?>_r" class="button_request">削除</button>
            </div>
          <?php } ?>
        <?php endif; ?>
      </div>

    </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/friend_requests.js"></script>

</body>
</html>
      