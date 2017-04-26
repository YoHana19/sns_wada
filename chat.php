<?php
session_start();
require('dbconnect.php');
$_SESSION['login_member_id'] = 1;
$friend_id = 2;
$room_id = 1;

$sql = sprintf('SELECT c.*, m.nick_name, m.user_picture_path FROM `chats` AS c LEFT JOIN `members` AS m ON c.sender_id=m.member_id WHERE c.sender_id LIKE %d AND c.reciever_id LIKE %d OR c.sender_id LIKE %d AND c.reciever_id LIKE %d ORDER BY c.created DESC', $_SESSION['login_member_id'], $friend_id, $friend_id, $_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute();

// 空の配列を定義
$chats = array();

while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
  // whileの外に用意した配列に入れる
  $chats[] = $record;
}

// 縦書きにする関数
function tateGaki($haiku) {
  $matches = preg_split("//u", $haiku, -1, PREG_SPLIT_NO_EMPTY);
  $v_haiku = '';
  foreach ($matches as $letter) {
    $v_haiku .= $letter . "<br>";
  }
  return rtrim($v_haiku, "<br>");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <!-- Bootstrap -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/css/font-awesome.css" rel="stylesheet">
  <!-- For Modal Window -->
  <link rel="stylesheet" type="text/css" href="assets/css/modal_window.css">
</head>
<body>

  <!-- 詠むボタン（MWの呼び出し） -->
  <input type="submit" id="modal-open" class="btn btn-info" value="詠む" style="background-color: #00a381;">

  <!-- 句入力フォーム -->
  <div id="modal-content_1" class="content">
    <form action="send_haiku.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
      <!-- 句入力 -->
      <input type="text" class="form-control haiku" id="up_haiku" name="up_haiku" placeholder="１行目（四〜六文字）"><br>
      <p id="up_haiku_valid" style="display: none">四から六文字で入力してください</p>
      
      <input type="text" class="form-control haiku" id="md_haiku" name="md_haiku" placeholder="２行目（四〜六文字）"><br>
      <p id="md_haiku_valid" style="display: none">六から八文字で入力してください</p>
      
      <input type="text" class="form-control haiku" id="lw_haiku" name="lw_haiku" placeholder="３行目（四〜六文字）"><br>
      <p id="lw_haiku_valid" style="display: none">四から六文字で入力してください</p>

      <!-- 写真挿入 -->
      <div>
        <input type="file" id="photo_file" name="photo_file" style="display:none;" onchange="changePhotoFile();">
        <img id="photo_img" src="assets/images/photo_submit.png" alt="参照" width="30px" height="30px">
        <input id="photo_display" type="text" name="photo_display" value="" size="50">
      </div>

      <!-- 詠むボタン -->
      <div id="yomu">
        <button type="button" id="yomu_pre" class="btn btn-info" style="background-color: #c8c2c6; border-color: #c8c2c6;">詠む</button>
        <input id="yomu_ready" type="submit" class="btn btn-info" value="詠む" style="background-color: #00a381; display: none;">
      </div>

      <!-- 戻るボタン -->
      <button type="button" id="modal-close" class="btn btn-info" style="background-color: #c8c2c6; border-color: #c8c2c6;">戻る</button>

      <!-- チャット相手のid -->
      <input type="hidden" name="friend_id" value="<?php echo $friend_id ?>">

      <!-- ルームのid -->
      <input type="hidden" name="room" value="<?php echo $room_id ?>">

      <!-- タイムライン or チャット 判別 -->
      <input type="hidden" name="page" value="chat">
    </form>
  </div>

  <?php foreach ($chats as $chat) { ?>

    <?php if ($chat['sender_id'] == $_SESSION['login_member_id']): ?>
      <!-- ログインユーザーは右表示 -->
      <div class="login_user" style="float: right;">
        <div><?php echo $chat['nick_name']; ?></div>
        <img src="assets/images/<?php echo $chat['user_picture_path']; ?>" width="100" height="100"><br>
        <div><?php echo $chat['chat_1']; ?></div>
        <div><?php echo $chat['chat_2']; ?></div>
        <div><?php echo $chat['chat_3']; ?></div>
        <?php echo tateGaki($chat['chat_1']); ?>
      </div>
    <?php else: ?>
      <!-- 友達は左表示 -->
      <div class="friend" style="float: left;">
        <div><?php echo $chat['nick_name']; ?></div>
        <img src="assets/images/<?php echo $chat['user_picture_path']; ?>" width="100" height="100"><br>
        <div><?php echo $chat['chat_1']; ?></div>
        <div><?php echo $chat['chat_2']; ?></div>
        <div><?php echo $chat['chat_3']; ?></div>
        <?php echo tateGaki($chat['chat_1']); ?>
      </div>
    <?php endif; ?>

  <?php } ?> <!-- 繰り返し文終了 -->

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <!-- モーダルウィンドウ -->
  <script src="assets/js/modal_window.js"></script>
  <!-- 俳句入力 -->
  <script src="assets/js/haiku_input.js"></script>

  <script>
    // 1番最初のモーダルウィンドウ呼び出し
    modalWindowOnFirst('modal-open');

    // 2番目のモーダルウィンドウ呼び出し
    // modalWindowOn('modal-check', 'modal-content_1', 'modal-content_2');

    // モーダルウィンドウの終了
    modalWindowOff('modal-close', 'modal-content_1');

    //リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
    $(window).resize(centeringModalSyncer);
  </script>
</body>
</html>