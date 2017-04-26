<?php
session_start();
require('dbconnect.php');

$_SESSION['login_member_id'] = 1;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
    <!-- For Modal Window -->
    <link rel="stylesheet" type="text/css" href="assets/css/modal_window.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
</head>
<body>

  <!-- 詠むボタン（MWの呼び出し） -->
  <input type="submit" id="modal-open" class="btn btn-info" value="詠む" style="background-color: #00a381;">

  <!-- 句入力フォーム -->
  <div id="modal-content_1" class="content">
    <form action="send_haiku.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
      <!-- 句入力 -->
      <input type="text" class="form-control haiku" id="up_haiku" name="up_haiku" placeholder="１行目（四〜六文字）"><br>
      <p id="up_haiku_valid" style="display: none">四から六文字で入力してください</p>
      
      <input type="text" class="form-control haiku" id="md_haiku" name="md_haiku" placeholder="２行目（四〜六文字）"><br>
      <p id="md_haiku_valid" style="display: none">六から八文字で入力してください</p>
      
      <input type="text" class="form-control haiku" id="lw_haiku" name="lw_haiku" placeholder="３行目（四〜六文字）"><br>
      <p id="lw_haiku_valid" style="display: none">四から六文字で入力してください</p>

      <!-- 一言説明 -->
      <input type="text" class="form-control" id="short_comment" name="short_comment" placeholder="一言説明（二十文字以下）"><br>
      <p id="short_comment_valid" style="display: none">二十文字以内で入力してください</p>

      <!-- 写真挿入 -->
      <div>
        <input type="file" id="photo_file" name="photo_file" style="display:none;" onchange="changePhotoFile();">
        <img id="photo_img" src="assets/images/photo_submit.png" alt="参照" width="30px" height="30px">
        <input id="photo_display" type="text" name="photo_display" value="" size="50">
      </div>

      <!-- 詠むボタン -->
      <div id="yomu">
        <button type="button" id="yomu_pre" class="btn btn-info" style="background-color: #c8c2c6; border-color: #c8c2c6;">詠む</button>
        <input id="yomu_ready" type="submit" class="btn btn-info" value="詠む" style="background-color: #00a381; display: none;">
      </div>

      <!-- 戻るボタン -->
      <div>
        <button type="button" id="modal-close" class="btn btn-info" style="background-color: #c8c2c6; border-color: #c8c2c6;">戻る</button>
      </div>
    </form>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <!-- jQuery (necessary for Modal Window) -->
  <script src="assets/js/modal_window.js"></script>
  <script src="assets/js/haiku_input.js"></script>

  <script>
    // 1番最初のモーダルウィンドウ呼び出し
    modalWindowOnFirst('modal-open');

    // 2番目のモーダルウィンドウ呼び出し
    // modalWindowOn('modal-check', 'modal-content_1', 'modal-content_2');

    // モーダルウィンドウの終了
    // modalWindowOff('modal-close', 'modal-content_2');

    //リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
    $(window).resize(centeringModalSyncer);
  </script>

</body>
</html>