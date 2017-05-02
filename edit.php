<?php
session_start();
require('dbconnect.php');

$_SESSION['login_member_id'] = 1;

$sql = 'SELECT * FROM `members`';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_member = $stmt->fetch(PDO::FETCH_ASSOC);

$errors = array();

if (!empty($_POST)) {
  echo $_POST['email'];

  if ($_POST['nick_name'] == "") {
    $errors['nick_name'] = 'blank';
  }

  if ($_POST['email'] == "") {
    $errors['email'] = 'blank';
  } else {
    if ($_POST['email_check'] != $_POST['email']) {
      $errors['email'] = 'not_match';
    }
  }

  if (!empty($_POST['self_intro_1']) && !empty($_POST['self_intro_2']) && !empty($_POST['self_intro_3'])) {

    if (mb_strlen($_POST['self_intro_1']) < 4 || mb_strlen($_POST['self_intro_1']) > 6){
      $errors ['self_intro_1'] = 'length';
    }

    if (mb_strlen($_POST['self_intro_2']) < 6 || mb_strlen($_POST['self_intro_2']) > 8){
      $errors['self_intro_2'] = 'length';
    }

    if (mb_strlen($_POST['self_intro_3']) < 4 || mb_strlen($_POST['self_intro_3']) > 6){
      $errors['self_intro_3'] = 'length';
    }
  }

  $user_picture_path = $_FILES['user_picture_path']['name'];
  if (!empty($user_picture_path)) {
    echo $user_picture_path;
    $ext = substr($user_picture_path , -3);
    $ext = strtolower($ext);
    if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif' && $ext !='jpg') {
      $errors['user_picture_path'] = 'type';
    }
}

  $back_picture_path = $_FILES['back_picture_path']['name'];
  if (!empty($back_picture_path)) {
    echo $back_picture_path;
    $ext = substr($back_picture_path , -3);
    $ext = strtolower($ext);
    if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif' && $ext !='jpg') {
      $errors['back_picture_path'] = 'type';
    }
  }

    if(empty($errors)){
      try{
           $sql = 'SELECT COUNT(*) AS `cnt` FROM `members` WHERE `email` =?';
           $data =array($_POST['email']);
           $stmt = $dbh->prepare($sql);
           $stmt->execute($data);
           $record = $stmt->fetch(PDO::FETCH_ASSOC);
           var_dump($record);
           if($record['cnt']>0){
            if ($login_member['email'] != $_POST['email']) {
              $errors['email'] = 'duplicate';
           }
}
      }catch(PDOException $e){
          echo 'SQL文実行時エラー:' . $e->message();
      }
    }

if (empty($errors)) {
    $user_picture_name = date('YmdHis') . $user_picture_path;
    $back_picture_name = date('YmdHis') . $back_picture_path;
    move_uploaded_file($_FILES['user_picture_path']['tmp_name'] , 'assets/images/' . $user_picture_name);
    move_uploaded_file($_FILES['back_picture_path']['tmp_name'] , 'assets/images/' . $back_picture_name);
    // $_SESSION[''] = $_POST;
    // $_SESSION['nick_name'] = $_POST['nick_name'];
    // $_SESSION['user_picture_path'] =$user_picture_name;
    // $_SESSION['back_picture_path'] =$back_picture_name;
    // $_SESSION['self_intro_1'] = $self_intro_1;
    // $_SESSION['self_intro_2'] = $self_intro_2;
    // $_SESSION['self_intro_3'] = $self_intro_3;
    $_SESSION['nick_name'] = $_POST['nick_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['user_picture_path'] = $user_picture_name;
    $_SESSION['back_picture_path'] = $back_picture_name;
    $_SESSION['self_intro_1'] = $_POST['self_intro_1'];
    $_SESSION['self_intro_2'] = $_POST['self_intro_2'];
    $_SESSION['self_intro_3'] = $_POST['self_intro_3'];


    // $_POST['errors'] = $errors;
    header('Location:edit-update.php');
    exit();
  }
}

// 縦書きにする関数
function tateGaki($haiku) {
  $matches = preg_split("//u", $haiku, -1, PREG_SPLIT_NO_EMPTY);
  $v_haiku = '';
  foreach ($matches as $letter) {
    $v_haiku .= $letter . "<br>";
  }
  return rtrim($v_haiku, "<br>");
}
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" href="assets/css/left_sideber.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <link rel="stylesheet" type="text/css" href="assets/css/user.css">
  <link rel="stylesheet" type="text/css" href="assets/css/edit.css">
