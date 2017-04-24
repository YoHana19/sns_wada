<?php 
session_start();
require ('dbconnect.php');

$_SESSION['login_member_id']=1;

$sql = 'SELECT * FROM  `members`';
$data =array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_member_id = $stmt->fetch(PDO::FETCH_ASSOC);






//roomsテーブルから新着順に10件

$sql = 'SELECT * FROM `rooms` WHERE sender_id = ? ORDER BY modified DESC LIMIT 1, 10';
$data1 = array($_SESSION['login_member_id']);
$stmt1 = $dbh->prepare($sql);
$stmt1->execute($data1);

$friends = array();
while ($chat = $stmt1->fetch(PDO::FETCH_ASSOC)) {
  $sql = 'SELECT * FROM `members` WHERE member_id = ?';
  $data2 = array($chat['reciever_id']);
  $stmt2 = $dbh->prepare($sql);
  $stmt2->execute($data2);
  $m = $stmt2->fetch(PDO::FETCH_ASSOC);

  $friends[]= array('member_id'=>$m['member_id'], 'nick_name'=>$m['nick_name'], 'user_picture_path'=>$m['user_picture_path'], 'self_intro'=>$m['self_intro']);
                
              }


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>


<div class="msg">
  <!-- ログインユーザー情報 -->
  <img src="assets/images/<?php echo $login_member_id['user_picture_path']; ?>" width="50" height="50">
  <br>
  <a href="profile.php"><?php echo $login_member_id['nick_name'];?></a>
  <p><?php echo $login_member_id['self_intro'];?></p>
  <p><?php echo $login_member_id['bozu_points'];?>point</p>

  <!-- 友達情報 -->
  <p>
    <?php foreach ($friends as $friend) { ?>
      <img src="assets/images/<?php echo $friend['user_picture_path']; ?>" width="50" height="50">
      <br>
      <a href="user.php?member_id=<?php echo $friend['member_id']; ?>"><?php echo $friend['nick_name'];?></a>
      <br>
      <?php echo $friend['self_intro'];?>
      <br>
    <?php } ?>
  </p>

</div>


</body>

</html>


