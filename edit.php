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

// 空だった時
  if ($_POST['nick_name'] == "") {
    $errors['nick_name'] = 'blank';
  }

    if ($_POST['email'] == "") {
    $errors['email'] = 'blank';
  }

// メモ「上記のメールアドレスと一致するかをif文で出すこと!!!」
    if ($_POST['email_check'] != $_POST['email']) {
    $errors['email'] = 'not_match';
  }

if(empty($errors)){
// 画像のバリエーション
  $file_name = $_FILES['user_picture_path']['name'];
}

if(empty($errors)){
// 画像のバリエーション
  $file_name = $_FILES['back_picture_path']['name'];
}

    // メールアドレスの重複チェック
    if(empty($errors)){
      // DBのmembersテーブルに入力されたメールアドレスと同じデータがあるかどうか検索し取得
      try{
           $sql = 'SELECT COUNT(*) AS `cnt` FROM `members` WHERE `email` =?'; //COUNT-変数に含まれる全ての要素、あるいはオブジェクトに含まれる何かの数を数える
           $data =array($email);
           $stmt = $dbh->prepare($sql);
           $stmt->execute($data);
           $record = $stmt->fetch(PDO::FETCH_ASSOC);
           var_dump($record);
           if($record['cnt']>0){
            // 同じメールアドレスがDB内に存在したため
              $errors['email'] = 'duplicate'; //duplicate-重複
           }

      }catch(PDOException $e){
          echo 'SQL文実行時エラー:' . $e->message();
      }
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
    <?php if(isset($errors['nick_name']) && $errors['nick_name'] == 'blank'): ?> <!-- コロン構文 -->
      <p style="color:red; font-size:10px; margin-top:2px; ">ニックネームを入力してください</p>
    <?php endif; ?>
  </div>


  <div>
    <label>メールアドレス</label>
    <input type="email" name="email" value="<?php echo $login_member_id['email']; ?>">
        <?php if(isset($errors['email']) && $errors['email'] == 'blank'): ?> <!-- コロン構文 -->
      <p style="color:red; font-size:10px; margin-top:2px; ">メールアドレスを入力してください</p>
    <?php endif; ?>
  </div>


  <div>
    <label>メールアドレス確認用</label>
    <input type="email" name="email" value="">
    <?php if(isset($errors['email']) && $errors['email'] == 'blank' && $errors['email'] != $errors['email']): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">メールアドレスを正しく入力してください</p>
    <?php endif; ?>
  </div>


  <div>
    <label>アイコン画像</label>
    <input type="file" name="user_picture_path" value="<?php echo $login_member_id['user_picture_path']; ?>">
    <?php if(isset($errors['user_picture_path']) && $errors['user_picture_path'] == 'blank'): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">アイコン画像を選択してください</p>
    <?php endif; ?>
  </div>

    <?php if(isset($errors['user_picture_path']) && $errors['user_picture_path'] == 'type'): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">アイコン画像は「.gif」,「.jpg」,「.png」の画像を指定してください</p>
    <?php endif; ?>

    <?php if(!empty($errors)): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">アイコン画像を再度指定してください。</p>
    <?php endif; ?>


  <div>
    <label>背景画像</label>
    <input type="file" name="back_picture_path" value="<?php echo $login_member_id['back_picture_path']; ?>">
    <?php if(isset($errors['back_picture_path']) && $errors['back_picture_path'] == 'blank'): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">背景画像を選択してください</p>
    <?php endif; ?>

    <?php if(isset($errors['back_picture_path']) && $errors['back_picture_path'] == 'type'): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">背景画像は「.gif」,「.jpg」,「.png」の画像を指定してください</p>
    <?php endif; ?>

    <?php if(!empty($errors)): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">背景画像を再度指定してください。</p>
    <?php endif; ?>

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