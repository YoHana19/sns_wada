<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/chat.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <!-- チャット一覧 -->
      <div class="col-md-3 chat-list">
        <?php require('friends_left.php'); ?>
      </div>

      <!-- 個人チャット画面 -->
      <div class="col-md-8 chat-private">
        <div class="outer">
          <div class="page-header">
            <h2>たかさん</h2>
          </div>
        </div>

        <section class="comment-list">

          <!-- First Comment -->
          <article class="row">
            <div class="col-md-2 col-sm-2 hidden-xs">
              <figure class="thumbnail" style="border-radius: 50%; background-color: #fffffc;">
                <img class="img-responsive" src="../assets/images/pic-t1.jpg" style="border-radius: 50%;">
               </figure>
            </div>
            <div class="col-md-10 col-sm-10">
              <p class="chat-name">たかさん</p>
              <div class="panel panel-default arrow left user-left">
                <div class="panel-body">
                  <header class="text-left">
                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> Dec 16, 2014</time>
                  </header>
                  <div class="haiku-text">
                    <p class="haiku-text-1">ご<br>め<br>ん<br>な<br>さ<br>い</p>
                    <p class="haiku-text-2">遅<br>刻<br>確<br>定</p>
                    <p class="haiku-text-3">寝<br>坊<br>し<br>た</p>
                  </div>
                </div>
              </div>
            </div>
          </article>
             
          <!-- Second Comment -->
          <article class="row">
            <div class="col-md-10 col-sm-10">
              <p class="chat-name" style="text-align: right;">たかさん</p>
              <div class="panel panel-default arrow right user-right">
                <div class="panel-body">
                  <header class="text-right">
                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> Dec 16, 2014</time>
                  </header>
                  <div class="haiku-text">
                    <p class="haiku-text-1">終<br>わ<br>り<br>だ<br>わ</p>
                    <p class="haiku-text-2">何<br>回<br>目<br>な<br>の</p>
                    <p class="haiku-text-3">許<br>さ<br>な<br>い</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2 col-sm-2 hidden-xs">
              <figure class="thumbnail" style="border-radius: 50%; background-color: #fffffc;">
                <img class="img-responsive" src="../assets/images/pic-t3.jpg" style="border-radius: 50%;">
              </figure>
            </div>
          </article>

          <!-- Third Comment -->
          <article class="row">
            <div class="col-md-10 col-sm-10">
              <p class="chat-name" style="text-align: right;">たかさん</p>
              <div class="panel panel-default arrow right user-right" style="background-color: #fffffc; border-left-color: #fffffc;">
                <div class="panel-body">
                  <header class="text-right">
                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> Dec 16, 2014</time>
                  </header>
                  <div class="haiku-text">
                    <p class="haiku-text-1">終<br>わ<br>り<br>だ<br>わ</p>
                    <p class="haiku-text-2">何<br>回<br>目<br>な<br>の</p>
                    <p class="haiku-text-3">許<br>さ<br>な<br>い</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2 col-sm-2 hidden-xs">
              <figure class="thumbnail"  style="border-radius: 50%; background-color: #fffffc;">
                <img class="img-responsive" src="../assets/images/pic-t3.jpg" style="border-radius: 50%;">
              </figure>
            </div>
          </article>

          <!-- Second Comment -->
          <article class="row">
            <div class="col-md-2 col-sm-2 hidden-xs">
              <figure class="thumbnail" style="border-radius: 50%; background-color: #fffffc;">
                <img class="img-responsive" src="../assets/images/pic-t1.jpg" style="border-radius: 50%;">
               </figure>
            </div>
            <div class="col-md-10 col-sm-10">
              <p class="chat-name">たかさん</p>
              <div class="panel panel-default arrow left user-left" style="background-image: url(../assets/images/tikoku-sample.jpg); background-size: contain;">
                <div class="panel-body">
                  <header class="text-left">
                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> Dec 16, 2014</time>
                  </header>
                  <div class="haiku-text">
                    <p class="haiku-text-1">ご<br>め<br>ん<br>な<br>さ<br>い</p>
                    <p class="haiku-text-2">遅<br>刻<br>確<br>定</p>
                    <p class="haiku-text-3">寝<br>坊<br>し<br>た</p>
                  </div>
                </div>
              </div>
            </div>
          </article>

          <!-- 俳句入力フォーム -->
          <form action="" method="" accept-charset="utf-8" class="form-horizontal">
            <button type="button" class="btn icon-btn btn-info" style="background-color: #d0576b; border-color: #d0576b;"><span class="glyphicon btn-glyphicon glyphicon-share img-circle text-info" style="color: #d0576b"></span> 詠む</button>
          </form>

        </section>
      </div>
    </div>
  </div>

</body>
</html>