<?php
session_start();
require('dbconnect.php');

$search_word = '';
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

<!-- 運営ページに遷移 -->
<a href="manage.php">運営</a>

<!-- 友達申請リスト表示 -->
<a href="friends_apply.php">友達申請リスト</a>

<!-- 検索ボタン表示 -->
<form method="POST" action="timeline.php" class="form-horizontal" role='form'>
  <input type="text" name="search_word" value="<?php echo $search_word; ?>">  <!-- 検索したいワードを入力するinput -->
  <input type="submit" value="検索" class="btn btn-success btn-xs">     <!-- 検索するinput -->
</form>

</body>
</html>