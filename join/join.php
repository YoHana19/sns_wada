<?php
session_start();
require('../dbconnect.php');

// 各入力値を保持する変数を用意
$nick_name = '';
$email = '';
$password = '';

// エラー格納用の配列を用意
$errors = array();

if (!empty($_POST)) {

    $nick_name = $_POST['nick_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // ページ内バリデーション
    if ($nick_name == '') {
        //ニックネームのフォームが空のため、画面にエラーを出力
        $errors['nick_name'] = 'blank'; 
        // blank部分はどんな文字列でも良い
    }
    if ($email == '') {
        //ニックネームのフォームが空のため、画面にエラーを出力
        $errors['email'] = 'blank'; 
        // blank部分はどんな文字列でも良い
    }
    if ($password == '') {
        //ニックネームのフォームが空のため、画面にエラーを出力
        $errors['password'] = 'blank'; 
        // blank部分はどんな文字列でも良い
    } elseif (strlen($password) < 4) {
        $errors['password'] = 'length';
    }

// メールアドレスの重複チェック
    if(empty($errors)){
      // DBのmembersテーブルに入力されたメールアドレスがあるかどうか検索し取得
      try{
          $sql = 'SELECT COUNT(*) AS `cnt` FROM `members` WHERE `email` = ?';
          // COUNT(*) AS `cnt` 前者を後者として使用するということ
          $data = array($email);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
          $record = $stmt->fetch(PDO::FETCH_ASSOC);
          var_dump($record);
          if ($record['cnt'] > 0) {
            // 同じメールアドレスがDB内に存在したため
            $errors['email'] = 'duplicate';
          }

      } catch(PDOException $e){
          echo 'SQL文実行時エラー : ' . $e->message();
      }
    }

    //エラーがなかった場合の処理
    if (empty($errors)) {
        $_SESSION['join'] = $_POST;//joinはなんでも良い。
        header('Location: check.php');
        exit();
    }

} // if (!empty($_POST))の終わり
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <link rel="stylesheet" type="text/css" href="../assets/css/login.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/earlyaccess/hannari.css" rel="stylesheet" />
  <meta charset="utf-8">
  <title>ログイン｜和だ</title>
</head>
<body>
  <div class="login-background">
      <div class="row">
        <div class="col-md-offset-4 col-md-4" style="margin-top: 200px;">
          <!--Pulling Awesome Font -->
          <!-- <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"> -->
            <div class="col-md-12">
              <form method="post" action="" class="form-horizontal" role="form">
                <div class="form-login">
                  <h4 style="font-size: 35px;">はじめまして！</h4>
                  <input type="text" id="userName" name = "nick_name" class="form-control input-sm chat-input" placeholder="ユーザー名" />
                  <?php if(isset($errors['nick_name']) && $errors['nick_name'] == 'blank'): ?> <!-- コロン構文 -->
                <p style="color: red; font-size: 10px; margin-top: 2px;">ニックネームを入力してください</p>
                  <?php endif; ?>
                  </br>
                  <input type="email" id="userName" name = "email" class="form-control input-sm chat-input" placeholder="メールアドレス" />
                  </br>
                  <?php if(isset($errors['email']) && $errors['email'] == 'blank'): ?>
                <p style="color: red; font-size: 10px; margin-top: 2px;">メールアドレスを入力してください</p>
                  <?php endif; ?>
                  <?php if(isset($errors['email']) && $errors['email'] == 'duplicate'): ?>
                <p style="color: red; font-size: 10px; margin-top: 2px;">指定のメールアドレスはすでに登録されています</p>
                  <?php endif; ?>
                  <input type="password" id="userPassword" name="password" class="form-control input-sm chat-input" placeholder="パスワード" />
                  </br>
                  <?php if(isset($errors['password']) && $errors['password'] == 'blank'): ?>
                  <p style="color: red; font-size: 10px; margin-top: 2px;">パスワードを入力してください</p>
                  <?php endif; ?>
                  <?php if(isset($errors['password']) && $errors['password'] == 'length'): ?>
                  <p style="color: red; font-size: 10px; margin-top: 2px;">パスワードは4文字以上を入力してください</p>
                  <?php endif; ?>
                  <div class="wrapper">
                    <span class="group-btn">     
                        <input type="submit" class="btn btn-default btn-md" value="確認画面へ"><i class="fa fa-sign-in"></i>
                    </span>
                  </div>

                  <div style="text-align: center; margin-top: 50px;">
                    <a href="../index.php" title="" style="color: black; background-color: rgba(250, 250, 250, 0.2);">トップへ戻る。</a>
                  </div>
                </div>
              </form>
            </div>
        </div>
      </div>
    </div>
  </div>


</body>
</html>