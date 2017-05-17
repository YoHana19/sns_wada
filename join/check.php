<?php
session_start();
require('../dbconnect.php');

// join.phpを正しく通ってこなかった場合、強制的にindex.phpに遷移
if (!isset($_SESSION['join'])) {
  header('Location: ../index.php');
  exit();
}

// 会員登録ボタンが押された際の処理
if (!empty($_POST)) {
  $nick_name = $_SESSION['join']['nick_name'];
  $email = $_SESSION['join']['email'];
  $password = $_SESSION['join']['password'];
  $password = sha1($password);
  // DBにデータを登録
  try{
    // 例外が発生する可能性がある処理
    $sql = 'INSERT INTO `members` SET `nick_name`=?,`email`=?,`password`=?,`created`=NOW()';

    $data = array($nick_name,$email,$password);//上の?に入る順番で作成
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // ログイン画面自動通過用の変数用意
    $url = 'thanks.php?email=' . $email . '&password=' . $_SESSION['join']['password'];

    // $_SESSIONの情報を削除  
    unset($_SESSION['join']);

    // thanks.phpに遷移
    header('Location: ' . $url);
    exit();

  }catch(PDOExeption $e){
    // 例外が発生した場合の処理
    echo 'SQL文実行時エラー:' . $e->getMessage();
    }
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/earlyaccess/hannari.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="../assets/css/check.css">
  <meta charset="utf-8">
  <title>ログイン｜和だ</title>
  <title>ご登録内容の確認</title>
</head>
<body>

<div class="check">
<div class="container">
  <div row>
    <div class="col-md-offset-9 col-md-3 check_contents">
      <h2 style="font-size: 27px; font-family: serif; border-bottom: 1.5px black solid; margin-bottom: 30px;">ご登録内容のご確認</h2>
      <div>
        <p style="border-bottom: 1px black dashed;">ニックネーム</p>
        <p style="text-align: center;"><?php echo $_SESSION['join']['nick_name']; ?></p>
      </div>
      <div>
        <p style="border-bottom: 1px black dashed;">メールアドレス</p>
        <p style="text-align: center;"><?php echo $_SESSION['join']['email']; ?></p>
      </div>
      <div>
        <p style="border-bottom: 1px black dashed;">パスワード</p>
        <p style="text-align: center;"><?php echo $_SESSION['join']['password']; ?></p>
      </div>
      <br>
      <form method="POST" action="">
        <input type="hidden" name="hoge" value="fuga">
        <a href="join.php?action=rewrite">&laquo;&nbsp;書き直す</a>
        <input type="submit" class="btn btn-success" value="確認して登録" name="会員登録">
      </form>
    </div>
  </div>
</div>
</div>

</body>
</html>



