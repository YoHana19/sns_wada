<?php
session_start();
require('dbconnect.php');
// ランキングよし・あし、俳人・句それぞれのランキング上位3件を取ってくる

// よしランキング句用sql文
$sql = 'SELECT * FROM `likes`';
$stmt = $dbh->prepare($sql);
$stmt->execute();
// $data : sql文の中で「?」を使いたい時必要

// ↓sql文で取得したデータを配列化
$haiku_ids = array();
while($like_haiku = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $haiku_ids[] = $like_haiku['haiku_id'];
}       // ↑ここで配列化 []を使うと、[1]-> [1,2]-> [1,2,3]...のように新しい数を配列の最後尾にいれる

// var_dump($haiku_ids);
$haiku_rank = rankGet($haiku_ids);

// 句、プロフ画像、名前取得
$haikus_info = array();
foreach ($haiku_rank as $haiku) {
  $sql = 'SELECT * FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE `haiku_id`=?';
  $data = array($haiku[0]);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  $haikus_info[] = $record;
}

echo '<pre>';
var_dump($haikus_info);
echo '</pre>';

foreach ($haikus_info as $haiku_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  echo $haiku_info['nick_name'];
  echo '<br>';
  echo $haiku_info['haiku_1'];
  echo '<br>';
  echo $haiku_info['haiku_2'];
  echo '<br>';
  echo $haiku_info['haiku_3'];
  echo "<br>" . "<br>";
}

foreach ($haiku_rank as $haiku) { //(良し数)
  echo $haiku[1] . '<br>';
}


// よしランキング歌人用sql文
$sql = 'SELECT * FROM `likes`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$member_ids = array();
while($like_member = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $member_ids[] = $like_member['haiku_member_id'];
}

$member_rank = rankGet($member_ids);

// プロフ画像、名前取得
$members_info = array();
foreach ($member_rank as $member) {
  $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $data = array($member[0]);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $member_record = $stmt->fetch(PDO::FETCH_ASSOC);
  $members_info[] = $member_record;
}

foreach ($members_info as $member_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  echo $member_info['nick_name'];
  echo '<br>' . '<br>';
}

foreach ($member_rank as $member) { //(良し数)
  echo $member[1];
  echo '<br>';
}





// あしランキング句用sql文
$sql = 'SELECT * FROM `dislikes`';
$stmt = $dbh->prepare($sql);
$stmt->execute();
// $data : sql文の中で「?」を使いたい時必要

// ↓sql文で取得したデータを配列化
$bad_haiku_ids = array();
while($dislike_haiku = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $bad_haiku_ids[] = $dislike_haiku['haiku_id'];
}       // ↑ここで配列化 []を使うと、[1]-> [1,2]-> [1,2,3]...のように新しい数を配列の最後尾にいれる

$bad_haiku_rank = rankGet($bad_haiku_ids);

// 句、プロフ画像、名前取得
$bad_haikus_info = array();
foreach ($bad_haiku_rank as $bad_haiku) {
  $sql = 'SELECT * FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE `haiku_id`=?';
  $data = array($bad_haiku[0]);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $bad_record = $stmt->fetch(PDO::FETCH_ASSOC);
  $bad_haikus_info[] = $bad_record;
}

foreach ($bad_haikus_info as $bad_haiku_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  echo $bad_haiku_info['nick_name'];
  echo '<br>';
  echo $bad_haiku_info['haiku_1'];
  echo '<br>';
  echo $bad_haiku_info['haiku_2'];
  echo '<br>';
  echo $bad_haiku_info['haiku_3'];
  echo "<br>" . "<br>";
}

foreach ($bad_haiku_rank as $bad_haiku) { //(良し数)
  echo $bad_haiku[1] . '<br>';
}


// よしランキング歌人用sql文
$sql = 'SELECT * FROM `dislikes`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$bad_member_ids = array();
while($dislike_member = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $bad_member_ids[] = $dislike_member['haiku_member_id'];
}

$bad_member_rank = rankGet($bad_member_ids);

// プロフ画像、名前取得
$bad_members_info = array();
foreach ($bad_member_rank as $bad_member) {
  $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $data = array($bad_member[0]);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $bad_member_record = $stmt->fetch(PDO::FETCH_ASSOC);
  $bad_members_info[] = $bad_member_record;
}

foreach ($bad_members_info as $bad_member_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  echo $bad_member_info['nick_name'];
  echo '<br>' . '<br>';
}

foreach ($bad_member_rank as $bad_member) { //(良し数)
  echo $bad_member[1];
  echo '<br>';
}


// 関数を使った処理
function rankGet($array_ids) {                  // $array_idsは配列
  $pure_ids = array_count_values($array_ids);   // 重複する値の数を数得て、その値とその数をペアにした連想配列を作る
  arsort($pure_ids);                            // 連想配列の値をもとに大きい順に並び変える
  $array_ranks = array();                       // ランキング上位3つのidを入れるからの配列を作る
  for ($i=0; $i < 3; $i++) {                    // 3位とってくるので3回繰り返す
    $rank_id = key($pure_ids);                  // 連想配列のポインタのあるキーを取ってくる（○位を取ってくる）
    $value_num = $pure_ids["$rank_id"];         // よし・あし数取得
    $array_rank = array($rank_id, $value_num); // 配列にいれる
    $array_ranks[] = $array_rank;               // 取得したidを配列に入れる
    next($pure_ids);                            // 隣のポインタに移す
  }
  return $array_ranks;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <?php foreach ($haikus_info as $haiku_info) : ?>
    <a href="profile.php"><?php echo $haiku_info['nick_name']; ?></a><br>
    <a href="profile.php"><?php echo $member_info['nick_name']; ?></a><br>
    <a href="profile.php"><?php echo $bad_haiku_info['nick_name']; ?></a><br>
    <a href="profile.php"><?php echo $bad_member_info['nick_name']; ?></a><br>
  <?php endforeach; ?>
  <?php echo '<br>'; ?>
  <?php foreach ($haikus_info as $haiku_info): ?>
    <img src="assets/images/<?php echo $haiku_info['user_picture_path']; ?>" width="100" height="100">
    <img src="assets/images/<?php echo $member_info['user_picture_path']; ?>" width="100" height="100">
    <img src="assets/images/<?php echo $bad_haiku_info['user_picture_path']; ?>" width="100" height="100">
    <img src="assets/images/<?php echo $bad_member_info['user_picture_path']; ?>" width="100" height="100">
  <?php endforeach; ?>
</body>
</html>
