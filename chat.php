<?php
session_start();
require('dbconnect.php');

// ログインユーザー（仮）
$_SESSION['login_member_id'] = 2;

// 入れ物用意
$friend_id = '';
$room_id = '';

// 友達選択された時→チャット表示
if (isset($_GET['friend_id'])) {
  $friend_id = $_GET['friend_id'];

  // チャット相手の名前取得
  $sql = 'SELECT `nick_name` FROM `members` WHERE `member_id`=?';
  $data = array($friend_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $chat_name = $stmt->fetch(PDO::FETCH_ASSOC);

  // room_idの取得
  $sql = 'SELECT `room_id` FROM `rooms` WHERE `member_id_1`=? AND `member_id_2`=? OR `member_id_1`=? AND`member_id_2`=?';
  $data = array($_SESSION['login_member_id'], $friend_id, $friend_id, $_SESSION['login_member_id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  $room_id = $record['room_id'];
  echo $room_id;

  // チャットの取得
  $sql = 'SELECT c.*, m.nick_name, m.user_picture_path FROM `chats` AS c LEFT JOIN `members` AS m ON c.sender_id=m.member_id WHERE c.room_id=? ORDER BY c.created DESC';
  $data = array($room_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $chats = array();
  while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // whileの外に用意した配列に入れる
    $chats[] = $record;
  }
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
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/chat.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- For Modal Window -->
  <link rel="stylesheet" type="text/css" href="assets/css/modal_window.css">
</head>
<body>

  <div class="container">
    <div class="row">
      <!-- チャット一覧 -->
      <div class="col-md-3 chat-list">
        <?php require('chat_left.php'); ?>
      </div>

      <!-- 個人チャット画面 -->
      <div class="col-md-8 chat-private">
        <div class="outer">
          <div class="page-header">
            <h2><?php echo $chat_name['nick_name'] ?></h2>
          </div>
        </div>

        <section class="comment-list">

          <?php foreach ($chats as $chat) { ?>

            <?php if ($chat['sender_id'] == $_SESSION['login_member_id']): ?>

              <!-- ログインユーザー -->
              <article class="row">
                <div class="col-md-10 col-sm-10">
                  <p class="chat-name" style="text-align: right;"><?php echo $chat['nick_name']; ?></p>
                  <div class="panel panel-default arrow right user-right">
                    <div class="panel-body">
                      <header class="text-right">
                        <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i><?php echo $chat['created']; ?></time>
                      </header>
                      <div class="haiku-text">
                        <p class="haiku-text-1"><?php echo tateGaki($chat['chat_3']); ?></p>
                        <p class="haiku-text-2"><?php echo tateGaki($chat['chat_2']); ?></p>
                        <p class="haiku-text-3"><?php echo tateGaki($chat['chat_1']); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2 col-sm-2 hidden-xs">
                  <figure class="thumbnail" style="border-radius: 50%; background-color: #fffffc;">
                    <img class="img-responsive" src="assets/images/<?php echo $chat['user_picture_path']; ?>" style="border-radius: 50%;">
                  </figure>
                </div>
              </article>

            <?php else: ?>

              <!-- チャット相手 -->
              <article class="row">
                <div class="col-md-2 col-sm-2 hidden-xs">
                  <figure class="thumbnail" style="border-radius: 50%; background-color: #fffffc;">
                    <img class="img-responsive" src="assets/images/<?php echo $chat['user_picture_path']; ?>" style="border-radius: 50%;">
                   </figure>
                </div>
                <div class="col-md-10 col-sm-10">
                  <p class="chat-name"><?php echo $chat['nick_name']; ?></p>
                  <div class="panel panel-default arrow left user-left">
                    <div class="panel-body">
                      <header class="text-left">
                        <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i><?php echo $chat['created']; ?></time>
                      </header>
                      <div class="haiku-text">
                        <p class="haiku-text-1"><?php echo tateGaki($chat['chat_3']); ?></p>
                        <p class="haiku-text-2"><?php echo tateGaki($chat['chat_2']); ?></p>
                        <p class="haiku-text-3"><?php echo tateGaki($chat['chat_1']); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </article>
            <?php endif; ?>

          <?php } ?> <!-- 繰り返し文終了 -->

          <!-- 句入力ボタン -->
          <button type="submit" id="modal-open" class="btn icon-btn btn-info" style="background-color: #d0576b; border-color: #d0576b;"><span class="glyphicon btn-glyphicon glyphicon-share img-circle text-info" style="color: #d0576b"></span> 詠む</button>

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

              <!-- 一言説明 -->
              <input type="text" class="form-control" id="short_comment" name="short_comment" placeholder="一言説明（二十文字以下）" style="display: none;"><br>
              <p id="short_comment_valid" style="display: none">二十文字以内で入力してください</p>


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

        </section>
      </div>
    </div>
  </div>

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