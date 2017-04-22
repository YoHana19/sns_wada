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
$email_check='';
$user_picture_path = '';
$back_picture_path = '';
$self_intro_up = '';
$self_intro_middle = '';
$self_intro_down = '';

$errors = array();

if (!empty($_POST)) {
$nick_name = $_POST['nick_name'];
$email = $_POST['email'];
$user_picture_path = $_POST['user_picture_path'];
$back_picture_path = $_POST['back_picture_path'];
$self_intro_up = $_POST['self_intro_up'];
$self_intro_middle = $_POST['self_intro_middle'];
$self_intro_down = $_POST['self_intro_down'];


// ニックネームとメールアドレスが空だった時
  if ($_POST['nick_name'] == "") {
    $errors['nick_name'] = 'blank';
  }

    if ($_POST['email'] == "") {
      $errors['email'] = 'blank';
    } else {
      // メモ「上記のメールアドレスと一致するかをif文で出すこと!!!」
      if ($_POST['email_check'] != $_POST['email']) {
        $errors['email'] = 'not_match';
      }
    }

// 自己紹介句(上中下) 文字数のエラー表示
  if ($_POST['self_intro_up'] == "") {
    $errors['self_intro_up'] = 'blank';
  }elseif (strlen($_POST['self_intro_up']) <5){ // <4 && >7) {
      echo '4文字以上で入力してください。';
    }elseif(strlen($_POST['self_intro_up']) >7){ // <4 && >7) {
      echo '6文字以下で入力してください。';
    }

      if ($_POST['self_intro_middle'] == "") {
    $errors['self_intro_middle'] = 'blank';
  }elseif (strlen($_POST['self_intro_middle']) <5){
      echo '6文字以上で入力してください。';
    }elseif(strlen($_POST['self_intro_middle']) >9){
      echo '8文字以下で入力してください。';
    }

      if ($_POST['self_intro_down'] == "") {
    $errors['self_intro_down'] = 'blank';
  }elseif (strlen($_POST['self_intro_down']) <5){
      echo '4文字以上で入力してください。';
    }elseif(strlen($_POST['self_intro_down']) >7){
      echo '6文字以下で入力してください。';
    }

// 画像表示のエラー
if(empty($errors)){
  $file_name = $_FILES['user_picture_path'];
if(!empty($file_name)){
  // 画像が選択されていた場合
    $ext = substr($file_name , -3); //substr-文字列の一部分を返す , 後ろから3文字を返す
    $ext = strtolower($ext); // 大文字対応 , strtolower-文字列を小文字にする
    if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
      $errors['user_picture_path'] = 'type';
    }
}else{
  $errors['user_picture_path'] ='blank';
}

if(empty($errors)){
  $file_name = $_FILES['back_picture_path'];
if(!empty($file_name)){
    $ext = substr($file_name , -3);
    $ext = strtolower($ext);
    if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
      $errors['back_picture_path'] = 'type';
    }
}else{
  $errors['back_picture_path'] ='blank';
}
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

// 保留！！！！！
// エラーがなかった場合の処理
  if (empty($errors)) {
    // 画像アップデート処理
    $picture_name = date('YmdHis') . $file_name;
    move_uploaded_file($_FILES['user_picture_path']['tmp_name'] , './assets/images/' . $user_picture_name);
    $_SESSION[''] = $_POST;
    $_SESSION['']['user_picture_path'] =$user_picture_name;
    $_SESSION['']['self_intro'] = $self_intro;
    header('Location: top.php');
    exit();
    }
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
<body>
  <div>
    <label>ニックネーム</label>
    <input type="nick_name" name="nick_name" value="<?php echo $login_member_id['nick_name']; ?>">
    <?php if(isset($errors['nick_name']) && $errors['nick_name'] == 'blank'): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">ニックネームを入力してください</p>
    <?php endif; ?>
  </div>

  <div>
    <label>メールアドレス</label>
    <input type="email" name="email" value="<?php echo $login_member_id['email']; ?>">
    <?php if(isset($errors['email']) && $errors['email'] == 'blank'): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">メールアドレスを入力してください</p>
    <?php endif; ?>
  </div>

  <div>
    <label>メールアドレス確認用</label>
    <input type="email" name="email_check" value="">
    <?php if(isset($errors['email']) && $errors['email'] == 'not_match'): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">メールアドレスを正しく入力してください</p>
    <?php endif; ?>
  </div>

  <div>
    <label>アイコン画像</label>
    <input type="file" name="user_picture_path" value="<?php echo $login_member_id['user_picture_path']; ?>">
    <img src="assets/images/<?php echo $login_member_id['user_picture_path']; ?>" width="100px" height="100px">

    <?php if(isset($login_member_id['user_picture_path']) == 'type'): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">背景画像は「.gif」,「.jpg」,「.png」の画像を指定してください</p>
    <?php endif; ?>
  </div>

  <div>
    <label>背景画像</label>
    <input type="file" name="back_picture_path" value="<?php echo $login_member_id['back_picture_path']; ?>">
    <img src="assets/images/<?php echo $login_member_id['back_picture_path']; ?>" width="300px" height="100px">

    <?php if(isset($login_member_id['back_picture_path']) == 'type'): ?>
      <p style="color:red; font-size:10px; margin-top:2px; ">背景画像は「.gif」,「.jpg」,「.png」の画像を指定してください</p>
    <?php endif; ?>
  </div>

<label>自己紹介句</label>
  <p>上の句</p>
    <input type="" name="self_intro_up" value="<?php echo $login_member_id['self_intro_up']; ?>">
    <?php if(isset($errors['self_intro_up']) && $errors['self_intro_up'] == 'blank'): ?>
  <p style="color:red; font-size:10px; margin-top:2px; ">上の句を入力してください</p>
    <?php endif; ?>

    <?php if(strlen($_POST['self_intro_up']) <5):?>
    <?php else:(strlen($_POST['self_intro_up']) >7) ?>
      <p style="color:red; font-size:10px; margin-top:2px;">文字数は4文字以上6文字以下で設定してください</p>
    <?php endif; ?>

  <p>中の句</p>
    <input type="" name="self_intro_middle" value="<?php echo $login_member_id['self_intro_middle']; ?>">
    <?php if(isset($errors['self_intro_middle']) && $errors['self_intro_middle'] == 'blank'): ?> 
  <p style="color:red; font-size:10px; margin-top:2px; ">中の句を入力してください</p>
    <?php endif; ?>

    <?php if(strlen($_POST['self_intro_middle']) <5):?>
    <?php else:(strlen($_POST['self_intro_middle']) >9) ?>
      <p style="color:red; font-size:10px; margin-top:2px;">文字数は6文字以上8文字以下で設定してください</p>
    <?php endif; ?>

  <p>下の句</p>
    <input type="" name="self_intro_down" value="<?php echo $login_member_id['self_intro_down']; ?>">
    <?php if(isset($errors['self_intro_down']) && $errors['self_intro_down'] == 'blank'): ?> 
  <p style="color:red; font-size:10px; margin-top:2px; ">下の句を入力してください</p>
    <?php endif; ?>

    <?php if(strlen($_POST['self_intro_down']) <5):?>
    <?php else:(strlen($_POST['self_intro_down']) >7) ?>
      <p style="color:red; font-size:10px; margin-top:2px;">文字数は4文字以上6文字以下で設定してください</p>
    <?php endif; ?>

  <div>
    <button type="submit" value="送信">保存</button>
  </div>

</form>
</body>
</html>