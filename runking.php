<?php
session_start();
require('dbconnect.php');

// ランキングよし・あし、俳人・句それぞれのランキング上位3件を取ってくる

$sql = 'SELECT * FROM `haikus` WHERE  ';
$data = array();
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$search_word = '';
if (isset($_GET['search_word']) && !empty($_GET['search_word'])) {
  // 検索の場合の処理
  $search_word= $_GET['search_word'];
  $sql = sprintf('SELECT t.*, m.nick_name, m.picture_path FROM `tweets` AS t LEFT JOIN `members` AS m ON t.member_id=m.member_id WHERE t.tweet LIKE "%%%s%%" ORDER BY t.created DESC LIMIT %d,5' , $_GET['search_word'], $start);
  // sprint('文字%_' . 'ほげ') → %_ が数字なら%d,  %_が文字なら%s
} else {
  // 通常の処理(検索していない場合の全件表示の処理)
  $sql = sprintf('SELECT t.*, m.nick_name, m.picture_path FROM `tweets` AS t LEFT JOIN `members` AS m ON t.member_id=m.member_id ORDER BY t.created DESC LIMIT %d,5' , $start);
  // $sql = 'SELECT t.*, m.nick_name, m.picture_path FROM `tweets` t `members` m WHERE t.member_id=m.member_id';
}
$stmt = $dbh->prepare($sql);
$stmt->execute();

 ?>