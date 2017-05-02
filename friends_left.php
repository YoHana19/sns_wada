<?php

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  
  <!-- 検索フォーム -->
  <form action="" method="" accept-charset="utf-8" class="form-horizontal">
    <div id="custom-search-input">
      <div class="input-group">
        <input type="text" class="search-query form-control" placeholder=" 友達検索">
        <span class="input-group-btn">
          <button class="btn btn-danger" type="button">
            <span class="glyphicon glyphicon-search" style="color: #dcdddd"></span>
          </button>
        </span>
      </div>
    </div>
  </form>

  <div class="friends-display">
    <!-- タイトル表示 -->
    <div class="friends-title">
      <span class="title">吾輩</span>
    </div>
    <div class="well_3 left-proph-wrap">
        <div class="media" style="position: relative; margin-top: 7px">
          <a class="pull-left left-photo" href="#">
            <img class="media-object" src="../assets/images/saito.jpg" style="width: 55px; height: 55px; border-radius: 50%">
          </a>
        <div class="media-body left-proph-simple">
          <span class="media-heading left-nickname">たかさん</span>
          <p class="left-intro">あああああ　あああああああ　あああああ</p>
        </div>
      </div>
    </div>
  </div>

  <div class="friends-display">
    <!-- タイトル表示 -->
    <div class="friends-title">
      <span class="title">お仲間</span>
    </div>

    <!-- 友達一覧 -->
    <div class="well_3">
      <?php for ($i=0; $i < 15; $i++) { ?>
        <div class="media" style="position: relative; margin-top: 7px">
          <a class="pull-left left-photo" href="#">
            <img class="media-object" src="../assets/images/saito.jpg" style="width: 55px; height: 55px; border-radius: 50%">
          </a>
        <div class="media-body left-display">
          <span class="media-heading left-nickname">たかさん</span>
          <p class="left-intro">あああああ　あああああああ　あああああ</p>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</body>
</html>