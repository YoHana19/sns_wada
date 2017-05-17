<?php
session_start();
require('../dbconnect.php');

if (empty($_REQUEST)) {
  header('Location: ../index.php');
  exit();
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <link rel="stylesheet" type="text/css" href="../assets/css/thanks.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/earlyaccess/hannari.css" rel="stylesheet" />
  <meta charset="utf-8">
  <title>ご登録ありがとうございます！｜和だ</title>
</head>
<body>
  <div class="login-background" style="text-align: center;">
    <h1 style="font-size: 340px; color: white; font-family: serif; margin-top: 0px;">圧倒的<br>感謝！</h1>
  </div>
  <div class="virgin-login">
    <div class="container">
      <div class="row">
        <div class="col-md-12" style="text-align: center;">
          <h1 style="font-family: serif; font-size: 80px; margin: 250px 0 180px 0; color: white;">こっちにおいでよ。</h1>
          <form action="../login.php" method="POST" accept-charset="utf-8">
            <input type="submit" value="ログイン" class="btn btn-default btn-lg">
            <input type="hidden" name="email" value="<?php echo $_REQUEST['email'] ?>">
            <input type="hidden" name="password" value="<?php echo $_REQUEST['password'] ?>">
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>