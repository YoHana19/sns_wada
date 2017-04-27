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

//↓重複する値を一致させ、非破壊的関数のため変数に代入
array_count_values($haiku_ids);
$pure_ids = array_count_values($haiku_ids);

// 一致したものが最も多いもの上位3件文取得
// arsortでキーを昇順に並び替える
arsort($pure_ids);
$key = key($pure_ids);

echo $key;
next($pure_ids);
$key1 = key($pure_ids);

echo $key1;
next($pure_ids);
$key2 = key($pure_ids);
echo $key2 . '<br>';


// よしランキング歌人用sql分
$sql = 'SELECT * FROM `likes`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$haiku_member_ids = array();
while($like_member = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $haiku_member_ids[] = $like_member['haiku_member_id'];
}

array_count_values($haiku_member_ids);
$pure_member_ids = array_count_values($haiku_member_ids);


arsort($pure_member_ids);
$member_key = key($pure_member_ids);

echo $member_key;
next($pure_member_ids);
$member_key_1 = key($pure_member_ids);

echo $member_key_1;
next($pure_member_ids);
$member_key_2 = key($pure_member_ids);
echo $member_key_2 . '<br>';


// あしランキング句用sql文
$sql = 'SELECT * FROM `dislikes`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$bad_haiku_ids = array();
while($dislike_haiku = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $bad_haiku_ids[] = $dislike_haiku['haiku_id'];
}

array_count_values($bad_haiku_ids);
$bad_pure_ids = array_count_values($bad_haiku_ids);

arsort($bad_pure_ids);

$bad_key = key($bad_pure_ids);
echo $bad_key;

next($bad_pure_ids);
$bad_key_1 = key($bad_pure_ids);
echo $bad_key_1;

next($bad_pure_ids);
$bad_key_2 = key($bad_pure_ids);
echo $bad_key_2 . '<br>';


// あしランキング歌人用sql分
$sql = 'SELECT * FROM `dislikes`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$bad_member_ids = array();
while($dislike_member = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $bad_member_ids[] = $dislike_member['haiku_member_id'];
}

array_count_values($bad_member_ids);
$bad_member_ids = array_count_values($bad_member_ids);

arsort($bad_member_ids);
$member_key = key($bad_member_ids);

echo $member_key;
next($bad_member_ids);
$member_key_1 = key($bad_member_ids);

echo $member_key_1;
next($bad_member_ids);
$member_key_2 = key($bad_member_ids);
echo $member_key_2 . '<br>';

?>