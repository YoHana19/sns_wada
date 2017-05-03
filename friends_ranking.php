<?php
session_start();
require('dbconnect.php');

// 友達内ランキングよし(歌人)用sql文
$sql = 'SELECT * FROM `likes` AS l LEFT JOIN `friends` AS f ON l.haiku_member_id=f.friend_member_id WHERE f.login_member_id=? AND f.state=1';
$data = array($_SESSION['login_member_id']); //$dataには ? に入れる値を書く
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$like_haiku_ids = array();
while($like_haiku = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $like_haiku_ids[] = $like_haiku['haiku_id'];
}

$like_haiku_rank = rankGet($like_haiku_ids);

// プロフ画像、名前取得
$like_haikus_info = array();
foreach ($like_haiku_rank as $like_haiku) {
  $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $data = array($like_haiku[0]);
  $stmt = $dbh->prepare();
  $stmt->execute($data);

  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  $like_haikus_info[] = $record;
}

foreach ($like_haikus_info as $like_haiku_info) {
  echo $like_haiku_info['nick_name'];
  echo "<br>" . "<br>";
}

foreach ($like_haiku_rank as $like_haiku) { //(良し数)
  echo $like_haiku[1] . '<br>';
}


// 友達内ランキングあし(歌人)用sql文
$sql = 'SELECT * FROM `dislikes` AS l LEFT JOIN `friends` AS f ON l.haiku_member_id=f.friend_member_id WHERE f.login_member_id=? AND f.state=1';
$data = array($_SESSION['login_member_id']); //$dataには ? に入れる値を書く
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$dislike_haiku_ids = array();
while($dislike_haiku = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $dislike_haiku_ids[] = $dislike_haiku['haiku_id'];
}

$dislike_haiku_rank = rankGet($dislike_haiku_ids);

// プロフ画像、名前取得
$dislike_haikus_info = array();
foreach ($dislike_haiku_rank as $dislike_haiku) {
  $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $data = array($dislike_haiku[0]);
  $stmt = $dbh->prepare();
  $stmt->execute($data);

  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  $dislike_haikus_info[] = $record;
}

foreach ($dislike_haikus_info as $dislike_haiku_info) {
  echo $dislike_haiku_info['nick_name'];
  echo "<br>" . "<br>";
}

foreach ($dislike_haiku_rank as $dislike_haiku) { //(良し数)
  echo $dislike_haiku[1] . '<br>';
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
