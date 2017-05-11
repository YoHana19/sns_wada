<?php
require('dbconnect.php');
?>

<!-- ** -->
<!-- htmlコンテンツ -->
<!-- ** -->

<!-- 検索フォーム -->
<form action="friends.php" method="GET" accept-charset="utf-8" class="form-horizontal">
  <div id="custom-search-input">
    <div class="input-group">
      <input type="text" name="search_word" class="search-query form-control" placeholder=" 友達検索" value="<?php echo $search_word ?>">
      <span class="input-group-btn">
        <button class="btn btn-danger" type="submit">
          <span class="glyphicon glyphicon-search" style="color: #dcdddd"></span>
        </button>
      </span>
    </div>
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
          <img class="media-object" src="assets/images/<?php echo $login_member['user_picture_path']; ?>">
        </a>
      <div class="media-body left-text-info" style="border-bottom: none;">
        <span class="media-heading left-nickname"><?php echo $login_member['nick_name'];?></span>
        <p class="left-intro"><?php echo $login_member['self_intro_1'];?>&nbsp;<?php echo $login_member['self_intro_2'];?>&nbsp;<?php echo $login_member['self_intro_3'];?></p>
      </div>
    </div>
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
    <?php foreach ($friends as $friend) { ?>
      <button type="button" class="btn btn-custom call-mw">
        <div class="media" style="position: relative; margin-top: 7px">
          <a class="pull-left left-photo" href="#">
            <img class="media-object" src="assets/images/<?php echo $friend['user_picture_path']; ?>">
          </a>
          <div class="media-body left-text-info">
            <span class="media-heading left-nickname" style="font-size: 14px;"><?php echo $friend['nick_name'];?></span>
            <p class="left-intro"><?php echo $friend['self_intro_1'];?>&nbsp;<?php echo $friend['self_intro_2'];?>&nbsp;<?php echo $friend['self_intro_3'];?></p>
          </div>
        </div>
      </button>

      <!-- ユーザーページ or チャット選択MW -->
      <?php $content_id = $friend['member_id'] . '_mw_pb' ?>
      <?php $btn_cl_id = $friend['member_id'] . '_mw_cl_btn' ?>
      <div id="<?php echo $content_id ?>" class="pb-mw-content">
        <img src="assets/images/<?php echo $friend['user_picture_path']; ?>" style="width: 100px; height: 100px;">
        <a href="user.php?user_id=<?php echo $friend['member_id']; ?>">個人ページへ</a>
        <a href="chat.php?friend_id=<?php echo $friend['member_id']; ?>">チャットへ</a>
        <button type="button" id="<?php echo $btn_cl_id ?>">戻る</button>
      </div>
      <script>
        var content_id = "<?php echo $content_id; ?>"
        console.log(content_id);
        var btn_cl_id = "<?php echo $btn_cl_id; ?>"
        console.log(btn_cl_id);
        // 1番最初のモーダルウィンドウ呼び出し
        modalWindowOnFirstClass('call-mw', content_id);

        // 2番目のモーダルウィンドウ呼び出し
        // modalWindowOnClass('modal-check', 'modal-content_1', 'modal-content_2');

        // モーダルウィンドウの終了
        modalWindowOff(btn_cl_id, content_id);

        //リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
        $(window).resize(centeringModalSyncer);
      </script>

    <?php } ?>
  </div>
</div>