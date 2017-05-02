<?php
session_start();
require('dbconnect.php');
// ↑全ページ共通の2行
if (isset($_search_word)) {//isset:その変数が定義されているかどうか確認する
$search_word = $_POST['search_word']; // header.phpで使用した変数をtimeline.phpでも使用可能にする
} else {
  $sql = sprintf('SELECT h.*, m.nick_name, m.user_picture_path FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id ORDER BY h.created DESC');
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
}
// 検索ワードで、DBのユーザーネーム/句 の全データからあいまい検索
// 検索ワード入力フォーム(検索窓) : 検索したワードが入っているくを検索結果として表示する
// 検索するもの : 一致する全件 句(haikus -> haiku1,2,3)
// 検索の場合の処理
$search_word = '';
if (isset($_REQUEST['search_word']) && !empty($_REQUEST['search_word'])) { //isset:true !empty:false
$search_word = $_REQUEST['search_word'];
$sql = sprintf('SELECT h.*, m.nick_name, m.user_picture_path FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE h.haiku_1 LIKE "%%%s%%" OR h.haiku_2 LIKE "%%%s%%" OR h.haiku_3 LIKE "%%%s%%" OR m.nick_name LIKE "%%%s%%" ORDER BY h.created DESC' ,$search_word, $search_word, $search_word, $search_word);
// SELECT文:DBから何かデータを持ってくる
// ↑この段階では入力しただけ
} else {
  // 通常の処理(検索していない場合の全件表示の処理)
  $sql = sprintf('SELECT h.*, m.nick_name, m.user_picture_path FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id ORDER BY h.created DESC');
  // LEFT JOINは、ON〜...まで入れなければ機能しない
  // haikusのmember_idとmembersのmember_idが一致
  // $sql = 'SELECT t.*, m.nick_name, m.picture_path FROM `tweets` t `members` m WHERE t.member_id=m.member_id';
}

// ↓この先でセット,検索, する
$stmt = $dbh->prepare($sql); //phpmyadmyn で言うところの[sql]をセット(記入)する処理
$stmt->execute(); //phpmyadmyn で言うところの[実行]ボタンを押す処理
// $word_display = $stmt->fetch(PDO::FETCH_ASSOC); //取ってきたものを配列化
?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" href="assets/css/header.css">
  <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
  <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
  <link rel="stylesheet" type="text/css" href="assets/css/left_sideber.css">
  <link rel="stylesheet" type="text/css" href="assets/css/mw_haiku_input.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- For Modal Window -->
  <link rel="stylesheet" type="text/css" href="assets/css/modal_window.css">
