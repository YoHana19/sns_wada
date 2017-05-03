<?php
require('dbconnect.php');

// チャットルーム取得
// roomsテーブルから新着順でチャットルームを取得
$sql = 'SELECT * FROM `rooms` WHERE `member_id_1`=? OR `member_id_2`=? ORDER BY modified DESC';
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
  
  <!-- 検索フォーム -->
  <form action="friends.php" method="GET" accept-charset="utf-8" class="form-horizontal">
    <div id="custom-search-input">
      <div class="input-group">
        <input type="text" name="search_word" class="search-query form-control" placeholder=" 友達検索" value="<?php echo $search_word ?>">
        <span class="input-group-btn">
          <button class="btn btn-danger" type="submit">
            <span class="glyphicon glyphicon-search" style="color: #dcdddd"></span>
          </button>
        </span>
      </div>
    </div>
  </form>

  <div class="friends-display">
    <!-- タイトル表示 -->
    <div class="friends-title">
      <span class="title">お仲間</span>
    </div>

    <!-- 友達一覧 -->
    <div class="well_3">
      <?php foreach ($rooms as $room) { ?>
        <form action="chat.php" method="GET" accept-charset="utf-8">
          <button type="submit">
            
            <?php
              // 各チャットの最新の句を一件取得
              $sql = 'SELECT * FROM `chats` WHERE `room_id`=? ORDER BY created DESC';
              $data = array($room_id);
              $stmt = $dbh->prepare($sql);
              $stmt->execute($data);
              $latest_chat = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

            <div class="media" style="position: relative; margin-top: 7px">
              <div class="pull-left left-photo" href="#">
                <img class="media-object" src="assets/images/<?php echo $room['user_picture_path']; ?>" style="width: 55px; height: 55px; border-radius: 50%">
              </div>
              <div class="media-body left-display">
                <span class="media-heading left-nickname"><?php echo $room['nick_name'];?></span>
                <p class="left-intro"><?php echo $latest_chat['chat_1'];?>&nbsp;<?php echo $latest_chat['chat_2'];?>&nbsp;<?php echo $latest_chat['chat_3'];?></p>
              </div>
            </div>
            <!-- チャット相手のidの取得 -->
            <input type="hidden" name="friend_id" value="<?php echo $room['member_id']?>">
          </button>
        </form>
      <?php } ?>
    </div>
  </div>

</body>
</html>