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

// //↓重複する値を一致させ、非破壊的関数のため変数に代入
// array_count_values($haiku_ids);            //この時点ではhaiku_idsには変更がない
// $pure_ids = array_count_values($haiku_ids);//ここで変数に代入し、変更させる


// // 一致したものが最も多いもの上位3件文取得
// // arsortでキーを昇順に並び替える
// arsort($pure_ids);
// $key = key($pure_ids);
// echo $key . '<br>';

// next($pure_ids);
// $key1 = key($pure_ids);
// echo $key1 . '<br>';

// next($pure_ids);
// $key2 = key($pure_ids);
// echo $key2 . '<br>' . '<br>';

$haiku_rank = rankGet($haiku_ids);

// 句、プロフ画像、名前取得
$haikus_info = array();
foreach ($haiku_rank as $haiku) {
  $sql = 'SELECT * FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE `haiku_id`=?';
  $data = array($haiku[0]); //
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  $haikus_info[] = $record;
}

foreach ($haikus_info as $haiku_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  echo $haiku_info['nick_name'];
  echo $haiku_info['haiku_1'];
  echo $haiku_info['haiku_2'];
  echo $haiku_info['haiku_3'];
  echo "<br>";
}

foreach ($haiku_rank as $haiku) { //(良し数)
  echo $haiku[1];
}

// while($like_key = $stmt->fetch(PDO::FETCH_ASSOC)) {
//   echo $like_key['haiku_id'];
//   echo $like_key['nick_name'];
//   echo $like_key['user_picture_path'] . '<br>';
// }
// echo '<br>';

// // よしランキング歌人用sql
// $sql = 'SELECT * FROM `likes`';
// $stmt = $dbh->prepare($sql);
// $stmt->execute();

// $haiku_member_ids = array();
// while($like_member = $stmt->fetch(PDO::FETCH_ASSOC)) {
//   $haiku_member_ids[] = $like_member['haiku_member_id'];
// }

// array_count_values($haiku_member_ids);
// $pure_member_ids = array_count_values($haiku_member_ids);
// arsort($pure_member_ids);

// $member_key = key($pure_member_ids);
// echo $member_key . '<br>';

// next($pure_member_ids);
// $member_key_1 = key($pure_member_ids);
// echo $member_key_1 . '<br>';

// next($pure_member_ids);
// $member_key_2 = key($pure_member_ids);
// echo $member_key_2 . '<br>' . '<br>';

// // $sql = sprintf('SELECT t.*, m.nick_name, m.picture_path FROM `tweets` AS t LEFT JOIN `members` AS m ON t.member_id=m.member_id ORDER BY t.created DESC LIMIT %d,5' , $start);

// // あしランキング句用sql文
// $sql = 'SELECT * FROM `dislikes`';
// $stmt = $dbh->prepare($sql);
// $stmt->execute();

// $bad_haiku_ids = array();
// while($dislike_haiku = $stmt->fetch(PDO::FETCH_ASSOC)) {
//   $bad_haiku_ids[] = $dislike_haiku['haiku_id'];
// }

// array_count_values($bad_haiku_ids);
// $bad_pure_ids = array_count_values($bad_haiku_ids);
// arsort($bad_pure_ids);

// $bad_key = key($bad_pure_ids);
// echo $bad_key . '<br>';

// next($bad_pure_ids);
// $bad_key_1 = key($bad_pure_ids);
// echo $bad_key_1 . '<br>';

// next($bad_pure_ids);
// $bad_key_2 = key($bad_pure_ids);
// echo $bad_key_2 . '<br>' . '<br>';

// // あしランキング歌人用sql分
// $sql = 'SELECT * FROM `dislikes`';
// $stmt = $dbh->prepare($sql);
// $stmt->execute();

// $bad_member_ids = array();
// while($dislike_member = $stmt->fetch(PDO::FETCH_ASSOC)) {
//   $bad_member_ids[] = $dislike_member['haiku_member_id'];
// }

// array_count_values($bad_member_ids);
// $bad_member_ids = array_count_values($bad_member_ids);
// arsort($bad_member_ids);

// $member_key = key($bad_member_ids);
// echo $member_key . '<br>';

// next($bad_member_ids);
// $member_key_1 = key($bad_member_ids);
// echo $member_key_1 . '<br>';

// next($bad_member_ids);
// $member_key_2 = key($bad_member_ids);
// echo $member_key_2 . '<br>';

function rankGet($array_ids) { // $array_idsは配列
  $pure_ids = array_count_values($array_ids); // 重複する値の数を数得て、その値とその数をペアにした連想配列を作る
  arsort($pure_ids); // 連想配列の値をもとに大きい順に並び変える
  $array_ranks = array(); // ランキング上位3つのidを入れるからの配列を作る
  for ($i=0; $i < 3; $i++) { // 3位とってくるので3回繰り返す
    $rank_id = key($pure_ids); // 連想配列のポインタのあるキーを取ってくる（○位を取ってくる）
    $value_num = $pure_ids["$rank_id"];
    $array_rank = array($rank_id, $value_num);
    $array_ranks[] = $array_rank; // 取得したidを配列に入れる
    next($pure_ids); // 隣のポインタに移す
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
</body>
</html>