<?php
session_start();
require('dbconnect.php');

$_SESSION['login_member_id'] = 1;

$sql = 'SELECT * FROM `members`';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_member = $stmt->fetch(PDO::FETCH_ASSOC);

// $file_name ='hogeuga';
// $user_picture_name='hoge';
// $back_picture_ath = 'moge';
// $self_intro_1 ='アイウエオ';
// $self_intro_2 = 'カキクケコだよ';
// $self_intro_3 = 'さしすせそ';


// バリデーション用
$errors = array();

if (!empty($_POST)) {
  echo $_POST['email'];

  // ニックネームが空だった時
  if ($_POST['nick_name'] == "") {
    $errors['nick_name'] = 'blank';
  }

  // メールアドレスが空だった時
  if ($_POST['email'] == "") {
    $errors['email'] = 'blank';
  } else {
    // メモ「上記のメールアドレスと一致するかをif文で出すこと!!!」
    if ($_POST['email_check'] != $_POST['email']) {
      $errors['email'] = 'not_match';
    }
  }

  // 自己紹介句(上中下) 文字数のエラー表示
  if (!empty($_POST['self_intro_up']) && !empty($_POST['self_intro_middle']) && !empty($_POST['self_intro_down'])) {
    // 上の句
    if (mb_strlen($_POST['self_intro_up']) < 4 || mb_strlen($_POST['self_intro_up']) > 6){
      $errors ['self_intro_up'] = 'length';
    }

    // 中の句
    if (mb_strlen($_POST['self_intro_middle']) < 6 || mb_strlen($_POST['self_intro_middle']) > 8){
      $errors['self_intro_middle'] = 'length';
    }

    // 下の句
    if (mb_strlen($_POST['self_intro_down']) < 4 || mb_strlen($_POST['self_intro_down']) > 6){
      $errors['self_intro_down'] = 'length';
    }
  }

  // 画像表示のエラー
  // アイコン画像
  $user_picture_path = $_FILES['user_picture_path']['name'];
  if (!empty($user_picture_path)) {
    // 画像が選択されていた場合
    echo $user_picture_path;
    $ext = substr($user_picture_path , -3);
    $ext = strtolower($ext);
    if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
      $errors['user_picture_path'] = 'type';
    }
  }

  // 背景画像
  $back_picture_path = $_FILES['back_picture_path']['name'];
  if (!empty($back_picture_path)) {
    // 画像が選択されていた場合
    echo $back_picture_path;
    $ext = substr($back_picture_path , -3);
    $ext = strtolower($ext);
    if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
      $errors['back_picture_path'] = 'type';
    }
  }


    // メールアドレスの重複チェック

    if(empty($errors)){
      // DBのmembersテーブルに入力されたメールアドレスと同じデータがあるかどうか検索し取得
      try{ //例外発生の可能性があるコード
           $sql = 'SELECT COUNT(*) AS `cnt` FROM `members` WHERE `email` =?'; //COUNT-変数に含まれる全ての要素、あるいはオブジェクトに含まれる何かの数を数える
           $data =array($_POST['email']);
           $stmt = $dbh->prepare($sql);
           $stmt->execute($data);
           $record = $stmt->fetch(PDO::FETCH_ASSOC);
           var_dump($record);
           if($record['cnt']>0){
            if ($login_member['email'] != $_POST['email']) {
             // ログインユーザーのメアドと同じでない場合、重複 = ログインユーザーのメアドでログインした時エラー表示なし
            // 同じメールアドレスがDB内に存在したため
              $errors['email'] = 'duplicate'; //duplicate-重複
           }
}
      }catch(PDOException $e){ //例外発生時の処理
          echo 'SQL文実行時エラー:' . $e->message();
      }
    }

// 保留！！！！！
// エラーがなかった場合の処理
  // var_dump($errors);


    // 画像アップデート処理
