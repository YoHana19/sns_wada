<?php
session_start();
require('dbconnect.php');

$_SESSION['login_member_id'] = 2;
$_SESSION['page'] = 1;

// ページング機能
$page = '';
// パラメータのページ番号を取得
if (isset($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
}

// パラメーターが存在しない場合はページ番号を1とする
if ($page == '') {
  $page = 1;
}
// 1以下のイレギュラーな数値が入ってきた場合はページ番号を1とする
$page = max($page, 1);

// データの件数から最大ページ数を計算する
$sql = 'SELECT count(*) AS `cnt` FROM `haikus`';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$record = $stmt->fetch(PDO::FETCH_ASSOC);
$max_page = ceil($record['cnt'] / 5); // 小数点以下切り上げ

// 取得データ件数が0だったら、ページ数を1にする（検索対応）
if ($max_page == 0) {
  $max_page = 1;
}

// パラメータのベージ番号が最大ページ数を超えていれば、最後のページ数とする
$page = min($page, $max_page);

// 1ページに表示する件数分だけデータを取得する
$page = ceil($page);
$start = ($page-1) * 5;

$sql = sprintf('SELECT h.*, m.nick_name, m.user_picture_path FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id ORDER BY h.created DESC LIMIT %d, 5', $start);
// $sql = 'SELECT t.*, m.nick_name, m.picture_path FROM `tweets` t, `members` m WHERE t.member_id=m.member_id ORDER BY `created` DESC';

$stmt = $dbh->prepare($sql);
$stmt->execute();

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

  <link rel="stylesheet" type="text/css" href="assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" href="assets/css/header.css">
  <link rel="stylesheet" type="text/css" href="..assets/css/footer.css">
  <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
  <link rel="stylesheet" type="text/css" href="assets/css/left_sideber.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>
  <div class="container">
    <div class="row content">

      <!-- 左サイドバー -->
      <div class="col-md-3 left-content">
        <?php require('design/left_sidebar.php'); ?>
      </div>

      <!-- 本コンテンツ -->
      <div class="col-md-8 right-content">
      
        <!-- 今日の季語 -->
        <div class="season_title">
          <h4>今日の季語</h4>
        </div>
        <div class="outer">
          <div class="season_word">さくら</div>
        </div>

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
            ?>

            <!-- １つ目 -->
            <div class="haiku">
              <div class="carousel-info">
                <img alt="" src="assets/images/<?php echo $user_picture_path ?>" class="pull-left">
                <div class="pull-left">
                  <span class="haiku-name"><?php echo $nick_name ?></span>
                  <span calss="haiku-comment"><?php echo $post['short_comment'] ?></span>
                </div>
                <p><?php echo $created ?></p>
              </div>
              <div class="active item">
                <blockquote style="background:#fff0f5">
                  <div class="haiku-text">
                    <h2 class="haiku-text-1"><?php echo tateGaki($haiku_3); ?></h2>
                    <h2 class="haiku-text-2"><?php echo tateGaki($haiku_2); ?></h2>
                    <h2 class="haiku-text-3"><?php echo tateGaki($haiku_1); ?></h2>
                  </div>
                </blockquote>
              </div>

              <?php
                // いいね！済みかどうかの判定処理
                $sql = 'SELECT * FROM `likes` WHERE `member_id`=? AND `haiku_id`=?';
                $data = array($_SESSION['login_member_id'],$haiku_id);
                $is_like_stmt = $dbh->prepare($sql);
                $is_like_stmt->execute($data);

                // いいね！数カウント処理
                $sql = 'SELECT count(*) AS total FROM `likes` WHERE `haiku_id`=?';
                $data = array($haiku_id);
                $count_stmt = $dbh->prepare($sql);
                $count_stmt->execute($data);
                $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
              ?>

              <div style="text-align: right;">
                <div style="float: left">
                  <i id="<?php echo $num_like ?>" class="glyphicon glyphicon-thumbs-up icon-margin">&thinsp;<?php echo $count['total']; ?>人</i>
                  <i class="glyphicon glyphicon-thumbs-down icon-margin">&thinsp;5人</i>
                  <i class="fa fa-commenting-o icon-margin" aria-hidden="true">&thinsp;3件</i>
                </div>
                <i class="fa fa-facebook-official fa-2x" aria-hidden="true" style="color: #3b5998"></i>
                <i class="fa fa-twitter-square fa-2x" aria-hidden="true" style="color: #00a1e9"></i>
              </div>

              <div class="icons">
                <!-- よし -->
                <?php if($is_like = $is_like_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                  <!-- よしデータが存在する（削除ボタン表示） -->
                  <button type="button" id="<?php echo $haiku_id; ?>" class="like btn icon-btn btn-primary btn-color-like"><span id="<?php echo $haiku_id . '_icon'; ?>" class="glyphicon btn-glyphicon glyphicon-thumbs-up img-circle text-color-like"></span>よし</button>
                <?php else: ?>
                  <!-- いいね！データが存在しない（いいねボタン表示） -->
                  <button type="button" id="<?php echo $haiku_id; ?>" class="like btn icon-btn btn-primary btn-color-un"><span id="<?php echo $haiku_id . '_icon'; ?>"class="glyphicon btn-glyphicon glyphicon-thumbs-up img-circle text-color-un"></span>よし</button>
                <?php endif; ?>

                <!-- あし -->
                <a class="btn icon-btn btn-color-dislike" href="#"><span class="glyphicon btn-glyphicon glyphicon-thumbs-down img-circle text-color-dislike"></span>あし</a>

                <!-- コメント -->
                  <!-- コメントボタン -->
                  <button id="<?php echo $comment_id ?>" class="btn icon-btn btn-color-comment comment_button" href="#"><span class="fa btn-glyphicon fa-commenting-o img-circle text-color-comment"></span>コメントする</button>

                  <!-- コメント欄 -->
                  <div id="<?php echo $comment_id . '_content' ?>" class="comment" style="display: none; margin-top: 20px;">
                    <div class="msg row">
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
                            <input type="text" class="comment_content" id="<?php echo $comment_id . '_input' ?>" name="hoge" class="form-control" placeholder="例： comment" style="color: black;">
                          </div>
                        </div>
                      
                    </div>

                    <!-- コメントの内容 -->
                    <div id="<?php echo $haiku_id . '_cont' ?>" class="msg">
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
      </div> <!-- col-md-8(右コンテンツ)終了タグ -->
    </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>

  <script src="assets/js/likes.js"></script>
  <script src="assets/js/comment.js"></script>
  
  <!-- jQuery (necessary for Modal Window) -->
  <script src="assets/js/modal_window.js"></script>
  <script src="assets/js/haiku_input.js"></script>

</body>
</html>