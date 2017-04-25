<?php
session_start();
require('dbconnect.php');

// ランキングよし・あし、俳人・句それぞれのランキング上位3件を取ってくる

// よしランキング用sql文
$sql = 'SELECT * FROM `likes`';
$like_stmt = $dbh->prepare($sql);
$like_stmt->execute();

// ↓sql文で取得したデータを配列化
$haiku_ids = array();
while($evaluation_like = $like_stmt->fetch(PDO::FETCH_ASSOC)) {
  $haiku_ids[] = $evaluation_like['haiku_id'];
} //        ↑ここで配列化 []を使うと、[1]-> [1,2]-> [1,2,3]...のように新しい数を配列の最後尾にいれる

// 配列化されたデータの中で最も一致するものが多いデータを表示
print_r(array_count_values($haiku_ids));

echo '<pre>';
var_dump($haiku_ids);
echo '</pre>';


// あしランキング用sql文
$sql = 'SELECT * FROM `dislikes`';
$dislike_stmt = $dbh->prepare($sql);
$dislike_stmt->execute();
$evaluation_like = $dislike_stmt->fetch(PDO::FETCH_ASSOC);
 // $data : sql文の中で「?」を使いたい時必要


//  // 配列
// // 値を複数入れるタンス
// // $配列名 = array(値1, 値2, 値3);
// $members = array('Kensuke', 'Taka', 'Saki', 'Hayato'); //定義
// echo $members[1]; //使用
?>