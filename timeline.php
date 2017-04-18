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

  <?php } ?>

</body>
</html>