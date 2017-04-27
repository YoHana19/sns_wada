<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>

  <!-- 簡易個人プロフ -->
  <img src="../assets/images/saito.jpeg" id="photo">
  <h3>齋藤 由佳</h3>
  <h5>おねぇさん トレンディだね 齋藤さん</h5>
  <div class="clearfix"></div>

  <!-- 友達表示 -->
  <div class="panel panel-default">  <!-- 「Friends」の一番上の枠 -->
    <div class="panel-heading c-list">  <!-- 「Friends」の一番上の枠のパネル -->
      <span class="title">お友達</span>
    </div>

    <!-- 直近連絡とった友達順に10件表示 -->
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
    
  </div>

</body>
</html>