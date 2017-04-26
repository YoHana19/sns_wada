<?php 
session_start();
require ('dbconnect.php');

$_SESSION['login_member_id']=1;

// ログインユーザー情報の取得
$sql = 'SELECT * FROM  `members`';
$data =array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_member = $stmt->fetch(PDO::FETCH_ASSOC);


// roomsテーブルから新着チャットを10件取得
$sql = 'SELECT * FROM `rooms` WHERE `member_id_1`=? OR `member_id_2`=? ORDER BY modified DESC LIMIT 0, 10';
$data = array($_SESSION['login_member_id'], $_SESSION['login_member_id']);
$room_stmt = $dbh->prepare($sql);
$room_stmt->execute($data);

// 各チャットの友達情報を取得
$rooms = array();
while ($record = $room_stmt->fetch(PDO::FETCH_ASSOC)) {
  if ($record['member_id_1'] == $_SESSION['login_member_id']) {
    $sql = 'SELECT * FROM `members` WHERE member_id = ?';
    $data = array($record['member_id_2']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
  } else {
    $sql = 'SELECT * FROM `members` WHERE member_id = ?';
    $data = array($record['member_id_1']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  $rooms[] = $room;
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
    <img src="assets/images/<?php echo $login_member['user_picture_path']; ?>" width="50" height="50">
    <br>
    <a href="profile.php"><?php echo $login_member['nick_name'];?></a>
    <p><?php echo $login_member['self_intro'];?></p>
    <p><?php echo $login_member['bozu_points'];?>point</p>

    <!-- 友達情報 -->
    <p>
      <?php foreach ($rooms as $room) { ?>
        <img src="assets/images/<?php echo $room['user_picture_path']; ?>" width="50" height="50">
        <br>
        <a href="user.php?member_id=<?php echo $room['member_id']; ?>"><?php echo $room['nick_name'];?></a>
        <br>
        <?php echo $room['self_intro'];?>
        <br>
      <?php } ?>
    </p>
  </div>
</body>
</html>


