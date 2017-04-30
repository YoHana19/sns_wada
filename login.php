<?php
session_start();
require('dbconnect.php');
$email = '';
$password = '';

$errors = array();

// 自動ログイン機能
if (isset($_COOKIE['email']) && $_COOKIE['email'] !='') {
  // クッキーが保存されていれば、$_POSTをクッキーの情報から生成
  $_POST['email'] = $_COOKIE['email'];
  $_POST['password'] = $_COOKIE['password'];
  $_POST['save'] = 'on';

  # code...
}

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
  <link rel="stylesheet" type="text/css" href="assets/css/login.css">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/earlyaccess/hannari.css" rel="stylesheet" />
  <meta charset="utf-8">
  <title>ログイン｜和だ</title>
</head>
<body>
  <div class="login-background">
      <div class="row">
        <div class="col-md-offset-4 col-md-4" style="margin-top: 200px;">
          <!--Pulling Awesome Font -->
          <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
            <div class="col-md-12">
                <div class="form-login">
                  <h4 style="font-size: 35px;">おかえりなさい</h4>
                  <form method="POST">
                    <input type="email" id="userName" name="email" class="form-control input-sm chat-input" placeholder="メールアドレス" value="<?php echo $email; ?>"/>
                    <?php if(isset($errors['login']) && $errors['login'] == 'blank'): ?> <!-- コロン構文 -->
                        <p style="color: red; font-size: 10px; margin-top: 2px;">メールアドレスとパスワードを入力してください</p>
                    <?php endif; ?>
                    <?php if(isset($errors['login']) && $errors['login'] == 'failed'): ?> <!-- コロン構文 -->
                        <p style="color: red; font-size: 10px; margin-top: 2px;">ログインに失敗しました。再度正しい情報でログインしてください</p>
                    <?php endif; ?>
                    </br>
                    <input type="password" id="userPassword" name="password" class="form-control input-sm chat-input" placeholder="パスワード" />
                    </br>
                    自動ログイン設定 <input type="checkbox" name="save" value="on">
                    <div class="wrapper" style="margin-top: 20px;">
                      <span class="group-btn">     
                      <input type="submit" value="ログイン" class="btn btn-success">
                      <i class="fa fa-sign-in"></i></a>
                      </span>
                    </div>
                  </form>
                  <div style="text-align: center; margin-top: 50px;">
                    <a href="index.php" title="" style="color: black; background-color: rgba(250, 250, 250, 0.2);">トップへ戻る。</a>
                  </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>


</body>
</html>