</head>
<body>

  <!-- ヘッダー -->
  <?php require('header.php'); ?>

  <div class="container">
    <div class="row whole_content">

      <!-- 左サイドバー -->
      <div class="col-md-3 left-content">
        <?php require('left_sidebar.php'); ?>
      </div>

      <!-- 本コンテンツ -->
      <div class="col-md-8 right-content">
      
        <!-- 今日の季語 -->
        <div class="season_title">
          <h4>今日の季語</h4>
        </div>
        <div class="outer">
          <div class="season_word">
            <h1>さくら</h1>
          </div>
        </div>

        <!-- 詠むボタン -->
        <div style="text-align: right;">
          <input type="submit" class="btn btn-info" value="詠む" style="background-color: #00a381;">
        </div>

          <!-- 句一覧 -->

          <!-- １つ目 -->
          <div class="haiku">
            <div class="carousel-info">
              <img alt="" src="http://keenthemes.com/assets/bootsnipp/img1-small.jpg" class="pull-left">
              <div class="pull-left">
                <span class="haiku-name">Lina Mars</span>
                <span calss="haiku-comment">もうこんな季節か・・・。</span>
              </div>
              <p>3時間前</p>
            </div>
            <div class="active item">
              <blockquote style="background:#fff0f5">
                <div class="haiku-text">
                  <h2 class="haiku-text-1">桜<br>か<br>な</h2>
                  <h2 class="haiku-text-2">事<br>思<br>ひ<br>出<br>す</h2>
                  <h2 class="haiku-text-3">さ<br>ま<br>ざ<br>ま<br>な</h2>
                </div>
              </blockquote>
            </div>
            <div style="text-align: right;">
              <div style="float: left">
                <i class="glyphicon glyphicon-thumbs-up icon-margin">&thinsp;10人</i>
                <i class="glyphicon glyphicon-thumbs-down icon-margin">&thinsp;5人</i>
                <i class="fa fa-commenting-o icon-margin" aria-hidden="true">&thinsp;3件</i>
              </div>
              <i class="fa fa-facebook-official fa-2x" aria-hidden="true" style="color: #3b5998"></i>
              <i class="fa fa-twitter-square fa-2x" aria-hidden="true" style="color: #00a1e9"></i>
            </div>
            <div class="icons">
              <a class="btn icon-btn btn-primary btn-color-like" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-up img-circle text-color-like"></span>よし</a>
              <a class="btn icon-btn btn-color-dislike" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-down img-circle text-color-dislike"></span>あし</a>
              <a class="btn icon-btn btn-color-comment" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</a>
            </div>
          </div>

          <!-- ２つ目 -->
          <div class="haiku">
            <div class="carousel-info">
              <img alt="" src="http://keenthemes.com/assets/bootsnipp/img1-small.jpg" class="pull-left">
              <div class="pull-left">
                <span class="haiku-name">Lina Mars</span>
              </div>
              <p>3時間前</p>
            </div>
            <div class="active item">
              <blockquote style="background:#fff0f5">
                <div class="haiku-text">
                  <h2 class="haiku-text-1">桜<br>か<br>な</h2>
                  <h2 class="haiku-text-2">事<br>思<br>ひ<br>出<br>す</h2>
                  <h2 class="haiku-text-3">さ<br>ま<br>ざ<br>ま<br>な</h2>
                </div>
              </blockquote>
            </div>
            <div style="text-align: right;">
              <div style="float: left">
                <i class="glyphicon glyphicon-thumbs-up icon-margin">&thinsp;10人</i>
                <i class="glyphicon glyphicon-thumbs-down icon-margin">&thinsp;5人</i>
                <i class="fa fa-commenting-o icon-margin" aria-hidden="true">&thinsp;3件</i>
              </div>
              <i class="fa fa-facebook-official fa-2x" aria-hidden="true" style="color: #3b5998"></i>
              <i class="fa fa-twitter-square fa-2x" aria-hidden="true" style="color: #00a1e9"></i>
            </div>
            <div class="icons">
              <a class="btn icon-btn btn-primary btn-color-like" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-up img-circle text-color-like"></span>よし</a>
              <a class="btn icon-btn btn-color-dislike" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-down img-circle text-color-dislike"></span>あし</a>
              <a class="btn icon-btn btn-color-comment" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</a>
            </div>
          </div>
          <!-- コメント欄 -->
          <div class="comment">
            <div class="msg">
              <form action="" method="" accept-charset="utf-8" class="form-horizontal">
                <div class="form-group">
                  <div class="col-sm-1">
                    <img src="../assets/images/proph.jpg" width="30" height="30">
                  </div>
                  <div class="col-sm-11">
                    <input type="text" name="nick_name" class="form-control" placeholder="例： Seed kun">
                  </div>
                </div>
              </form>
            </div>

            <div class="msg">
              <img src="../assets/images/sakura_sample.jpg" width="30" height="30">
              <p><span class="name">Seed kun</span>なかなかやるじゃん</p>
            </div>

            <div class="msg">
              <img src="../assets/images/sakura_sample.jpg" width="30" height="30">
              <p><span class="name">Seed kun</span>なかなかやるじゃないかああああああああああああああああああああああああああああああああああああああああああああああ</p>
            </div>

            <div class="msg">
              <img src="../assets/images/sakura_sample.jpg" width="30" height="30">
              <p><span class="name">Seed kun</span>だろおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおお</p>
            </div>
          </div>

          <!-- ３つ目 -->
          <div class="haiku">
            <div class="carousel-info">
              <img alt="" src="http://keenthemes.com/assets/bootsnipp/img1-small.jpg" class="pull-left">
              <div class="pull-left">
                <span class="haiku-name">Lina Mars</span>
              </div>
              <p>3時間前</p>
            </div>
            <div class="active item">
              <blockquote style="background: #fff0f5">
                <div class="haiku-text">
                  <h2 class="haiku-text-1">桜<br>か<br>な</h2>
                  <h2 class="haiku-text-2">事<br>思<br>ひ<br>出<br>す</h2>
                  <h2 class="haiku-text-3">さ<br>ま<br>ざ<br>ま<br>な</h2>
                </div>
              </blockquote>
            </div>
            <div style="text-align: right;">
              <div style="float: left">
                <i class="glyphicon glyphicon-thumbs-up icon-margin">&thinsp;10人</i>
                <i class="glyphicon glyphicon-thumbs-down icon-margin">&thinsp;5人</i>
                <i class="fa fa-commenting-o icon-margin" aria-hidden="true">&thinsp;3件</i>
              </div>
              <i class="fa fa-facebook-official fa-2x" aria-hidden="true" style="color: #3b5998"></i>
              <i class="fa fa-twitter-square fa-2x" aria-hidden="true" style="color: #00a1e9"></i>
            </div>
            <div class="icons">
              <a class="btn icon-btn btn-primary btn-color-like" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-up img-circle text-color-like"></span>よし</a>
              <a class="btn icon-btn btn-color-dislike" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-down img-circle text-color-dislike"></span>あし</a>
              <a class="btn icon-btn btn-color-comment" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</a>
            </div>
          </div>

          <!-- ４つ目 -->
          <div class="haiku">
            <div class="carousel-info">
              <img alt="" src="http://keenthemes.com/assets/bootsnipp/img1-small.jpg" class="pull-left">
              <div class="pull-left">
                <span class="haiku-name">Lina Mars</span>
              </div>
              <p>3時間前</p>
            </div>
            <div class="active item">
              <blockquote style="background-image: url(../assets/images/sakura_sample.jpg); background-size: cover;">
                <div class="haiku-text">
                  <h2 class="haiku-text-1">桜<br>か<br>な</h2>
                  <h2 class="haiku-text-2">事<br>思<br>ひ<br>出<br>す</h2>
                  <h2 class="haiku-text-3">さ<br>ま<br>ざ<br>ま<br>な</h2>
                </div>
              </blockquote>
            </div>
            <div style="text-align: right;">
              <div style="float: left">
                <i class="glyphicon glyphicon-thumbs-up icon-margin">&thinsp;10人</i>
                <i class="glyphicon glyphicon-thumbs-down icon-margin">&thinsp;5人</i>
                <i class="fa fa-commenting-o icon-margin" aria-hidden="true">&thinsp;3件</i>
              </div>
              <i class="fa fa-facebook-official fa-2x" aria-hidden="true" style="color: #3b5998"></i>
              <i class="fa fa-twitter-square fa-2x" aria-hidden="true" style="color: #00a1e9"></i>
            </div>
            <div class="icons">
              <a class="btn icon-btn btn-primary btn-color-like" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-up img-circle text-color-like"></span>よし</a>
              <a class="btn icon-btn btn-color-dislike" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-down img-circle text-color-dislike"></span>あし</a>
              <a class="btn icon-btn btn-color-comment" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</a>
            </div>
          </div>

          </div> <!-- col-md-7終了タグ -->
    </div>
  </div>



<!-- フッター表示 -->
<?php require('footer.php'); ?>


</body>
</html>