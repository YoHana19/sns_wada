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
  $room = $room + array('room_id' => $record['room_id']);
  $rooms[] = $room;
}
?>

<!-- ** -->
<!-- htmlコンテンツ -->
<!-- ** -->

<!-- 検索フォーム -->
<form action="friends.php" method="GET" accept-charset="utf-8" class="form-horizontal">
  <div>
    <div class="input-group">
      <input type="text" name="search_word" class="search-query form-control" placeholder=" 友達検索" value="">
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
    <span class="title">新着チャット</span>
  </div>

  <!-- 友達一覧 -->
  <div class="left-wrap">
    <?php foreach ($rooms as $room) { ?>
      <form action="chat.php" method="GET" accept-charset="utf-8" style="margin-bottom: 0;">
        <button type="submit" class="btn chat-friend-btn">
          
          <?php
            // 各チャットの最新の句を一件取得
            $sql = 'SELECT * FROM `chats` WHERE `room_id`=? ORDER BY created DESC';
            $data = array($room['room_id']);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            $latest_chat = $stmt->fetch(PDO::FETCH_ASSOC);
          ?>

          <div class="media" style="position: relative; margin-top: 7px">
            <div class="pull-left left-photo">
              <img class="media-object" src="assets/images/<?php echo $room['user_picture_path']; ?>">
            </div>
            <div class="media-body left-text-info" style="text-align: left;">
              <span class="media-heading left-nickname" style="text-align: left; font-size: 14px;"><?php echo $room['nick_name'];?></span>
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
