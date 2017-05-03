<?php
require('dbconnect.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  
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
    <div class="well_3 left-proph-wrap">
        <div class="media" style="position: relative; margin-top: 7px">
          <a class="pull-left left-photo" href="#">
            <img class="media-object" src="assets/images/<?php echo $login_member['user_picture_path']; ?>" style="width: 55px; height: 55px; border-radius: 50%">
          </a>
        <div class="media-body left-display" style="border-bottom: none;">
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
      <span style="margin-left: 220px; font-weight: 600;"><?php echo $num_friends ?></span>
    </div>

    <!-- 友達一覧 -->
    <div class="well_3">
      <?php foreach ($friends as $friend) { ?>
        <div class="media" style="position: relative; margin-top: 7px">
          <a class="pull-left left-photo" href="#">
            <img class="media-object" src="assets/images/<?php echo $friend['user_picture_path']; ?>" style="width: 55px; height: 55px; border-radius: 50%">
          </a>
        <div class="media-body left-display">
          <span class="media-heading left-nickname"><?php echo $friend['nick_name'];?></span>
          <p class="left-intro"><?php echo $friend['self_intro_1'];?>&nbsp;<?php echo $friend['self_intro_2'];?>&nbsp;<?php echo $friend['self_intro_3'];?></p>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</body>
</html>