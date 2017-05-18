<?php 
require('dbconnect.php');

// ページ名の取得
$file_name = getFileNameFromUri();

if ($file_name == 'user.php') {
  $key_id = $_REQUEST['user_id'];
} else {
  $key_id = $_SESSION['login_member_id'];
}

// roomsテーブルから新着チャットを10件取得
$sql = 'SELECT * FROM `rooms` WHERE `member_id_1`=? OR `member_id_2`=? ORDER BY modified DESC LIMIT 0, 10';
$data = array($key_id, $key_id);
$room_stmt = $dbh->prepare($sql);
$room_stmt->execute($data);

// 各チャットの友達情報を取得
$rooms = array();
while ($record = $room_stmt->fetch(PDO::FETCH_ASSOC)) {
  if ($record['member_id_1'] == $key_id) {
    $sql = 'SELECT * FROM `members` WHERE member_id = ?';
    $data = array($record['member_id_2']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
  } else {
    $sql = 'SELECT * FROM `members` WHERE member_id = ?';
    $data = array($record['member_id_1']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  $rooms[] = $room;
}
?>


<!-- ** -->
<!-- htmlコンテンツ -->
<!-- ** -->

<!-- タイムラインページorランキングページだったら -->
<?php if($file_name == 'timeline.php' || $file_name == 'ranking.php'): ?>

  <!-- 簡易個人プロフ -->
  <div class="left-profile">
    <div style="position: relative; display:inline-block;">
      <img src="assets/images/users/<?php echo $login_member['user_picture_path']; ?>">
      <!-- 分岐MW表示時のoverlay -->
      <div class="modal-overlay-left-bar"></div>
    </div>
    <h3><?php echo $login_member['nick_name'];?></h3>
    <span class="intro-text-3"><?php echo tateGaki($login_member['self_intro_1']); ?></span>
    <span class="intro-text-2"><?php echo tateGaki($login_member['self_intro_2']); ?></span>
    <span class="intro-text-1"><?php echo tateGaki($login_member['self_intro_3']); ?></span>
  </div>
  <div class="clearfix"></div>

<?php endif; ?>

<div class="friends-display">
  <!-- タイトル表示 -->
  <div class="friends-title">
    <span class="title">お仲間</span>
  </div>

  <!-- 直近連絡とった友達順に10件表示 -->
  <div class="left-wrap">
    <?php foreach ($rooms as $room) { ?>

      <!-- 他人ページだったら -->
      <?php if($file_name == 'user.php'): ?>
        <div class="media" style="position: relative; margin-top: 7px">
          <a class="pull-left left-photo" href="user.php?user_id=<?php echo $room['member_id'] ?>">
            <img src="assets/images/users/<?php echo $room['user_picture_path']; ?>">
          </a>
          <div class="media-body left-text-info">
            <span class="media-heading left-nickname"><?php echo $room['nick_name'];?></span>
            <p class="left-intro"><?php echo $room['self_intro_1'];?>&nbsp;<?php echo $room['self_intro_2'];?>&nbsp;<?php echo $room['self_intro_3'];?></p>
          </div>
        </div>

      <?php else: ?>
        <?php $btn_id = $room['member_id'] . '_btn_pb' ?>
        <button type="button" id="<?php echo $btn_id ?>" class="btn btn-custom call-mw">
          <div class="media" style="position: relative; margin-top: 7px">
            <a class="pull-left left-photo">
              <img src="assets/images/users/<?php echo $room['user_picture_path']; ?>">
            </a>
            <div class="media-body left-text-info">
              <span class="media-heading left-nickname"><?php echo $room['nick_name'];?></span>
              <p class="left-intro"><?php echo $room['self_intro_1'];?>&nbsp;<?php echo $room['self_intro_2'];?>&nbsp;<?php echo $room['self_intro_3'];?></p>
            </div>
          </div>
        </button>

        <!-- ユーザーページ or チャット選択MW -->
        <?php $content_id = $room['member_id'] . '_mw_pb' ?>
        <?php $btn_cl_id = $room['member_id'] . '_mw_cl_btn' ?>
        <div id="<?php echo $content_id ?>" class="pb-mw-content">
          <img src="assets/images/users/<?php echo $room['user_picture_path']; ?>" style="width: 100px; height: 100px;">
          <a href="user.php?user_id=<?php echo $room['member_id']; ?>">個人ページへ</a>
          <a href="chat.php?friend_id=<?php echo $room['member_id']; ?>">チャットへ</a>
          <button type="button" id="<?php echo $btn_cl_id ?>">戻る</button>
        </div>
        <script>
          var content_id = "<?php echo $content_id; ?>"
          var btn_cl_id = "<?php echo $btn_cl_id; ?>"
          // 1番最初のモーダルウィンドウ呼び出し
          modalWindowOnFirstPb('call-mw');

          // 2番目のモーダルウィンドウ呼び出し
          // modalWindowOnClass('modal-check', 'modal-content_1', 'modal-content_2');

          // モーダルウィンドウの終了
          modalWindowOffPb(btn_cl_id, content_id);
        </script>

      <?php endif; ?>
    <?php } ?>

    <!-- 分岐MW表示時のoverlay -->
    <div class="modal-overlay-left-bar"></div>
  </div>

</div>


