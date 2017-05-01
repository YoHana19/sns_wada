<?php
  if (!isset($_SESSION['join'])) {
  header('Location: index.php');
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
    <h1 style="font-size: 340px; color: white; font-family: serif;">圧倒的感謝！</h1>
  </div>
  <div class="virgin-login">
    <div class="container">
      <div class="row">
        <div class="col-md-12" style="text-align: center;">
          <h1 style="font-family: serif; font-size: 80px; margin: 250px 0 180px 0; color: white;">こっちにおいでよ。</h1>
          <form action="" method="get" accept-charset="utf-8">
            <input type="submit" value="ログイン" class="btn btn-default btn-lg">
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>