<?php 
require('dbconnect.php');
require('function.php');

// ページ名の取得
$file_name = getFileNameFromUri();

// ログインユーザー情報の取得
$sql = 'SELECT * FROM  `members` WHERE `member_id`=?';
$data =array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_member = $stmt->fetch(PDO::FETCH_ASSOC);


if ($file_name == 'timeline.php') {
  $key_id = $_SESSION['login_member_id'];
} else {
  $key_id = $_REQUEST['user_id'];
}

// roomsテーブルから新着チャットを10件取得
$sql = 'SELECT * FROM `rooms` WHERE `member_id_1`=? OR `member_id_2`=? ORDER BY modified DESC LIMIT 0, 10';
$data = array($key_id, $key_id);

$room_stmt = $dbh->prepare($sql);
$room_stmt->execute($data);

// 各チャットの友達情報を取得
$rooms = array();
while ($record = $room_stmt->fetch(PDO::FETCH_ASSOC)) {

  if ($record['member_id_1'] == $key_id) {

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

</a>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>


  <!-- タイムラインページだったら -->
  <?php if($file_name == 'timeline.php'): ?>

      <!-- 簡易個人プロフ -->
      <div class="left-proph">
        <img src="assets/images/<?php echo $login_member['user_picture_path']; ?>" id="photo">
        <h3><?php echo $login_member['nick_name'];?></h3>
        <span class="intro-text-3"><?php echo tateGaki($login_member['self_intro_1']); ?></span>
        <span class="intro-text-2"><?php echo tateGaki($login_member['self_intro_2']); ?></span>
        <span class="intro-text-1"><?php echo tateGaki($login_member['self_intro_3']); ?></span>
      </div>
      <div class="clearfix"></div>

  <?php endif; ?>

  <div class="friends-display">
    <!-- タイトル表示 -->
    <div class="friends-title">
      <span class="title">お仲間</span>
    </div>

    <!-- 直近連絡とった友達順に10件表示 -->
    <div class="well_3">
      <?php foreach ($rooms as $room) { ?>
          <div class="media" style="position: relative; margin-top: 7px">
            <a class="pull-left left-photo" href="user.php?user_id=<?php echo $room['member_id']; ?>">
              <img class="media-object" src="assets/images/<?php echo $room['user_picture_path']; ?>" style="width: 55px; height: 55px; border-radius: 50%">
            </a>
            <div class="media-body left-display">
              <span class="media-heading left-nickname"><?php echo $room['nick_name'];?></span>
              <p class="left-intro"><?php echo $room['self_intro_1'];?>&nbsp;<?php echo $room['self_intro_2'];?>&nbsp;<?php echo $room['self_intro_3'];?></p>
            </div>
          </div>
      <?php } ?>
    </div>
  </div>
</body>
</html>


