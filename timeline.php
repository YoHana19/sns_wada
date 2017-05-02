<?php
session_start();
require('dbconnect.php');

$_SESSION['login_member_id'] = 1;
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <title></title>
  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> -->

  <!-- <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'> -->
  <link rel="stylesheet" type="text/css" href="assets/css/mw_haiku_input.css">
  <!-- For Modal Window -->
  <link rel="stylesheet" type="text/css" href="assets/css/modal_window.css">
</head>
<body>
  <!-- 詠むボタン -->
  <input type="submit" id="modal-open" class="btn btn-info" value="詠む" >

  <!-- LOGIN FORM -->
  <div id="modal-content_1" class="content">
    <div class="text-center"">
      <div class="logo">
        <img src="assets/images/yomu.png">
      </div>
      <!-- Main Form -->
      <div class="login-form-1">
        <form action="send_haiku.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="login-form-main-message"></div>
          <div class="main-login-form">
            <div class="login-group">
              <!-- 上の句 -->
              <div class="form-group">
                <label for="up_haiku" class="sr-only">Username</label>
                <input type="text" class="form-control haiku" id="up_haiku" name="up_haiku" placeholder="壱行目（四〜六文字）">
                <p id="up_haiku_valid" class="haiku-input-err" style="display: none">四から六文字で入力してください</p>
              </div>
              <!-- 中の句 -->
              <div class="form-group">
                <label for="md_haiku" class="sr-only">Username</label>
                <input type="text" class="form-control haiku" id="md_haiku" name="md_haiku" placeholder="弐行目（六〜八文字）">
                <p id="md_haiku_valid" class="haiku-input-err" style="display: none">六から八文字で入力してください</p>
              </div>
              <!-- 下の句 -->
              <div class="form-group">
                <label for="lw_haiku" class="sr-only">Username</label>
                <input type="text" class="form-control haiku" id="lw_haiku" name="lw_haiku" placeholder="参行目（四〜六文字）">
                <p id="lw_haiku_valid" class="haiku-input-err" style="display: none">四から六文字で入力してください</p>
              </div>

              <!-- 一言説明 -->
              <div class="form-group" style="margin-top: 15px;">
                <label for="short_comment" class="sr-only">Username</label>
                <input type="text" class="form-control" id="short_comment" name="short_comment" placeholder="一言説明（二十文字以下）">
                <p id="short_comment_valid" class="haiku-input-err" style="display: none">二十文字以内で入力してください</p>
              </div>

              <!-- 画像送信 -->
              <div class="form-group" style="margin-top: 15px; position: relative; padding-right: 0;">
                <input type="file" id="photo_file" name="photo_file" style="display:none;" onchange="changePhotoFile();">
                <img id="photo_img" src="assets/images/photo_submit.png" alt="参照" class="img-submit">
                <input id="photo_display" type="text" name="photo_display" value="" size="25" style="margin-left: 15px">
              </div>
            </div>

            <!-- 詠むボタン -->
            <div id="yomu">
              <button type="button" id="yomu_pre" class="login-button" style="font-size: 16px;">詠</button>
              <input id="yomu_ready" type="submit" class="login-button" value="詠" style="font-size: 16px; background-color: #f8b862; color: #ffffff; display: none;">
            </div>
          </div>
        </form>
      </div>
      <!-- end:Main Form -->

      <!-- 戻るボタン -->
      <div style="text-align: right;">
        <button type="button" id="modal-close" class="btn btn-info input-back">戻る</button>
      </div>
    </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script> -->

  <!-- jQuery (necessary for Modal Window) -->
  <script src="assets/js/modal_window.js"></script>

  <!-- 俳句入力バリデーション -->
  <script src="assets/js/haiku_input.js"></script>

  <script>
    // 1番最初のモーダルウィンドウ呼び出し
    modalWindowOnFirst('modal-open');

    // 2番目のモーダルウィンドウ呼び出し
    // modalWindowOn('modal-check', 'modal-content_1', 'modal-content_2');

    // モーダルウィンドウの終了
    modalWindowOff('modal-close', 'modal-content_1');

    //リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
    $(window).resize(centeringModalSyncer);
  </script>

</body>
</html>