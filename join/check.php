<?php
session_start();
require('../dbconnect.php');

// join.phpを正しく通ってこなかった場合、強制的にindex.phpに遷移
if (!isset($_SESSION['join'])) {
  header('Location: index.php');
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

    // $_SESSIONの情報を削除  
    unset($_SESSION['join']);
    // thanks.phpに遷移}
    header('Location: thanks.php');
    exit();

  }catch(PDOExeption $e){
    // 例外が発生した場合の処理
    echo 'SQL文実行時エラー:' . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <div>
    ニックネーム：<br>
    <?php echo $_SESSION['join']['nick_name']; ?>
  </div>
  <div>
    メールアドレス：<br>
    <?php echo $_SESSION['join']['email']; ?>
  </div>
  <div>
    パスワード：<br>
    <?php echo $_SESSION['join']['password']; ?>
  </div>
  <br>
  <form method="POST" action="">
    <input type="hidden" name="hoge" value="fuga">
    <a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a>
    <input type="submit" name="会員登録">
  </form>
</body>
</html>




