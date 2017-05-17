<?php
require('dbconnect.php');
?>

<!-- ** -->
<!-- htmlコンテンツ -->
<!-- ** -->

<!-- 検索フォーム -->
<form action="friends.php" method="GET" accept-charset="utf-8" class="form-horizontal">
  <div id="custom-search-input" style="position: relative;">
    <div class="input-group">
      <input type="text" name="search_word" class="search-query form-control" placeholder=" 友達検索" value="<?php echo $search_word_f ?>">
      <span class="input-group-btn">
        <button class="btn btn-danger" type="submit">
          <span class="glyphicon glyphicon-search" style="color: #dcdddd"></span>
        </button>
      </span>
    </div>
    <!-- 分岐MW表示時のoverlay -->
    <div class="modal-overlay-left-bar"></div>
  </div>
</form>

<div class="friends-display" style="margin-top: 20px;">
  <!-- タイトル表示 -->
  <div class="friends-title">
    <span class="title">吾輩</span>
  </div>
  <div class="left-wrap left-proph-wrap">
    <div class="media" style="position: relative; margin-top: 7px">
      <a class="pull-left left-photo" href="profile.php">
        <img class="media-object" src="assets/images/users/<?php echo $login_member['user_picture_path']; ?>">
      </a>
      <div class="media-body left-text-info" style="border-bottom: none;">
        <span class="media-heading left-nickname"><?php echo $login_member['nick_name'];?></span>
        <p class="left-intro"><?php echo $login_member['self_intro_1'];?>&nbsp;<?php echo $login_member['self_intro_2'];?>&nbsp;<?php echo $login_member['self_intro_3'];?></p>
      </div>
    </div>
    <!-- 分岐MW表示時のoverlay -->
    <div class="modal-overlay-left-bar"></div>
  </div>
</div>

<div class="friends-display">
  <!-- タイトル表示 -->
  <div class="friends-title">
    <span class="title">お仲間一覧</span>
    <span style="margin-left: 20px; font-weight: 600;"><?php echo $num_friends ?></span>
  </div>

  <!-- 友達一覧 -->
  <div class="left-wrap">
    <?php foreach ($friends_name as $friend_name) { ?>

      <!-- 友達の情報を取得 -->
      <?php
        $sql = 'SELECT * FROM `members` WHERE `nick_name`=?';
        $data = array($friend_name);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        $friend_info = $stmt->fetch(PDO::FETCH_ASSOC);
      ?>

      <?php $btn_id = $friend_info['member_id'] . '_btn_pb' ?>
      <button type="button" id="<?php echo $btn_id ?>" class="btn btn-custom call-mw">
        <div class="media" style="position: relative; margin-top: 7px">
          <a class="pull-left left-photo" href="#">
            <img class="media-object" src="assets/images/users/<?php echo $friend_info['user_picture_path']; ?>">
          </a>
          <div class="media-body left-text-info">
            <span class="media-heading left-nickname" style="font-size: 14px;"><?php echo $friend_info['nick_name'];?></span>
            <p class="left-intro"><?php echo $friend_info['self_intro_1'];?>&nbsp;<?php echo $friend_info['self_intro_2'];?>&nbsp;<?php echo $friend_info['self_intro_3'];?></p>
          </div>
        </div>
      </button>

      <!-- ユーザーページ or チャット選択MW -->
      <?php $content_id = $friend_info['member_id'] . '_mw_pb' ?>
      <?php $btn_cl_id = $friend_info['member_id'] . '_mw_cl_btn' ?>
      <div id="<?php echo $content_id ?>" class="pb-mw-content">
        <img src="assets/images/users/<?php echo $friend_info['user_picture_path']; ?>" style="width: 100px; height: 100px;">
        <a href="user.php?user_id=<?php echo $friend_info['member_id']; ?>">個人ページへ</a>
        <a href="chat.php?friend_id=<?php echo $friend_info['member_id']; ?>">チャットへ</a>
        <button type="button" id="<?php echo $btn_cl_id ?>">戻る</button>
      </div>
      <script>
        var content_id = "<?php echo $content_id; ?>"
        console.log(content_id);
        var btn_cl_id = "<?php echo $btn_cl_id; ?>"
        console.log(btn_cl_id);
        // 1番最初のモーダルウィンドウ呼び出し
        modalWindowOnFirstPb('call-mw', content_id);

        // 2番目のモーダルウィンドウ呼び出し
        // modalWindowOnClass('modal-check', 'modal-content_1', 'modal-content_2');

        // モーダルウィンドウの終了
        modalWindowOffPb(btn_cl_id, content_id);
      </script>

    <?php } ?>

    <!-- 分岐MW表示時のoverlay -->
    <div class="modal-overlay-left-bar"></div>
  </div>
</div>