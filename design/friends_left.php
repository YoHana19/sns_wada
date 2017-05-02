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
  <!-- 簡易個人プロフ -->
<!--   <img src="../assets/images/wada.jpg" id="photo">
  <h3>齋藤 由佳</h3>
  <h5>おねぇさん トレンディだね 齋藤さん</h5>
  <div class="clearfix"></div> -->

  <div class="well_3 chat-room" style="border: groove 2px #dcdddd">
    <div class="media" style="position: relative; margin-top: 7px">
      <a class="pull-left chat-photo" href="#">
        <img class="media-object" src="../assets/images/wada.jpg" style="width: 55px; height: 55px; border-radius: 50%">
      </a>
      <div class="media-body chat-body">
        <p class="media-heading chat-nickname">たかさん</p>
        <p class="chat-intro">あああああ　あああああああ　あああああ</p>
      </div>
    </div>
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
</body>
</html>