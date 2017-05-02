<?php
require('../function.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/left_sideber.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/user.css">
</head>
<body>

<!--プロフィール写真/ 一言-->
  <div class="container content">
    <div class="fb-profile">
      <div class="fb-image-lg" style="width: 100%; height: 400px;">
        <span class="intro-text-3">お<br>ね<br>ぇ<br>さ<br>ん</span>
        <span class="intro-text-2">ト<br>レ<br>ン<br>デ<br>ィ<br>だ<br>ね</span>
        <span class="intro-text-1">齋<br>藤<br>さ<br>ん</span>
      </div>
      <img align="left" class="fb-image-profile thumbnail" src="../assets/images/wada.jpg" alt="Profile image example"/>
      <div class="fb-profile-text">
        <h1>Eli Macy</h1>
        <div class="navbar-fixed">
          <input type="button" value="+友達申請">
        </div>
      </div>
    </div>
  </div>



  <div class="container content">
      <div class="row">

        <div class="col-md-3 left-content">
          <?php require('left_sidebar.php'); ?>
        </div>
        <div class="col-md-8 right-content">
          

          <!-- 句一覧 -->

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
            <div class="icons">
              <a class="btn icon-btn btn-primary btn-color-like" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-up img-circle text-color-like"></span>よし</a>
              <a class="btn icon-btn btn-color-dislike" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-down img-circle text-color-dislike"></span>あし</a>
              <a class="btn icon-btn btn-color-comment" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</a>
            </div>
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
                    <img src="http://lorempixel.com/180/180/people/9/" width="30" height="30">
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
            <div class="msg">
              <img src="../assets/images/sakura_sample.jpg" width="30" height="30">
              <p><span class="name">Seed kun</span>くれいじーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー！</p>
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
            <div class="icons">
              <a class="btn icon-btn btn-primary btn-color-like" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-up img-circle text-color-like"></span>よし</a>
              <a class="btn icon-btn btn-color-dislike" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-down img-circle text-color-dislike"></span>あし</a>
              <a class="btn icon-btn btn-color-comment" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</a>
            </div>
          </div>

          <!-- ４つ目 -->
          <div class="haiku">
            <div class="carousel-info">
              <div class="pull-left">
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

        </div>
      </div>
  </div>
</body>
</html>
