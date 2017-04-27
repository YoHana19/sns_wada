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

  <!-- 個人プロフ -->
  <div class="media" style="position: relative; margin-top: 7px">
    <a class="pull-left chat-photo" href="#">
      <img class="media-object" src="http://placekitten.com/110/110" style="width: 55px; height: 55px; border-radius: 50%">
    </a>
    <div class="media-body chat-body">
      <p class="media-heading chat-nickname">たかさん</p>
      <p class="chat-intro">あああああ　あああああああ　あああああ</p>
    </div>
  </div>

  <!-- 友達一覧 -->
  <div class="well_3 chat-room">
    <?php for ($i=0; $i < 15; $i++) { ?>
      <div class="media" style="position: relative; margin-top: 7px">
        <a class="pull-left chat-photo" href="#">
          <img class="media-object" src="http://placekitten.com/110/110" style="width: 55px; height: 55px; border-radius: 50%">
        </a>
        <div class="media-body chat-body">
          <p class="media-heading chat-nickname">たかさん</p>
          <p class="chat-intro">あああああ　あああああああ　あああああ</p>
        </div>
      </div>
    <?php } ?>
  </div>
</body>
</html>