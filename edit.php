<?php
session_start();
require('dbconnect.php');
require('function.php');

// 画像変更時の処理
if (!empty($_FILES)) {
  $picture_name = '';
  // 背景画像
  if (isset($_FILES['back-img-file']['name']) && !empty($_FILES['back-img-file']['name'])) {
    // 画像アップロード処理
    $picture_name = date('YmdHis') . $_FILES['back-img-file']['name'];
    // 20170308152500hogehoge.jpg←画像ファイル名作成
    move_uploaded_file($_FILES['back-img-file']['tmp_name'], 'assets/images/users/' . $picture_name);

    // DBの更新
    $sql = 'UPDATE `members` SET `back_picture_path`=? WHERE `member_id`=?';
    $data = array($picture_name, $_SESSION['login_member_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
  }

  // プロフ画像
  if (isset($_FILES['profile-img-file']['name']) && !empty($_FILES['profile-img-file']['name'])) {
    // 画像アップロード処理
    $picture_name = date('YmdHis') . $_FILES['profile-img-file']['name'];
    // 20170308152500hogehoge.jpg←画像ファイル名作成
    move_uploaded_file($_FILES['profile-img-file']['tmp_name'], 'assets/images/users/' . $picture_name);

    // DBの更新
    $sql = 'UPDATE `members` SET `user_picture_path`=? WHERE `member_id`=?';
    $data = array($picture_name, $_SESSION['login_member_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
  }
}

$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_member = $stmt->fetch(PDO::FETCH_ASSOC);


// 各種バリデーション
$errors = array();

if (!empty($_POST)) {
  // ニックネーム空チェック
  if ($_POST['nick_name'] == "") {
    $errors['nick_name'] = 'blank';
  }

  // メアド空チェック
  if ($_POST['email'] == "") {
    $errors['email'] = 'blank';
  } else {
    // メアド確認用と一致チェック
    if ($_POST['email_check'] != $_POST['email']) {
      $errors['email'] = 'not_match';
    }
  }

  // 自己紹介句の文字数チェック
  if (!empty($_POST['self_intro_1']) || !empty($_POST['self_intro_2']) || !empty($_POST['self_intro_3'])) {

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


  if(empty($errors)){
    try {
      // メアド重複チェック
      $sql = 'SELECT COUNT(*) AS `cnt` FROM `members` WHERE `email` =?';
      $data =array($_POST['email']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $record = $stmt->fetch(PDO::FETCH_ASSOC);
      if($record['cnt']>0){
        if ($login_member['email'] != $_POST['email']) {
          $errors['email'] = 'duplicate';
        }
      }
    } catch(PDOException $e) {
      echo 'SQL文実行時エラー:' . $e->message();
    }
  }

  if (empty($errors)) {

    $_SESSION['nick_name'] = $_POST['nick_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['self_intro_1'] = $_POST['self_intro_1'];
    $_SESSION['self_intro_2'] = $_POST['self_intro_2'];
    $_SESSION['self_intro_3'] = $_POST['self_intro_3'];

    header('Location:edit_update.php');
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
  <!-- for Bootstrap -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
  <!-- For Modal Window -->
  <link rel="stylesheet" type="text/css" href="assets/css/mw_haiku_input.css">
  <!-- 全ページ共通 -->
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- 各ページ -->
  <link rel="stylesheet" type="text/css" href="assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" href="assets/css/user.css">
</head>
<body>

  <!-- ヘッダー -->
  <?php require('header.php'); ?>

  <!--プロフィール写真/ 一言-->
  <div class="container whole-content">
    <form method="POST" action="edit.php" enctype="multipart/form-data">
      <div class="fb-profile">
        <input type="file" id="back-img-file" name="back-img-file" style="display:none;" onchange="$('#back-img-submit').click();" accept="image/*">
        <input type="submit" id="back-img-submit" style="display: none;">
        <div id="edit-back-img" class="fb-image-lg" style="width: 100%; height: 400px; background-image: url(assets/images/users/<?php echo $login_member['back_picture_path'] ?>);" onclick="$('#back-img-file').click();">
          <span class="intro-text-3"><?php echo tateGaki($login_member['self_intro_3']); ?></span>
          <span class="intro-text-2"><?php echo tateGaki($login_member['self_intro_2']); ?></span>
          <span class="intro-text-1"><?php echo tateGaki($login_member['self_intro_1']); ?></span>
          <img src="assets/images/source/edit_msg.png" id="edit-back-img-msg">
        </div>
        <div id="edit-profile-img" align="left" class="fb-image-profile thumbnail" onclick="$('#profile-img-file').click();">
          <img src="assets/images/users/<?php echo $login_member['user_picture_path']; ?>" alt="Profile image example">
          <img src="assets/images/source/edit_msg.png" id="edit-profile-img-msg">
        </div>
        <input type="file" id="profile-img-file" name="profile-img-file" style="display:none;" onchange="$('#profile-img-submit').click();" accept="image/*">
        <input type="submit" id="profile-img-submit" style="display: none;">
        <div class="fb-profile-text-ed">
          <h1><?php echo $login_member['nick_name']; ?></h1>
        </div>
      </div>
    </form>
  </div>

  <div class="container">
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
                <input id="UID" name="email_check" placeholder="" class="form-control input-md" type="email" required="">
                <?php if(isset($errors['email']) && $errors['email'] == 'not_match'): ?>
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

            <div class="form-group" style="padding-top:70px; padding-bottom:80px; padding-left:180px;">
              <label class="col-md-4 control-label" for="btn_continuar"></label>
              <div class="col-md-8">
                <button id="btn_continuar" value="送信" class="btn btn-danger">保存</button>
              </div>
            </div>

          </fieldset>
        </form>
      </div>
  </div>
  <!-- フッター -->
  <?php require('footer.php'); ?>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/friend.js"></script>
  <script src="assets/js/likes.js"></script>
  <script src="assets/js/dislikes.js"></script>
  <script src="assets/js/comment.js"></script>
  <script src="assets/js/edit_profile_images.js"></script>
</body>
</html>