if (empty($errors)) {
    $picture_name = date('YmdHis') . $file_name;
    move_uploaded_file($_FILES['user_picture_path']['tmp_name'] , '/assets/images/' . $user_picture_name);
    move_uploaded_file($_FILES['back_picture_path']['tmp_name'] , '/assets/images/' . $back_picture_name);
    // $_SESSION[''] = $_POST;
    // $_SESSION['nick_name'] = $_POST['nick_name'];
    // $_SESSION['user_picture_path'] =$user_picture_name;
    // $_SESSION['back_picture_path'] =$back_picture_name;
    // $_SESSION['self_intro_1'] = $self_intro_1;
    // $_SESSION['self_intro_2'] = $self_intro_2;
    // $_SESSION['self_intro_3'] = $self_intro_3;
    $_SESSION['nick_name'] = $_POST['nick_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['user_picture_path'] = $_FILES['user_picture_path']['name'];
    $_SESSION['back_picture_path'] = $_FILES['back_picture_path']['name'];
    $_SESSION['self_intro_up'] = $_POST['self_intro_up'];
    $_SESSION['self_intro_middle'] = $_POST['self_intro_middle'];
    $_SESSION['self_intro_down'] = $_POST['self_intro_down'];


    // $_POST['errors'] = $errors;
    header('Location:edit-update.php');
    exit();
    // echo '<pre>';
    // var_dump($_POST);
    // echo '<pre>';
  }

}
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title></title>
  <meta charset="utf-8">
</head>
<body>
  <form method="POST" action="edit.php" enctype="multipart/form-data">
    <div>
      <label>ニックネーム</label>
      <input type="text" name="nick_name" value="<?php echo $login_member['nick_name']; ?>">
      <?php if(isset($errors['nick_name']) && $errors['nick_name'] == 'blank'): ?>
        <p style="color:red; font-size:10px; margin-top:2px; ">ニックネームを入力してください</p>
      <?php endif; ?>
    </div>

    <div>
      <label>メールアドレス</label>
      <input type="email" name="email" value="<?php echo $login_member['email']; ?>">
      <?php if(isset($errors['email']) && $errors['email'] == 'blank'): ?>
        <p style="color:red; font-size:10px; margin-top:2px; ">メールアドレスを入力してください</p>
      <?php endif; ?>

      <?php if(isset($errors['email']) && $errors['email'] == 'duplicate'): ?>
        <p style="color:red; font-size:10px; margin-top:2px; ">指定したメールアドレスはすでに登録されています。</p>
      <?php endif; ?>
    </div>

    <div>
      <label>メールアドレス確認用</label>
      <input type="email" name="email_check" value="">
      <?php if(isset($errors['email']) && $errors['email'] && $errors['email'] == 'not_match'): ?>
        <p style="color:red; font-size:10px; margin-top:2px; ">メールアドレスを正しく入力してください</p>
      <?php endif; ?>
    </div>

    <div>
      <label>アイコン画像</label>
      <input type="file" name="user_picture_path">
      <img src="assets/images/<?php echo $login_member['user_picture_path']; ?>" width="100px" height="100px">

      <?php if(isset($errors['user_picture_path']) && $errors['user_picture_path'] == 'type') : ?>
        <p style="color:red; font-size:10px; margin-top:2px; ">アイコン画像は「.gif」,「.jpg」,「.png」の画像を指定してください</p>
      <?php endif; ?>
    </div>

    <div>
      <label>背景画像</label>
      <input type="file" name="back_picture_path">
      <img src="assets/images/<?php echo $login_member['back_picture_path']; ?>" width="300px" height="200px">

      <?php if(isset($errors['back_picture_path']) && $errors['back_picture_path'] == 'type'): ?>
        <p style="color:red; font-size:10px; margin-top:2px; ">背景画像は「.gif」,「.jpg」,「.png」の画像を指定してください</p>
      <?php endif; ?>
    </div>

  <label>自己紹介句</label>
    <p>上の句</p>
      <input type="text" name="self_intro_up" value="<?php echo $login_member['self_intro_1'] ; ?>">
      <?php if(isset($errors['self_intro_up']) && $errors['self_intro_up'] == 'length'): ?>
        <p style="color:red; font-size:10px; margin-top:2px;">文字数は4文字以上6文字以下で設定してください</p>
      <?php endif; ?>

    <p>中の句</p>
      <input type="text" name="self_intro_middle" value="<?php echo $login_member['self_intro_2']; ?>">
      <?php if(isset($errors['self_intro_middle']) && $errors['self_intro_middle'] == 'length'): ?>
        <p style="color:red; font-size:10px; margin-top:2px;">文字数は6文字以上8文字以下で設定してください</p>
      <?php endif; ?>

    <p>下の句</p>
      <input type="text" name="self_intro_down" value="<?php echo $login_member['self_intro_3']; ?>">
      <?php if(isset($errors['self_intro_down']) && $errors['self_intro_down'] == 'length'): ?>
        <p style="color:red; font-size:10px; margin-top:2px;">文字数は4文字以上6文字以下で設定してください</p>
      <?php endif; ?>

    <div>
      <button type="submit" value="送信">保存</button>
    </div>
  </form>
</body>
</html>