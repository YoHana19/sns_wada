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
    $sql = 'SELECT f.*, m.nick_name, m.user_picture_path FROM `friends` AS f LEFT JOIN `members` AS m ON f.friend_member_id=m.member_id WHERE `login_member_id`=? AND `state`=0 ORDER BY c.created DESC';
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
    

  <!-- コメント表示 -->
  <div class="preview">
    <!-- コメントボタン -->
    <button id="<?php echo $comment_id ?>" class="comment_button">友達リクエスト</button>

    <!-- コメント欄 -->
    <div id="<?php echo $comment_id . '_content' ?>" style="text-align: center; color: white; background-color: rgb(0, 153, 255); display: none;">

      <!-- ログインユーザーの写真 -->
      <?php
        $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
        $data = array($_SESSION['login_member_id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        $login_user_picture = $stmt->fetch(PDO::FETCH_ASSOC);
      ?>
      <img src="assets/images/<?php echo $login_user_picture['user_picture_path'] ?>" width="48" height="48"><br>

      <!-- コメント入力フォーム -->
      <input type="text" class="comment_content" id="<?php echo $comment_id . '_input' ?>" name="hoge" class="form-control" placeholder="例： comment" style="color: black;">
      
      <!-- コメントの内容 -->
      <div id="<?php echo $haiku_id . '_cont' ?>">
        <?php if(!empty($comments)): ?>
          <?php foreach ($comments as $comment) { ?>
            <p><a href="user.php?user_id=<?php echo $comment['member_id'] ?>"><?php echo $comment['nick_name'] ?></a></p>
            <img src="assets/images/<?php echo $comment['user_picture_path'] ?>" width="48" height="48">
            <p><?php echo $comment['comment'] ?></p>
            <p><?php echo $comment['created'] ?></p>
          <?php } ?>
        <?php endif; ?>
      </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>

</body>
</html>
      