</head>
<body>

  <div class="container content">
    <div class="fb-profile">
      <div class="fb-image-lg" style="background-image: url(assets/images/<?php echo $login_member['back_picture_path']; ?>);  width: 100%; height: 450px;">
        <span class="intro-text-1"><?php echo tateGaki($login_member['self_intro_1']); ?></span>
        <span class="intro-text-2"><?php echo tateGaki($login_member['self_intro_2']);?></span>
        <span class="intro-text-3"><?php echo tateGaki($login_member['self_intro_3']);?></span>
      </div>
      <img align="left" class ="fb-image-profile thumbnail" src="assets/images/<?php echo $login_member['user_picture_path']; ?>" alt="Profile image example" style="width:300px; height:300px; margin-top:-200px; margin-left:100px;">
      <div class="fb-profile-text">
        <h1 style="margin-top:10px;"><?php echo $login_member['nick_name']; ?></h1>
      </div>
    </div>
  </div>

  <div class="container content">
      <div class="row">
        <form method="POST" action="edit.php" enctype="multipart/form-data" class="form-horizontal">
          <fieldset>

            <div class="form-group" style="padding-top:80px; padding-bottom:10px;">
              <label class="col-md-4 control-label">ニックネーム</label>
              <div class="col-md-4">
                <input id="nick_name" name="nick_name" placeholder="" class="form-control input-md" required="" value="<?php echo $login_member['nick_name']; ?>">
                <?php if(isset($errors['nick_name']) && $errors['nick_name'] == 'blank'):?>
                  <p style="color:red; font-size:10px; margin-top:2px; ">ニックネームを入力してください</p>
                <?php endif;?>
              </div>
            </div>

            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label" for="UID">メールアドレス</label>
              <div class="col-md-4">
                <input id="UID" name="email" placeholder="" class="form-control input-md" required="" value="<?php echo $login_member['email']; ?>">
                <?php if(isset($errors['email']) && $errors['email'] == 'blank'): ?>
                  <p style="color:red; font-size:10px; margin-top:2px; ">メールアドレスを入力してください</p>
                <?php endif; ?>
                <?php if(isset($errors['email']) && $errors['email'] == 'duplicate'): ?>
                  <p style="color:red; font-size:10px; margin-top:2px; ">指定したメールアドレスはすでに登録されています。</p>
                <?php endif; ?>
              </div>
            </div>

            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label" for="UID">メールアドレス(確認用)</label>
              <div class="col-md-4">
                <input id="UID" name="email_check" placeholder="" class="form-control input-md" type="email" required="" value="<?php echo $login_member['email']; ?>">
                <?php if(isset($errors['email']) && $errors['email'] && $errors['email'] == 'not_match'): ?>
                  <p style="color:red; font-size:10px; margin-top:2px; ">メールアドレスを正しく入力してください</p>
                <?php endif; ?>
              </div>
            </div>

            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label" for="comentario">(自己紹介句)上の句</label>
              <div class="col-md-4">
                <input class="form-control" id="coment" name="self_intro_1" value="<?php echo $login_member['self_intro_1'] ; ?>">
                <?php if(isset($errors['self_intro_1']) && $errors['self_intro_1'] == 'length'): ?>
                  <p style="color:red; font-size:10px; margin-top:2px;">文字数は4文字以上6文字以下で設定してください</p>
                <?php endif; ?>
              </div>
            </div>

            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label" for="comentario">中の句</label>
              <div class="col-md-4">
                <input class="form-control" id="coment" name="self_intro_2" value="<?php echo $login_member['self_intro_2']; ?>">
                <?php if(isset($errors['self_intro_2']) && $errors['self_intro_2'] == 'length'): ?>
                  <p style="color:red; font-size:10px; margin-top:2px;">文字数は6文字以上8文字以下で設定してください</p>
                <?php endif; ?>
              </div>
            </div>

            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label" for="comentario">下の句</label>
              <div class="col-md-4">
                <input class="form-control" id="coment" name="self_intro_3" value="<?php echo $login_member['self_intro_3']; ?>">
                <?php if(isset($errors['self_intro_3']) && $errors['self_intro_3'] == 'length'): ?>
                  <p style="color:red; font-size:10px; margin-top:2px;">文字数は4文字以上6文字以下で設定してください</p>
                <?php endif; ?>
              </div>
            </div>

            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label">アイコン画像</label>
              <input type="file" name="user_picture_path" required="" style="margin-left:480px;">
            <div class="fb-profile-text">
              <?php if(isset($errors['user_picture_path']) && $errors['user_picture_path'] == 'type') : ?>
                <p style="color:red; font-size:10px; margin-top:2px; margin-left:300px  ">アイコン画像は「.gif」,「.jpg」,「.png」, 「.jpeg」の画像を指定してください</p>
              <?php endif; ?>
            </div>

            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label">背景画像</label>
              <input type="file" name="back_picture_path" required="" style="margin-left:495px;">
            <div class="fb-profile-text">
              <?php if(isset($errors['back_picture_path']) && $errors['back_picture_path'] == 'type'): ?>
                <p style="color:red; font-size:10px; margin-top:2px; margin-left:300px ">背景画像は「.gif」,「.jpg」,「.png」,「.jpeg」の画像を指定してください</p>
              <?php endif; ?>
            </div>

            <div class="form-group" style="padding-top:70px; padding-bottom:80px; padding-left:220px;">
              <label class="col-md-4 control-label" for="btn_continuar"></label>
              <div class="col-md-8">
                <button id  ="btn_continuar" value="送信" class="btn btn-danger">保存</button>
              </div>
            </div>

          </fieldset>
        </form>
      </div>
  </div>
</body>
</html>