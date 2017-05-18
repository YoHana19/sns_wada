<?php
session_start();
require('dbconnect.php');
require('function.php');

// ログイン判定プログラム
// ①$_SESSION['login_member_id']が存在している
// ②最後のアクション（ページの読み込みから）から1時間以内である
// Unixタイムスタンプとして取得します。Unixタイムスタンプとは1970年1月1日 00:00:00 GMTからの経過秒数です。PHP内部での日付や時刻の処理はUnixタイムスタンプで行われます。
if (isset($_SESSION['login_member_id']) && $_SESSION['time'] + 3600 > time()) {
  // ログインしている
  $_SESSION['time'] = time();

  $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $data = array($_SESSION['login_member_id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $login_member = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  // ログインしていない
  header('Location: index.php');
  exit();
}

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
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <!-- for Bootstrap -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <!-- For Modal Window -->
  <link rel="stylesheet" type="text/css" href="assets/css/mw_haiku_input.css">
  <!-- 全ページ共通 -->
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- 各ページ -->
  <link rel="stylesheet" type="text/css" href="assets/css/ranking.css">
  <link rel="stylesheet" type="text/css" href="assets/css/chat.css">
</head>
<body>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>

  <!-- ヘッダー -->
  <?php require('header.php'); ?>

  <div class="container">
    <div class="row whole-content">
      <!-- チャット一覧 -->
      <div class="col-md-3 left-content">
        <?php require('chat_left.php'); ?>
      </div>

      <!-- 個人チャット画面 -->
      <div class="col-md-8 right-content">

        <!-- チャット相手が選択された時 -->
        <?php if (isset($_GET['friend_id'])) { ?>
          <div class="outer">
            <div class="page-header">
              <h2><?php echo $chat_name['nick_name'] ?></h2>
            </div>
          </div>

          <section class="comment-list">

            <?php foreach ($chats as $chat) { ?>

              <?php if ($chat['sender_id'] == $_SESSION['login_member_id']){ ?>

                <!-- ログインユーザー -->
                <article class="row">
                  <div class="col-md-10 col-sm-10">
                    <p class="chat-name" style="text-align: right;"><?php echo $chat['nick_name']; ?></p>
                    <!-- 背景画像がある場合 -->
                    <?php if (!empty($chat['back_img'])): ?>
                      <div class="panel panel-default arrow right user-right" style="background: url(assets/images/users/<?php echo $chat['back_img']; ?>)">
                        <div class="layerTransparent-chat">
                          <div class="panel-body">
                            <header class="text-right">
                              <time class="comment-date" datetime="16-12-2014 01:05"><?php echo japaneseClock($chat['created']); ?>の刻</time>
                            </header>
                            <div class="haiku-text">
                              <p class="haiku-text-1" style="color: #524e4d;"><?php echo tateGaki($chat['chat_3']); ?></p>
                              <p class="haiku-text-2" style="color: #524e4d;"><?php echo tateGaki($chat['chat_2']); ?></p>
                              <p class="haiku-text-3" style="color: #524e4d;"><?php echo tateGaki($chat['chat_1']); ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- 背景画像がない場合 -->
                    <?php else: ?>
                      <div class="panel panel-default arrow right user-right">
                        <div class="panel-body">
                          <header class="text-right">
                            <time class="comment-date" datetime="16-12-2014 01:05"><?php echo japaneseClock($chat['created']); ?>の刻</time>
                          </header>
                          <div class="haiku-text">
                            <p class="haiku-text-1"><?php echo tateGaki($chat['chat_3']); ?></p>
                            <p class="haiku-text-2"><?php echo tateGaki($chat['chat_2']); ?></p>
                            <p class="haiku-text-3"><?php echo tateGaki($chat['chat_1']); ?></p>
                          </div>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="col-md-2 col-sm-2 hidden-xs" style="margin-top: 25px">
                    <figure class="thumbnail" style="border-radius: 50%; background-color: #fffffc;">
                      <img class="img-responsive" src="assets/images/users/<?php echo $chat['user_picture_path']; ?>" style="border-radius: 50%;">
                    </figure>
                  </div>
                </article>

              <?php } else { ?>

                <!-- チャット相手 -->
                <article class="row">
                  <div class="col-md-2 col-sm-2 hidden-xs" style="margin-top: 25px">
                    <figure class="thumbnail" style="border-radius: 50%; background-color: #fffffc;">
                      <img class="img-responsive" src="assets/images/users/<?php echo $chat['user_picture_path']; ?>" style="border-radius: 50%;">
                     </figure>
                  </div>
                  <div class="col-md-10 col-sm-10">
                    <p class="chat-name"><?php echo $chat['nick_name']; ?></p>
                    <div class="panel panel-default arrow left user-left">
                      <div class="panel-body">
                        <header class="text-left">
                          <time class="comment-date" datetime="16-12-2014 01:05"><?php echo japaneseClock($chat['created']); ?>の刻</time>
                          
                          
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
              <?php } ?>

            <?php } ?> <!-- 繰り返し文終了 -->

            <!-- 句入力ボタン -->
            <button type="submit" id="modal-open" class="btn icon-btn btn-info" style="background-color: #d0576b; border-color: #d0576b; font-size: 14px;"><span class="glyphicon btn-glyphicon fa fa-pencil-square img-circle text-info" style="color: #d0576b"></span> 詠む</button>

            <!-- LOGIN FORM -->
            <div id="modal-content_1" class="haiku-mw-content">
              <div class="text-center"">
                <div class="logo">
                  <img src="assets/images/source/yomu.png">
                </div>
                <!-- Main Form -->
                <div class="login-form-1">
                  <form action="send/send_haiku.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="login-form-main-message"></div>
                    <div class="main-login-form">
                      <div class="login-group">
                        <!-- 上の句 -->
                        <div class="form-group">
                          <label for="up_haiku" class="sr-only">Username</label>
                          <input type="text" class="form-control" id="up_haiku" name="up_haiku" placeholder="壱行目（四〜六文字）">
                          <p id="up_haiku_valid" class="haiku-input-err" style="display: none">四から六文字で入力してください</p>
                        </div>
                        <!-- 中の句 -->
                        <div class="form-group">
                          <label for="md_haiku" class="sr-only">Username</label>
                          <input type="text" class="form-control" id="md_haiku" name="md_haiku" placeholder="弐行目（六〜八文字）">
                          <p id="md_haiku_valid" class="haiku-input-err" style="display: none">六から八文字で入力してください</p>
                        </div>
                        <!-- 下の句 -->
                        <div class="form-group">
                          <label for="lw_haiku" class="sr-only">Username</label>
                          <input type="text" class="form-control" id="lw_haiku" name="lw_haiku" placeholder="参行目（四〜六文字）">
                          <p id="lw_haiku_valid" class="haiku-input-err" style="display: none">四から六文字で入力してください</p>
                        </div>

                        <!-- 画像送信 -->
                        <div class="form-group" style="margin-top: 15px; position: relative; padding-right: 0;">
                          <input type="file" id="photo_file" name="photo_file" style="display:none;" onchange="changePhotoFile();" accept="image/*">
                          <img id="photo_img" src="assets/images/source/photo_submit.png" alt="参照" class="img-submit">
                          <input id="photo_display" type="text" name="photo_display" value="" size="25" style="margin-left: 10px; width: 200px;">
                        </div>
                      </div>

                      <!-- 詠むボタン -->
                      <div id="yomu-chat">
                        <button type="button" id="yomu_pre" class="login-button" style="font-size: 16px;">詠</button>
                        <input id="yomu_ready" type="button" onclick="submit();" class="login-button" value="詠" style="font-size: 16px; background-color: #f8b862; color: #ffffff; display: none;">
                      </div>
                    </div>

                    <!-- チャット相手のid -->
                    <input type="hidden" name="friend_id" value="<?php echo $friend_id ?>">

                    <!-- ルームのid -->
                    <input type="hidden" name="room" value="<?php echo $room_id ?>">

                    <!-- タイムライン or チャット 判別 -->
                    <input type="hidden" name="page" value="chat">
                  </form>
                </div>
                <!-- end:Main Form -->

                <!-- 戻るボタン -->
                <div style="text-align: right;">
                  <button type="button" id="modal-close" class="btn btn-info input-back">戻る</button>
                </div>
              </div>
            </div>
          </section>
        <?php } else { ?>
          <!-- チャット相手非選択時 -->
          <?php require('friends_ranking.php'); ?> 
        <?php } ?>
      </div>
    </div>
  </div>

  <!-- フッター -->
  <?php require('footer.php') ?>

  <!-- モーダルウィンドウ -->
  <script src="assets/js/modal_window.js"></script>
  <!-- 俳句入力 -->
  <script src="assets/js/haiku_input.js"></script>
  <!-- スクロール固定 -->
  <script src="assets/js/scroll_fix.js"></script>

  <script>
    // 1番最初のモーダルウィンドウ呼び出し
    modalWindowOnFirst('modal-open', 'modal-content_1');

    // 2番目のモーダルウィンドウ呼び出し
    // modalWindowOn('modal-check', 'modal-content_1', 'modal-content_2');

    // モーダルウィンドウの終了
    modalWindowOff('modal-close', 'modal-content_1');
  </script>
</body>
</html>

