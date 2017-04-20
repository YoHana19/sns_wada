<?php
require ('dbconnect.php');

// 検索ワード入力フォーム(検索窓) : 検索したワードが入っているくを検索結果として表示する
// 検索するもの : 一致する全件 句(haikus -> haiku1,2,3)
// 検索の場合の処理
$hogehoge = '';
if (isset($_GET['hogehoge']) && !empty($_GET['hogehoge'])) { //isset:true !empty:false
$hogehoge = $_GET['hogehoge'];
$sql = sprintf('SELECT h.*, m.nick_name, m.user_picture_path FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE h.haiku_1 LIKE "%%%s%%" OR h.haiku_2 LIKE "%%%s%%" OR h.haiku_3 LIKE "%%%s%%" ORDER BY h.created' ,$hogehoge, $hogehoge, $hogehoge); // SELECT文:DBから何かデータを持ってくる
// ↑この段階では入力しただけ

// ↓この先でセット,検索, する
$stmt = $dbh->prepare($sql); //phpmyadmyn で言うところの[sql]をセット(記入)する処理
$stmt->execute(); //phpmyadmyn で言うところの[実行]ボタンを押す処理
// $hugahuga = $stmt->fetch(PDO::FETCH_ASSOC); //取ってきたものを配列化
}

// $keisuke = array('name' => 'keisuke hayakawa',
//                  'age' => 28,
//                  'gender' => '男性',
//                  'dream' => '楽しい人生');
// echo $keisuke['name'] . '<br>';
// echo $keisuke['age'] . '<br>';
// echo $keisuke['gender'] . '<br>';
// echo $keisuke['dream'] . '<br>';
// echo '<pre>';
// var_dump($keisuke);
// echo '</pre>';


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

<!-- 検索ボタン表示 -->
<form method="GET" action="" class="form-horizontal" role='form'>
  <input type="text" name="hogehoge" value="<?php echo $hogehoge; ?>">
  <input type="submit" value="検索" class="btn btn-success btn-xs">
</form>

<!-- 検索ワード入力フォーム(検索窓) : 検索したワードが入っている句を検索結果として表示する -->
<!-- 検索結果表示 -->

<img src="member_picture<?php echo $hugahuga['user_picture_path']; ?>" width="100" height="100"><br>
<?php while($hugahuga = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
<?php
      echo $hugahuga['nick_name'] . '<br>';
      echo $hugahuga['haiku_1'] . '<br>';
      echo $hugahuga['haiku_2'] . '<br>';
      echo $hugahuga['haiku_3'] . '<br>';
      echo $hugahuga['created'] . '<br>';
      echo $hugahuga['haiku_id'] . '<br>';
      echo $hugahuga['member_id'] . '<br>';
; ?>
<?php endwhile; ?>

<!-- 詠むボタン->タイムライン/一句詠むと同じ -->

<!-- 検索ワードで、DBのユーザーネーム/句 の全データからあいまい検索 -->

</body>
</html>