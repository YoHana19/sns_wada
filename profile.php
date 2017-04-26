<?php
session_start();
require('dbconnect.php');
$_SESSION['id'] = 1;

$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
$data = array($_SESSION['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_user = $stmt->fetch(PDO::FETCH_ASSOC);

// 自分の作った全句を時系列で表示

$sql = 'SELECT h.*, m.nick_name, m.user_picture_path FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE h.haiku_1 ORDER BY h.created';
$data = array($_SESSION['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_user_ku = $stmt->fetch(PDO::FETCH_ASSOC);

var_dump($login_user_ku);


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>
<!--プロフィール写真/ 一言-->

  <img align="left" class="fb-image-lg" src="assets/images/<?php echo $login_user['back_picture_path']; ?>" alt="Profile back image example"/>
  <img align="left" class="fb-image-profile thumbnail" src="assets/images/<?php echo $login_user['user_picture_path']; ?>" alt="Profile imexample"/>
  
  <h1><?php echo $login_user['nick_name']; ?></h1>
  <p><?php echo $login_user['self_intro']; ?></p>
  <input type="button" style="position: absolute; right: 100px; top: 350px" onclick="location.href='edit.php'" value="プロフィール編集">

</body>
</html>