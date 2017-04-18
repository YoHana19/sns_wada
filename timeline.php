<?php
session_start();
require('dbconnect.php');

$sql = 'SELECT h.*, m.nick_name, m.user_picture_path FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id ORDER BY h.created';
$stmt = $dbh->prepare($sql);
$stmt->execute();

// 空の配列を定義
$posts = array();

while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
  // whileの外に用意した配列に入れる
  $posts[] = $record;
  // 配列名の後に[]をつけると最後の段を指定する]
}

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
</head>
<body>
  <!-- 繰り返し処理 -->
  <?php foreach ($posts as $post) { ?>

    <!-- パラメーター設定 -->
    <?php $nick_name = $post['nick_name'] ?>
    <?php $user_picture_path = $post['user_picture_path'] ?>
    <?php $haiku_1 = $post['haiku_1'] ?>
    <?php $haiku_2 = $post['haiku_2'] ?>
    <?php $haiku_3 = $post['haiku_3'] ?>
    <?php $created = $post['created'] ?>

    <?php echo $nick_name ?><br>
    <img src="assets/images/<?php echo $user_picture_path ?>" width="48" height="48"><br>
    <?php echo $haiku_1 ?><br>
    <?php echo $haiku_2 ?><br>
    <?php echo $haiku_3 ?><br>
    <?php echo $created ?><br>

    <?php $v_haiku_1 = tateGaki($haiku_1); ?>
    <?php echo $v_haiku_1 ?>

    <!-- いいね！データが存在する（削除ボタン表示） -->
    <input type="submit" value="いいね！取り消し" id="<?php echo $tweet_id; ?>" class="like btn btn-danger btn-xs">
              
    <!-- いいね！データが存在しない（いいねボタン表示） -->
    <input type="submit" value="いいね！" id="<?php echo $tweet_id; ?>" class="like btn btn-primary btn-xs">
    
  <?php } ?>

</body>
</html>