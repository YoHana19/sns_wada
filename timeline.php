<?php
session_start();
require('dbconnect.php');

$sql = 'SELECT * FROM `haikus` WHERE 1';
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
  <?php foreach ($posts as $post) { ?>
    <?php echo $post['haiku_1'] ?>
  <?php } ?>

</body>
</html>