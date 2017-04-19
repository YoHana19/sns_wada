<?php
session_start();
require('dbconnect.php');

$_SESSION['login_member_id'] = 1;

$sql = 'SELECT * FROM `members`';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_member_id = $stmt->fetch(PDO::FETCH_ASSOC);

$nick_name = '';
$email = '';
$user_picture_path = '';
$back_picture_path = '';

$errors = array();

if (!empty($_POST)) {
$nick_name = $_POST['nick_name'];
$email = $_POST['email'];
$user_picture_path = $_POST['user_picture_path'];
$back_picture_path = $_POST['back_picture_path'];
$self_intro = $_POST['self_intro'];
}



 ?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <title></title>
  <meta charset="utf-8">
</head>
<form method="POST" action="">
  <div>
    <label>ニックネーム</label>
    <input type="nick_name" name="nick_name" value="<?php echo $login_member_id['nick_name']; ?>">
  </div>

  <div>
    <label>メールアドレス</label>
    <input type="email" name="email" value="<?php echo $login_member_id['email']; ?>">
  </div>

  <div>
    <label>メールアドレス確認用</label>
    <input type="email_check" name="email_check" value">
  </div>

  <div>
    <label>アイコン画像</label>
    <input type="file" name="picture_path" value="<?php echo $login_member_id['user_picture_path']; ?>">
  </div>

  <div>
    <label>背景画像</label>
    <input type="file" name="picture_path" value="<?php echo $login_member_id['back_picture_path']; ?>">
  </div>

<div>
<label>自己紹介句</label>
  <input type="" name="" value="<?php echo $login_member_id['self_intro']; ?>">
</div>

<div>
<button type="submit" value="送信">保存</button>
</div>

</form>
<body>
</body>
</html>