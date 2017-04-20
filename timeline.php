<?php
session_start();
require('dbconnect.php');

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
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

  <!-- 自動スクロール -->
  <link rel="stylesheet" href="assets/css/screen.css" type="text/css" media="screen">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
  <script src="assets/js/jquery.pageme.js" type="text/javascript"></script>
  <script type="text/javascript">
      $(document).ready(function() {
          $(".content").pageme();
      });
  </script>
</head>
<body>



  <!-- 繰り返し処理 -->
  <?php foreach ($posts as $post) { ?>

    <!-- パラメーター設定 -->
    <?php $haiku_id = $post['haiku_id'] ?>
    <?php $nick_name = $post['nick_name'] ?>
    <?php $user_picture_path = $post['user_picture_path'] ?>
    <?php $haiku_1 = $post['haiku_1'] ?>
    <?php $haiku_2 = $post['haiku_2'] ?>
    <?php $haiku_3 = $post['haiku_3'] ?>
    <?php $created = $post['created'] ?>
    <?php $num_like = "num_like_" . $haiku_id ?>
    <?php $comment_id = "com_id_" . $haiku_id ?>

    <!-- 句一覧の表示 -->
    <?php echo $nick_name ?><br>
    <img src="assets/images/<?php echo $user_picture_path ?>" width="48" height="48"><br>
    <?php echo $haiku_1 ?><br>
    <?php echo $haiku_2 ?><br>
    <?php echo $haiku_3 ?><br>
    <?php echo $created ?><br>

    <?php $v_haiku_1 = tateGaki($haiku_1); ?>
    <?php echo $v_haiku_1 ?><br>

    <?php if($_SESSION['login_member_id'] == $member_id): ?>
      <!-- 編集ボタン -->
      [<a href="edit.php?tweet_id=<?php echo $tweet_id ?>" style="color: #00994C;">編集</a>]
      <!-- 削除ボタン -->
      [<a href="delete.php?tweet_id=<?php echo $tweet_id ?>&page=<?php echo $page; ?>" style="color: #F33;">削除</a>]
    <?php endif; ?>

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

    <!-- コメント表示 -->
    <div class="preview">
      <!-- コメントボタン -->
      <button id="<?php echo $comment_id ?>" class="comment_button">コメント</button>

      <!-- コメント欄 -->
      <div id="<?php echo $comment_id . '_content' ?>" style="text-align: center; color: white; background-color: rgb(0, 153, 255); display: none;">

        <!-- ログインユーザーの写真 -->
        <img src="assets/images/<?php echo $user_picture_path ?>" width="48" height="48"><br>

        <!-- コメント入力フォーム -->
        <input type="text" class="comment_content" id="<?php echo $comment_id . '_input' ?>" name="hoge" class="form-control" placeholder="例： comment" style="color: black;">
        
        <!-- コメントの内容 -->
        <div id="<?php echo $haiku_id . '_cont' ?>">
          <?php if(!empty($comments)): ?>
            <?php foreach ($comments as $comment) { ?>
              <p><?php echo $comment['nick_name'] ?></p>
              <img src="assets/images/<?php echo $comment['user_picture_path'] ?>" width="48" height="48">
              <p><?php echo $comment['comment'] ?></p>
              <p><?php echo $comment['created'] ?></p>
            <?php } ?>
          <?php endif; ?>
        </div>

      </div>
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

    <!-- いいね数表示 -->
    <p id="<?php echo $num_like ?>">いいね！数： <?php echo $count['total']; ?></p>

    <?php if($is_like = $is_like_stmt->fetch(PDO::FETCH_ASSOC)): ?>
      <!-- いいね！データが存在する（削除ボタン表示） -->
      <input type="submit" value="いいね！取り消し" id="<?php echo $haiku_id; ?>" class="like btn btn-danger btn-xs">
    <?php else: ?>
      <!-- いいね！データが存在しない（いいねボタン表示） -->
      <input type="submit" value="いいね！" id="<?php echo $haiku_id; ?>" class="like btn btn-primary btn-xs">
    <?php endif; ?>

  <?php } ?>

  <?php // if($page > 1): ?>
    <!-- <li><a href="timeline.php?page=<?php echo $page - 1; ?>" class="btn btn-default">前</a></li> -->
  <?php // else: ?>
    <!-- <li>前</li> -->
  <?php //endif; ?>

  <!-- &nbsp;&nbsp;|&nbsp;&nbsp; -->
  <?php //if($page < $max_page): ?>
    <!-- <li><a href="timeline.php?page=<?php echo $page + 1; ?>" class="btn btn-default">次</a></li> -->
  <?php //else: ?>
    <!-- <li>次</li> -->
  <?php //endif; ?>

  <div class="navigate">
    <a class="next" href="timeline.php?page=2">Next</a>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>

  <script src="assets/js/likes.js"></script>
  <script src="assets/js/comment.js"></script>

</body>
</html>