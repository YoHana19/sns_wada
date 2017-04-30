<?php
require('../function.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/left_sideber.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/user.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/edit.css">
</head>
<body>

<!--プロフィール写真/ 一言-->
  <div class="container content">
    <div class="fb-profile">
      <div class="fb-image-lg" style="width: 100%; height: 400px;">
        <span class="intro-text-1">あ<br>の<br>鐘<br>を<br>ね</span>
        <span class="intro-text-2">鳴<br>ら<br>す<br>の<br>は<br>ね</span>
        <span class="intro-text-3">あ<br>な<br>た<br>だ<br>ね</span>
      </div>
      <img align="left" class ="fb-image-profile thumbnail" src="../assets/images/wada.jpg" alt="Profile image example">
      <div class="fb-profile-text">
        <h1 style="margin-top:50px;">和田隆宏</h1> <!-- 一応、名前の動かした -->
      </div>
    </div>
  </div>

  <div class="container content">
      <div class="row">
        <form class="form-horizontal">
          <fieldset>
            <!-- ニックネーム -->
            <div class="form-group" style="padding-top:60px; padding-bottom:10px;">
              <label class="col-md-4 control-label">ニックネーム</label>
              <div class="col-md-4">
                <input id="nick_name" name="nick_name" placeholder="" class="form-control input-md" required="" type="nick_name" >
              </div>
            </div>

            <!-- メールアドレス -->
            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label" for="UID">メールアドレス</label>
              <div class="col-md-4">
              <input id="UID" name="UID" placeholder="" class="form-control input-md" required="" type="email">
              </div>
            </div>

            <!-- メールアドレス確認-->
            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label" for="UID">メールアドレス(確認用)</label>
              <div class="col-md-4">
              <input id="UID" name="UID" placeholder="" class="form-control input-md" required="" type="email">
              </div>
            </div>

            <!-- 自己紹句 -->
            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label" for="comentario">上の句</label>
              <div class="col-md-4">
                <input class="form-control" id="coment" name="coment" required="">
              </div>
            </div>

            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label" for="comentario">中の句</label>
              <div class="col-md-4">
                <input class="form-control" id="coment" name="coment" required="">
              </div>
            </div>

            <div class="form-group" style="padding-top:20px; padding-bottom:10px;">
              <label class="col-md-4 control-label" for="comentario">下の句</label>
              <div class="col-md-4">
                <input class="form-control" id="coment" name="coment" required="">
              </div>
            </div>

            <!-- Button -->
            <div class="form-group" style="padding-top:50px; padding-bottom:80px; padding-left:220px;">
              <label class="col-md-4 control-label" for="btn_continuar"></label>
              <div class="col-md-8">
                <button id  ="btn_continuar" value="送信" class="btn btn-danger">保存</button>
              </div>
            </div>

          </fieldset>
        </form>
      </div>
  </div>
</body>
</html>
