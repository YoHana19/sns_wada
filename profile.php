<?php
session_start();
require('dbconnect.php');
$_SESSION['id'] = 1;

$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
$data = array($_SESSION['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_user = $stmt->fetch(PDO::FETCH_ASSOC);

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
  <div class="container">
    <div class="fb-profile">
      <img align="left" class="fb-image-lg" src="assets/images/<?php echo $login_user['back_picture_path']; ?>" alt="Profile back image example"/>
      <img align="left" class="fb-image-profile thumbnail" src="assets/images/<?php echo $login_user['user_picture_path']; ?>" alt="Profile image example"/>
      <div class="fb-profile-text">
        <h1><?php echo $login_user['nick_name']; ?></h1>
        <p><?php echo $login_user['self_intro']; ?></p>
        <div class="navbar-fixed">
          <input type="button" style="position: absolute; right: 100px; top: 350px"/ onclick="location.href='edit.php'" value="プロフィール編集">
        </div>
      </div>
    </div>
  </div>



       <!-- 句一覧 -->
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-offset-3 centered">

          <!-- １つ目 -->
          
            <div class="haiku">
              <div class="carousel-info">
                <div class="pull-left">
                  <span calss="haiku-comment">もうこんな季節か・・・。</span>
                </div>
                <p>3時間前</p>
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

          <!-- ２つ目 -->
            <div class="haiku">
              <div class="carousel-info">
                <div class="pull-left">
                </div>
                <p>3時間前</p>
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
            
            <!-- コメント欄 -->
            <div class="comment">
              <div class="msg">
                <form action="" method="" accept-charset="utf-8" class="form-horizontal">
                  <div class="form-group">
                    <div class="col-sm-1">
                      <img src="assets/images/<?php echo $login_user['user_picture_path']; ?>" width="30" height="30">
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
                <p><span class="name">Seed kun</span> なかなかやるじゃないかああああああああああああああああああああああああああああああああああああああああああああああ</p>
              </div>

              <div class="msg">
                <img src="assets/images/sakura_sample.jpg" width="30" height="30">
                <p><span class="name">Seed kun</span>だろおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおおお</p>
              </div>
            </div>

            <!-- ３つ目 -->
            <div class="haiku">
              <div class="carousel-info">
                <div class="pull-left">
                </div>
                <p>3時間前</p>
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
           

            <!-- ４つ目 -->
            <div class="haiku">
              <div class="carousel-info">
                <div class="pull-left">
                </div>
                <p>3時間前</p>
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
            </div>
          </div>
        </div>

</body>
</html>