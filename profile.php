<?php
session_start();
require('dbconnect.php');
$_SESSION['login_member_id'] = 1;

$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_user = $stmt->fetch(PDO::FETCH_ASSOC);

// 自分の作った全句を時系列で表示

$sql = 'SELECT h.*, m.nick_name, m.user_picture_path FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE h.member_id =? ORDER BY h.created';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$login_user_ku1 = array();
while ($login_user_ku = $stmt->fetch(PDO::FETCH_ASSOC)){
  $login_user_ku1[] = $login_user_ku;
}

// echo '<pre>';
// var_dump($login_user_ku1);
// echo '</pre>';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>

<!--プロフィール写真/ 一言-->
  <img align="left" class="fb-image-lg" src="assets/images/<?php echo $login_user['back_picture_path']; ?>" alt="Profile back image example"/>
  <img align="left" class="fb-image-profile thumbnail" src="assets/images/<?php echo $login_user['user_picture_path']; ?>" alt="Profile imexample"/>

  <div class="container">
    <h1><?php echo $login_user['nick_name']; ?></h1>
    <p><?php echo $login_user['self_intro']; ?></p>
    <input type="button" style="position: absolute; right: 100px; top: 350px" onclick="location.href='edit.php'" value="プロフィール編集">
  </div>


<!-- 自分の句時系列表示 -->
  <?php foreach ($login_user_ku1 as $login_user_ku2): ?>
    <div class="well_3">
          <div class="media">
            <a class="pull-left" href="chat.php">
              <img class="media-object" src="assets/images/<?php echo $login_user_ku2['user_picture_path']; ?>">
            </a>
              <div class="media-body">
                  <p class="text-right"></p>
                  <p>・<?php echo $login_user_ku2['haiku_1']; ?></p>
                  <p>・<?php echo $login_user_ku2['haiku_2']; ?></p>
                  <p>・<?php echo $login_user_ku2['haiku_3']; ?></p>
                  <p><?php echo $login_user_ku2['created']; ?></p>
              </div>
          </div>
    </div>
  <?php endforeach; ?>

  </div>
</body>
</html>






<?php
require('function.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" href="assets/css/left_sideber.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <link rel="stylesheet" type="text/css" href="assets/css/user.css">
</head>
<body>

<!--プロフィール写真/ 一言-->
  <div class="container content">
    <div class="fb-profile">
      <div class="fb-image-lg" style="width: 100%; height: 400px;">
        <span class="intro-text-3">お<br>ね<br>ぇ<br>さ<br>ん</span>
        <span class="intro-text-2">ト<br>レ<br>ン<br>デ<br>ィ<br>だ<br>ね</span>
        <span class="intro-text-1">齋<br>藤<br>さ<br>ん</span>
        <button type="button" class="change-back-img"><i class="fa fa-camera" aria-hidden="true"></i></button>
      </div>
      <img align="left" class="fb-image-profile thumbnail" src="assets/images/<?php echo $login_user['user_picture_path']; ?>" alt="Profile image example">
      <div class="fb-profile-text">
        <h1><?php echo $login_user['nick_name']; ?></h1>
        <div class="navbar-fixed">
          <input type="button" value="プロフィール編集">
          <input type="button" style="position: absolute; right: 100px; top: 350px" onclick="location.href='edit.php'" value="プロフィール編集">
          <button type="button" class="change-profile-img"><i class="fa fa-camera" aria-hidden="true"></i></button>
        </div>
      </div>
    </div>
  </div>

  <div class="container content">
      <div class="row">

        <div class="col-md-3 left-content">
          <?php require('left_side.php'); ?>
        </div>
        <div class="col-md-8 right-content">

          <!-- 句一覧 -->

          <!-- １つ目 -->
          <div class="haiku">
            <div class="carousel-info">
              <div class="pull-left">
                <span class="haiku-comment">もうこんな季節か・・・。</span>
              </div>
              <span style="text-align: right; margin-right: 3px;"><?php echo $login_user_ku2['created']; ?></span>
            </div>
            <div class="active item">
              <blockquote>
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
              <a class="btn icon-btn btn-color-comment" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</a>
            </div>
          </div>

          <!-- ２つ目 -->
          <div class="haiku">
            <div class="carousel-info">
              <div class="pull-left">
                <span></span>
              </div>
              <span style="text-align: right; margin-right: 3px;"><?php echo $login_user_ku2['created']; ?></span>
            </div>
            <div class="active item">
              <blockquote style="background: #d69090">
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
              <a class="btn icon-btn btn-color-comment" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</a>
            </div>
          </div>

          <!-- コメント欄 -->
          <div class="comment">
            <div class="msg">
              <form action="" method="" accept-charset="utf-8" class="form-horizontal">
                <div class="form-group">
                  <div class="col-sm-1">
                    <img src="http://lorempixel.com/180/180/people/9/" width="30" height="30">
                  </div>
                  <div class="col-sm-11">
                    <input type="text" name="nick_name" class="form-control" placeholder="例： Seed kun">
                  </div>
                </div>
              </form>
            </div>

            <div class="msg">
              <img src="assets/images/sakura_sample.jpg" width="30" height="30">
              <p><span class="name">Seed kun</span>なかなかやるじゃん</p>
            </div>

            <div class="msg">
              <img src="assets/images/sakura_sample.jpg" width="30" height="30">
              <p><span class="name">Seed kun</span>なかなかやるじゃないかああああああああああああああああああああああああああああああああああああああああああああああ</p>
            </div>

            <div class="msg">
              <img src="assets/images/sakura_sample.jpg" width="30" height="30">
              <p><span class="name">Seed kun</span>だろおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおお</p>
            </div>
            <div class="msg">
              <img src="assets/images/sakura_sample.jpg" width="30" height="30">
              <p><span class="name">Seed kun</span>くれいじーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー！</p>
            </div>
          </div>

          <!-- ３つ目 -->
          <div class="haiku">
            <div class="carousel-info">
              <div class="pull-left">
                <span></span>
              </div>
              <span style="text-align: right; margin-right: 3px;"><?php echo $login_user_ku2['created']; ?></span>
            </div>
            <div class="active item">
              <blockquote style="background: #c1e4e9">
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
              <a class="btn icon-btn btn-color-comment" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</a>
            </div>
          </div>

          <!-- ４つ目 -->
          <div class="haiku">
            <div class="carousel-info">
              <div class="pull-left">
                <span></span>
              </div>
              <span style="text-align: right; margin-right: 3px;"><?php echo $login_user_ku2['created']; ?></span>
            </div>
            <div class="active item">
              <blockquote style="background-image: url(assets/images/sakura_sample.jpg); background-size: cover;">
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
              <a class="btn icon-btn btn-color-comment" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</a>
            </div>
          </div>

        </div>
      </div>
  </div>
</body>
</html>
