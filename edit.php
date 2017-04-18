<?php
require('dbconnect.php');

//$_POSTで受け取り、変数定義
    // $nick_name = $_POST['nick_name'];
    // $email = $_POST['email'];
    // $password = $_POST['password'];
    // $user_picture_path = $_POST['user_picture_path'];

// sql文を書く(取ってくるのはログインユーザーの)
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
    <input type="nick_name" name="nick_name" value=""> <!-- valueの後にphpでecho $nick_nameを入れるよ  -->
  </div>

  <div>
    <label>メールアドレス</label>
    <input type="email" name="email" value=""> <!-- valueの後にphpでecho $emailを入れる -->
  </div>

  <div>
    <label>メールアドレス確認用</label>
    <input type="email_check" name="email_check" value=""> <!-- valueの後にphpで上記のメールアドレスと同じかどうかのif文を作成 -->
  </div>

  <div>
    <label>パスワード</label>
    <input type="password" name="password" value=""> <!-- valueの後にphpでecho $passwordを入れる -->
  </div>

  <div>
    <label>パスワード(確認用)</label>
    <input type="password_check" name="password_check" value=""> <!-- valueの後にphpで上記のパスワードと一致するか確認 -->
  </div>

  <div>
    <label>アイコン画像</label>
    <input type="" name="" value=""> <!-- valueの後にphp echo  -->
  </div>

    </div>
  </form>
<body>
</body>
</html>