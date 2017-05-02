<?php
require('dbconnect.php');

$sql = 'SELECT * FROM `friends` AS f LEFT JOIN `members` AS m ON f.friend_member_id=m.member_id WHERE f.friend_member_id=? AND f.state=0 ORDER BY m.nick_name';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$requests = array();
while ($request = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $requests[] = $request;
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <nav class="navbar navbar-webmaster" style="width:'auto'; height: 80px">
    <div class=""></div>
    <div class="header-bk">
      <div class="navbar-header">
        <a class="navbar-brand" href="timeline.php">和だ</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="nav navbar-nav navbar-right">
          <!-- 友達リクエスト -->
          <li class="active click request_button"><a><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
          <!-- プロフページ -->
          <li class="active click"><a href="profile.php"><i class="fa fa-user fa-2x" aria-hidden="true"></i></i><i class="fa fa-user-circle-o" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
          <!-- チャットページ -->
          <li class="active click"><a href="chat.php"><i class="fa fa-comments fa-2x" aria-hidden="true"></i></i><span class="sr-only">(current)</span></a></li>
          <!-- 友達一覧ページ -->
          <li class="active click"><a href="friends.php"><i class="fa fa-users fa-2x" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
          <!-- ランキングページ -->
          <li class="active click"><a href="ranking.php"><i class="fa fa-sort-numeric-asc fa-2x" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
          <!-- ログアウト -->
          <li id="logout" class=""><a href="logout.php" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a></li></a></li>

          <form class="navbar-form navbar-right search-form form-horizontal" role="search">
            <!-- 検索フォーム -->
            <div id="custom-search-input">
              <div class="input-group">
                <input type="text" class="search-query form-control" placeholder="search">
                  <span class="input-group-btn">
                    <button class="btn btn-danger" type="button">
                      <span class="glyphicon glyphicon-search" style="color: #dcdddd"></span>
                    </button>
                  </span>
              </div>
              <input type="button" id="modal-open" class="btn btn-info haiku-input" value="詠む">
            </div>
          </form>
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- 友達リクエスト一覧 -->
  <div id="requests" class="requests_display">
    <div class="well_3">
      <?php foreach ($rooms as $room) { ?>
        <div class="media" style="position: relative; margin-top: 7px">
          <a class="pull-left left-photo" href="#">
            <img class="media-object" src="assets/images/<?php echo $room['user_picture_path']; ?>" style="width: 55px; height: 55px; border-radius: 50%">
          </a>
        <div class="media-body left-display">
          <span class="media-heading left-nickname"><?php echo $room['nick_name'];?></span>
          <p class="left-intro"><?php echo $login_member['self_intro_1'];?>&nbsp;<?php echo $login_member['self_intro_2'];?>&nbsp;<?php echo $login_member['self_intro_3'];?></p>
        </div>
      </div>
    <?php } ?>
  </div>

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