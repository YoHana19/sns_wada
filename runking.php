<?php
session_start();
require('dbconnect.php');
// ランキングよし・あし、俳人・句それぞれのランキング上位3件を取ってくる

// よしランキング句用sql文
$sql = 'SELECT * FROM `likes`';
$like_stmt = $dbh->prepare($sql);
$like_stmt->execute();

// ↓sql文で取得したデータを配列化
$haiku_ids = array();
while($evaluation_like = $like_stmt->fetch(PDO::FETCH_ASSOC)) {
  $haiku_ids[] = $evaluation_like['haiku_id'];
} //        ↑ここで配列化 []を使うと、[1]-> [1,2]-> [1,2,3]...のように新しい数を配列の最後尾にいれる

//↓重複する値を一致させ、非破壊的要素のため変数に代入
array_count_values($haiku_ids);
$pure_ids = array_count_values($haiku_ids);

// 一致したものが最も多いもの上位3件文取得
// ksortでキーを昇順に並び替える
ksort($pure_ids);
print_r($pure_ids);
$key = key($pure_ids);

echo $key;
next($pure_ids);
$key1 = key($pure_ids);

echo $key1;
next($pure_ids);
$key2 = key($pure_ids);
echo $key2;

// sql文で上位3件分データ取得
$sql = 'SELECT * FROM `likes` WHERE `haiku_id`';
$good_stmt_1 = $dbh->prepare($sql);
$good_stmt_1->execute();
$evaluation_like_1 = $good_stmt_1->fetch(PDO::FETCH_ASSOC);
// echo $evaluation_like_1['haiku_id'];
key($evaluation_like_1);
// var_dump($evaluation_like_1);



// よしランキング俳人用sql分
$sql = 'SELECT * FROM `likes`';
$like_member_stmt = $dbh->prepare($sql);
$like_member_stmt->execute();

$haiku_g_member_ids = array();
while($evaluation_like_member = $like_member_stmt->fetch(PDO::FETCH_ASSOC)) {
  $haiku_g_member_ids[] = $evaluation_like_member['haiku_member_id'];
}

array_count_values($haiku_g_member_ids);
$pure_g_member_ids = array_count_values($haiku_g_member_ids);

ksort($pure_g_member_ids);
print_r($pure_g_member_ids);
$good_member_key = key($pure_g_member_ids);

echo $good_member_key;
next($pure_g_member_ids);
$good_member_key_1 = key($pure_g_member_ids);

echo $good_member_key_1;
next($pure_g_member_ids);
$good_member_key_2 = key($pure_g_member_ids);
echo $good_member_key_2;

// sql文で上位3件分データ取得
$sql = 'SELECT * FROM `likes` WHERE `haiku_member_id`';
$good_member_stmt_1 = $dbh->prepare($sql);
$good_member_stmt_1->execute();
$evaluation_member_like_1 = $good_member_stmt_1->fetch(PDO::FETCH_ASSOC);
// echo $evaluation_like_1['haiku_id'];
key($evaluation_member_like_1);
// var_dump($evaluation_like_1);



// あしランキング用sql文
$sql = 'SELECT * FROM `dislikes`';
$dislike_stmt = $dbh->prepare($sql);
$dislike_stmt->execute();

// ↓sql文で取得したデータを配列化
$bad_haiku_ids = array();
while($evaluation_dislike = $dislike_stmt->fetch(PDO::FETCH_ASSOC)) {
  $bad_haiku_ids[] = $evaluation_dislike['haiku_id'];
} //        ↑ここで配列化 []を使うと、[1]-> [1,2]-> [1,2,3]...のように新しい数を配列の最後尾にいれる

//↓重複する値を一致させ、非破壊的要素のため変数に代入
array_count_values($bad_haiku_ids);
$bad_pure_ids = array_count_values($bad_haiku_ids);

// 一致したものが最も多いもの上位3件文取得
// ksortでキーを昇順に並び替える
ksort($bad_pure_ids);

print_r($bad_pure_ids);
$bad_key = key($bad_pure_ids);
echo $bad_key;

next($bad_pure_ids);
$bad_key_1 = key($bad_pure_ids);
echo $bad_key_1;

next($bad_pure_ids);
$bad_key_2 = key($bad_pure_ids);
echo $bad_key_2;

// sql文で上位3件分データ取得
$sql = 'SELECT * FROM `dislikes` WHERE `haiku_id`';
$bad_stmt_1 = $dbh->prepare($sql);
$bad_stmt_1->execute();
$evaluation_dislike_1 = $bad_stmt_1->fetch(PDO::FETCH_ASSOC);
// echo $evaluation_like_1['haiku_id'];
key($evaluation_dislike_1);
// var_dump($evaluation_like_1);
// $data : sql文の中で「?」を使いたい時必要
?>