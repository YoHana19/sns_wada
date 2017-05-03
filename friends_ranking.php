<?php
session_start();
require('dbconnect.php');

// 友達内ランキングよし(歌人)用sql文
$sql = 'SELECT * FROM `likes` AS l LEFT JOIN `friends` AS f ON l.haiku_member_id=f.friend_member_id';
$data = array(); //$dataには ? に入れる値を書く
$stmt = $dbh->prepare($sql);
$stmt->execute();
$haiku_ids = array();
while($like_haiku = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $haiku_ids[] = $like_haiku['haiku_id'];
}

$haiku_rank = rankGet($haiku_ids);

// プロフ画像、名前取得
$haikus_info = array();
foreach ($haiku_rank as $haiku) {
  $sql = 'SELECT * FROM `friends` AS f LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE `haiku_id`=?';
  $data = array($haiku[0]);
  $stmt->execute($data);
  $stmt = $dbh->prepare();

  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  $haikus_info[] = $record;
}

foreach ($haikus_info as $haiku_info) {
  echo $haiku_info['nick_name'];
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

foreach ($members_info as $member_info) {
  echo $member_info['nick_name'];
  echo '<br>' . '<br>';
}

foreach ($member_rank as $member) { //(良し数)
  echo $member[1];
  echo '<br>';
}

function rankGet($array_ids) {                  // $array_idsは配列
  $pure_ids = array_count_values($array_ids);   // 重複する値の数を数得て、その値とその数をペアにした連想配列を作る
  arsort($pure_ids);                            // 連想配列の値をもとに大きい順に並び変える
  $array_ranks = array();                       // ランキング上位3つのidを入れるからの配列を作る
  for ($i=0; $i < 3; $i++) {                    // 3位とってくるので3回繰り返す
    $rank_id = key($pure_ids);                  // 連想配列のポインタのあるキーを取ってくる（○位を取ってくる）
    $value_num = $pure_ids["$rank_id"];         // よし・あし数取得
    $array_rank = array($rank_id, $value_num);  // 配列にいれる
    $array_ranks[] = $array_rank;               // 取得したidを配列に入れる
    next($pure_ids);                            // 隣のポインタに移す
  }
  return $array_ranks;
}

// ランキング上位3名のユーザー名、プロフィール画像取得

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

</body>
</html>