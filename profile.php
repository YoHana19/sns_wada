<?php
session_start();
require('dbconnect.php');
require('function.php');

// 該当ユーザーの情報取得
$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_user = $stmt->fetch(PDO::FETCH_ASSOC);

// 自分の作った全句を時系列で表示

$sql = 'SELECT h.*, m.nick_name, m.user_picture_path FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE h.member_id=? ORDER BY created DESC';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// 空の配列を定義
$posts = array();

while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
  // whileの外に用意した配列に入れる
  $posts[] = $record;
  // 配列名の後に[]をつけると最後の段を指定する]
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
  <!-- for Bootstrap -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
  <!-- For Modal Window -->
  <link rel="stylesheet" type="text/css" href="assets/css/mw_haiku_input.css">
  <!-- 全ページ共通 -->
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- 各ページ -->
  <link rel="stylesheet" type="text/css" href="assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" href="assets/css/user.css">
</head>
<body>

  <!-- ヘッダー -->
  <?php require('header.php'); ?>

  <!--プロフィール写真/ 一言-->
  <div class="container whole-content">
    <div class="fb-profile">
      <div class="fb-image-lg" style="width: 100%; height: 400px; background-image: url(assets/images/<?php echo $login_user['back_picture_path']; ?>);">
        <span class="intro-text-3"><?php echo tateGaki($login_user['self_intro_3']); ?></span>
        <span class="intro-text-2"><?php echo tateGaki($login_user['self_intro_2']); ?></span>
        <span class="intro-text-1"><?php echo tateGaki($login_user['self_intro_1']); ?></span>
      </div>
      <img align="left" class="fb-image-profile thumbnail" src="assets/images/<?php echo $login_user['user_picture_path']; ?>" alt="Profile image example">
      <div class="fb-profile-text">
        <h1><?php echo $login_user['nick_name']; ?></h1>
        <div class="navbar-fixed">
          <input type="button" onclick="location.href='edit.php'" value="プロフィール編集">
        </div>
      </div>
    </div>
  </div>

  <div class="container">
      <div class="row">

        <div class="col-md-3 left-content">
          <?php require('left_sidebar.php'); ?>
        </div>
        
        <div class="col-md-8 right-content">

          <!-- 句一覧 -->
          <div id="posts">

            <!-- 繰り返し処理 -->
            <?php foreach ($posts as $post) { ?>

              <!-- パラメーター設定 -->
              <?php $member_id = $post['member_id'] ?>
              <?php $haiku_id = $post['haiku_id'] ?>
              <?php $nick_name = $post['nick_name'] ?>
              <?php $user_picture_path = $post['user_picture_path'] ?>
              <?php $haiku_1 = $post['haiku_1'] ?>
              <?php $haiku_2 = $post['haiku_2'] ?>
              <?php $haiku_3 = $post['haiku_3'] ?>
              <?php $created = $post['created'] ?>
              <?php $num_like = "num_like_" . $haiku_id ?>
              <?php $num_dislike = "num_dislike_" . $haiku_id ?>
              <?php $num_com_id = "num_comment_" . $haiku_id ?>
              <?php $comment_id = "com_id_" . $haiku_id ?>

              <?php
                // コメントの取得
                $sql = 'SELECT c.*, m.nick_name, m.user_picture_path FROM `comments` AS c LEFT JOIN `members` AS m ON c.member_id=m.member_id WHERE `haiku_id`=? ORDER BY c.created DESC';
                $data = array($haiku_id);
                $stmt = $dbh->prepare($sql);
                $stmt->execute($data);

                // 空の配列を定義
                $comments = array();

                while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  // whileの外に用意した配列に入れる
                  $comments[] = $record;
                  // 配列名の後に[]をつけると最後の段を指定する]
                }

                // コメント件数の取得
                $num_comment = count($comments);
              ?>

              <!-- 投稿 -->
              <div class="post-haiku">
                <div class="poster-info">
                  <img alt="" src="assets/images/<?php echo $user_picture_path ?>" class="pull-left">
                  <div class="pull-left">
                    <span class="post-haiku-name"><?php echo $nick_name ?></span>
                    <span calss="post-haiku-comment"><?php echo $post['short_comment'] ?></span>
                  </div>
                  <p><?php echo japaneseDate($created) ?>日 <?php echo japaneseClock($created) ?>の刻</p>
                </div>
                <div class="active item">
                  <blockquote style="background:#fff0f5">
                    <div class="post-haiku-text">
                      <h2 class="post-haiku-text-1"><?php echo tateGaki($haiku_3); ?></h2>
                      <h2 class="post-haiku-text-2"><?php echo tateGaki($haiku_2); ?></h2>
                      <h2 class="post-haiku-text-3"><?php echo tateGaki($haiku_1); ?></h2>
                    </div>
                  </blockquote>
                </div>

                <?php
                  // よし数カウント処理
                  $sql = 'SELECT count(*) AS total FROM `likes` WHERE `haiku_id`=?';
                  $data = array($haiku_id);
                  $count_stmt = $dbh->prepare($sql);
                  $count_stmt->execute($data);
                  $count_yoshi = $count_stmt->fetch(PDO::FETCH_ASSOC);
                ?>

                <?php
                  // あし数カウント処理
                  $sql = 'SELECT count(*) AS total FROM `dislikes` WHERE `haiku_id`=?';
                  $data = array($haiku_id);
                  $count_stmt = $dbh->prepare($sql);
                  $count_stmt->execute($data);
                  $count_ashi = $count_stmt->fetch(PDO::FETCH_ASSOC);
                ?>

                <div style="text-align: right;">
                  <div style="float: left">
                    <i id="<?php echo $num_like ?>" class="glyphicon glyphicon-thumbs-up icon-margin">&thinsp;<?php echo $count_yoshi['total']; ?>人</i>
                    <i id="<?php echo $num_dislike ?>" class="glyphicon glyphicon-thumbs-down icon-margin">&thinsp;<?php echo $count_ashi['total']; ?>人</i>
                    <i id="<?php echo $num_com_id ?>" class="fa fa-commenting-o icon-margin" aria-hidden="true">&thinsp;<?php echo $num_comment; ?>件</i>
                  </div>
                  <i class="fa fa-facebook-official fa-2x" aria-hidden="true" style="color: #3b5998"></i>
                  <i class="fa fa-twitter-square fa-2x" aria-hidden="true" style="color: #00a1e9"></i>
                </div>

                <div class="post-icons">
                  <!-- コメント -->
                    <!-- コメントボタン -->
                    <button id="<?php echo $comment_id ?>" class="btn icon-btn btn-color-comment comment_button" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</button>

                    <!-- コメント欄 -->
                    <div id="<?php echo $comment_id . '_content' ?>" class="post-comment" style="display: none; margin-top: 20px;">
                      <div class="comment-msg row">
                        <div class="form-group">
                          <!-- ログインユーザーの写真 -->
                          <div class="col-sm-1">
                            <?php
                              $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
                              $data = array($_SESSION['login_member_id']);
                              $stmt = $dbh->prepare($sql);
                              $stmt->execute($data);
                              $login_user_picture = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <img src="assets/images/<?php echo $login_user_picture['user_picture_path'] ?>" width="45" height="45">
                          </div>

                          <!-- コメント入力フォーム -->
                          <div class="col-sm-11">
                            <input type="text" class="comment_content form-control comment-input" id="<?php echo $comment_id . '_input' ?>" placeholder="例： コメント">
                          </div>
                        </div>  
                      </div>

                      <!-- コメントの内容 -->
                      <div id="<?php echo $haiku_id . '_cont' ?>" class="comment-msg">
                        <?php if(!empty($comments)): ?>
                      
                          <?php foreach ($comments as $comment) { ?>
                            <div class="row">
                              <div class="col-sm-1">
                                <img src="assets/images/<?php echo $comment['user_picture_path'] ?>" width="45" height="45">
                              </div>
                              <div class="col-sm-11">
                                <p><span class="name"><a href="user.php?user_id=<?php echo $comment['member_id'] ?>"><?php echo $comment['nick_name'] ?></a></span><?php echo $comment['comment'] ?></p>
                                <!-- <p><?php // echo $comment['created'] ?></p> -->
                              </div>
                            </div>
                          <?php } ?>
                            
                        <?php endif; ?>
                      </div>

                     <!-- コメント終了 -->
                  </div>
                </div>
              </div>
            <?php } ?> <!-- 繰り返し終了 -->
          </div> <!-- posts終了タグ -->

        </div>
      </div>
  </div>

  <!-- フッター -->
  <?php require('footer.php') ?>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/likes.js"></script>
  <script src="assets/js/dislikes.js"></script>
  <script src="assets/js/comment.js"></script>
  <!-- スクロール固定 -->
  <script src="assets/js/scroll_fix.js"></script>

</body>
</html>
