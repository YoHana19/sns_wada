<?php

session_start();
require('../dbconnect.php');
$email = '';
$password = '';

$errors = array();
// ログインボタンが押されたとき
if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($email != '' && $password != '') {
        // 入力されたメールアドレスとパスワードの組み合わせがデータベースに登録されているかチェック
        $sql = 'SELECT * FROM `members` WHERE `email`=? AND `password`=?';
        $data = array($email, sha1($password));
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data); // データが1件か0件か
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($record == false) {
            // そうでなければエラーメッセージ
            // echo 'ログイン処理失敗';
            $errors['login'] = 'failed';
        } else {
            // されていればログイン処理
            // echo 'ログイン処理成功';
            $_SESSION['login_member_id'] = $record['member_id'];
            $_SESSION['time'] = time();

            // 自動ログイン設定
            if ($_POST['save'] == 'on') {
                // クッキーにログイン情報を保存
                setcookie('email', $email, time() + 60 * 60 * 24 * 30);
                setcookie('password', $password, time() + 60 * 60 * 24 * 30);
                // setcookie(キー, 値, 保存期間);
                // $_COOKIE['キー'] → 値
            }
            // ログインした際の時間をセッションに保存
            header('Location: timeline.php');
            exit();
        }
    } else {
        // 入力フォームが空だった場合の処理
        $errors['login'] = 'blank';
    }
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
          <form action="../login.php" method="get" accept-charset="utf-8">
            <input type="submit" value="ログイン" class="btn btn-default btn-lg">
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>