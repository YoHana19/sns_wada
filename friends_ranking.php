<?php
  session_start();
  require('dbconnect.php');

// 友達内ランキングよし(歌人)用sql文
  $sql = 'SELECT * FROM';
  $data = array($_REQUEST['']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $tweet = $stmt->fetch(PDO::FETCH_ASSOC);

// ランキング上位3名のユーザー名、プロフィール画像取得

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

</body>
</html>