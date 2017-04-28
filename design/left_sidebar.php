<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>

  <?php $file_name = getFileNameFromUri(); ?>

  <?php if($file_name == 'timeline.php'): ?>

      <!-- 簡易個人プロフ -->
      <div class="left-proph">
        <img src="../assets/images/saito.jpg" id="photo">
        <h3>齋藤 由佳</h3>
        <span class="intro-text-3">お<br>ね<br>ぇ<br>さ<br>ん</span>
        <span class="intro-text-2">ト<br>レ<br>ン<br>デ<br>ィ<br>だ<br>ね</span>
        <span class="intro-text-1">齋<br>藤<br>さ<br>ん</span>
      </div>
      <div class="clearfix"></div>

  <?php endif; ?>

  <div class="friends-display">
    <!-- タイトル表示 -->
    <div class="friends-title">
      <span class="title">お仲間</span>
    </div>

    <!-- 直近連絡とった友達順に10件表示 -->
    <div class="well_3">
      <?php for ($i=0; $i < 15; $i++) { ?>
        <div class="media" style="position: relative; margin-top: 7px">
          <a class="pull-left left-photo" href="#">
            <img class="media-object" src="http://placekitten.com/110/110" style="width: 55px; height: 55px; border-radius: 50%">
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