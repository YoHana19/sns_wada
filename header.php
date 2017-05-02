<?php
session_start();
require('dbconnect.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
<!-- ホームボタンを押す->タイムラインページに遷移 -->
<a href="timeline.php">和だ</a>

<!-- ユーザー名ボタン->個人プロフィールページに遷移 -->
<a href="profile.php">個人ページ</a>

<!-- 友達一覧ボタン->友達一覧ページに遷移 -->
<a href="friends.php">友達一覧</a>

<!-- チャットボタン->チャットページに遷移 -->
<a href="chat.php">chat</a>

<!-- ランキング/コラムボタン->ランキング/コラムページに遷移 -->
<a href="ranking.php">ランク/コラム</a>

<!-- 運営ボタン->運営ページに遷移 -->
<a href="manage.php">運営</a>

<!-- ログアウトボタン->ログアウトページへ遷移->終了後topページへ -->
<a href="logout.php">ログアウト</a>

<!-- 検索ボタン表示 -->
<form method="POST" action="timeline.php" class="form-horizontal" role='form'>
  <input type="text" name="search_word" value="<?php $search_word = ''; echo $search_word; ?>">  <!-- 検索したいワードを入力するinput -->
  <input type="submit" value="検索" class="btn btn-success btn-xs">     <!-- 検索するinput -->
</form>

</body>
</html>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <nav class="navbar navbar-webmaster" style="width:'auto'; height: 80px">
    <div class=""></div>
    <div class="header-bk">
      <div class="navbar-header">
        <a class="navbar-brand" href="timeline.php">和だ</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="nav navbar-nav navbar-right">
          <!-- 友達リクエスト -->
          <li class="active click"><a href="#"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
          <!-- プロフページ -->
          <li class="active click"><a href="profile.php"><i class="fa fa-user fa-2x" aria-hidden="true"></i></i><i class="fa fa-user-circle-o" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
          <!-- チャットページ -->
          <li class="active click"><a href="chat.php"><i class="fa fa-comments fa-2x" aria-hidden="true"></i></i><span class="sr-only">(current)</span></a></li>
          <!-- 友達一覧ページ -->
          <li class="active click"><a href="friends.php"><i class="fa fa-users fa-2x" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
          <!-- ランキングページ -->
          <li class="active click"><a href="ranking.php"><i class="fa fa-sort-numeric-asc fa-2x" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
          <!-- ログアウト -->
          <li id="logout" class=""><a href="logout.php" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a></li></a></li>

          <form class="navbar-form navbar-right search-form form-horizontal" role="search">
            <!-- 検索フォーム -->
            <div id="custom-search-input">
              <div class="input-group">
                <input type="text" class="search-query form-control" placeholder="search">
                  <span class="input-group-btn">
                    <button class="btn btn-danger" type="button">
                      <span class="glyphicon glyphicon-search" style="color: #dcdddd"></span>
                    </button>
                  </span>
              </div>
              <input type="button" class="btn btn-info haiku-input" value="詠む">
            </div>
          </form>
        </ul>
      </div>
    </div>
  </nav>
  </nav>

  <script src="assets/js/bootstrap.js"></script>
</body>
</html>