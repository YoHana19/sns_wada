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
<html>
<head>
  <title></title>
</head>
<body>
  <!-- 検索ワード入力フォーム(検索窓) : 検索したワードが入っている句を検索結果として表示する -->
<!-- 検索結果表示 -->
<?php echo '検索したワード: ' . $search_word . '<br>'; ?>
<?php while($word_display = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
<img src="assets/images/<?php echo $word_display['user_picture_path']; ?>" width="100" height="100"><br>
<?php
  echo $word_display['nick_name'] . '<br>';
  echo $word_display['haiku_1'] . '<br>';
  echo $word_display['haiku_2'] . '<br>';
  echo $word_display['haiku_3'] . '<br>';
  echo $word_display['created'] . '<br>';
  echo $word_display['haiku_id'] . '<br>';
  echo $word_display['member_id'] . '<br>';
// 連想配列化された変数の値を取り出して表示
// $word_displayが検索結果を持っている ← これをtimeline.phpに遷移させる

?>
<?php endwhile; ?>

</body>
</html>