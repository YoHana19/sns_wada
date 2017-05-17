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

// ランキングよし・あし、俳人・句それぞれのランキング上位3件を取ってくる

// よしランキング句用sql文
$sql = 'SELECT * FROM `likes`';
$stmt = $dbh->prepare($sql);
$stmt->execute();
// $data : sql文の中で「?」を使いたい時必要

// ↓sql文で取得したデータを配列化
$haiku_ids = array();
while($like_haiku = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $haiku_ids[] = $like_haiku['haiku_id'];
}       // ↑ここで配列化 []を使うと、[1]-> [1,2]-> [1,2,3]...のように新しい数を配列の最後尾にいれる

$haiku_rank = rankGet($haiku_ids);

// 句、プロフ画像、名前取得
$haikus_info = array();
foreach ($haiku_rank as $haiku) {
  $sql = 'SELECT * FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE `haiku_id`=?';
  $data = array($haiku[0]);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  $haikus_info[] = $record;
}

// よしランキング歌人用sql文
$sql = 'SELECT * FROM `likes`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$member_ids = array();
while($like_member = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $member_ids[] = $like_member['haiku_member_id'];
}

$member_rank = rankGet($member_ids);

// プロフ画像、名前取得
$members_info = array();
foreach ($member_rank as $member) {
  $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $data = array($member[0]);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $member_record = $stmt->fetch(PDO::FETCH_ASSOC);
  $members_info[] = $member_record;
}


// あしランキング句用sql文
$sql = 'SELECT * FROM `dislikes`';
$stmt = $dbh->prepare($sql);
$stmt->execute();
// $data : sql文の中で「?」を使いたい時必要

// ↓sql文で取得したデータを配列化
$bad_haiku_ids = array();
while($dislike_haiku = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $bad_haiku_ids[] = $dislike_haiku['haiku_id'];
}       // ↑ここで配列化 []を使うと、[1]-> [1,2]-> [1,2,3]...のように新しい数を配列の最後尾にいれる

$bad_haiku_rank = rankGet($bad_haiku_ids);

// 句、プロフ画像、名前取得
$bad_haikus_info = array();
foreach ($bad_haiku_rank as $bad_haiku) {
  $sql = 'SELECT * FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE `haiku_id`=?';
  $data = array($bad_haiku[0]);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $bad_record = $stmt->fetch(PDO::FETCH_ASSOC);
  $bad_haikus_info[] = $bad_record;
}


// あしランキング歌人用sql文

$sql = 'SELECT * FROM `dislikes`';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$bad_member_ids = array();
while($dislike_member = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $bad_member_ids[] = $dislike_member['haiku_member_id'];
}

$bad_member_rank = rankGet($bad_member_ids);

// プロフ画像、名前取得
$bad_members_info = array();
foreach ($bad_member_rank as $bad_member) {
  $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $data = array($bad_member[0]);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $bad_member_record = $stmt->fetch(PDO::FETCH_ASSOC);
  $bad_members_info[] = $bad_member_record;
}


// 関数を使った処理
function rankGet($array_ids) {                  // $array_idsは配列
  $pure_ids = array_count_values($array_ids);   // 重複する値の数を数得て、その値とその数をペアにした連想配列を作る
  arsort($pure_ids);                            // 連想配列の値をもとに大きい順に並び変える
  $array_ranks = array();                       // ランキング上位3つのidを入れるからの配列を作る
  for ($i=0; $i < 3; $i++) {                    // 3位とってくるので3回繰り返す
    $rank_id = key($pure_ids);                  // 連想配列のポインタのあるキーを取ってくる（○位を取ってくる）
    $value_num = $pure_ids["$rank_id"];         // よし・あし数取得
    $array_rank = array($rank_id, $value_num);  // 配列にいれる
    $array_ranks[] = $array_rank;               // 取得したidを配列に入れる
    next($pure_ids);                            // 隣のポインタに移す
  }
  return $array_ranks;
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
  <!-- For Modal Window -->
  <link rel="stylesheet" type="text/css" href="assets/css/mw_haiku_input.css">
  <!-- 全ページ共通 -->
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- 各ページ -->
  <link rel="stylesheet" type="text/css" href="assets/css/ranking.css">
</head>
<body>

  <!-- ヘッダー -->
  <?php require('header.php'); ?>

  <!-- 自分情報(左上のやつ) -->
  <div class="container">
    <div class="row whole-content">

      <!-- 左サイドバー -->
      <div class="col-md-3 left-content">
        <?php require('left_sidebar.php'); ?>
      </div>

      <!-- 本コンテンツ -->
      <div class="col-md-8 right-content">

        <!-- コラム/ランキング -->
        <div class="ranking-column">
          <h4><img src="assets/images/source/column.png" width="200" height="60"></h4>
        </div>

        <!-- コラムコンテンツ1 -->
        <div class="col-md-4 col-md-push-4">
          <img class="img-responsive img-circle" src="assets/images/source/japanese-umbrellas.jpg" alt="Greece-1173 - Temple of Athena by Dennis Jarvis, on Flickr">
        </div>

        <!-- コラムコンテンツ2 -->
        <div class="col-md-4 col-md-pull-4 ">
          <img class="img-responsive img-circle" src="assets/images/source/japanese-umbrellas.jpg" alt="Greece-1173 - Temple of Athena by Dennis Jarvis, on Flickr">
        </div>

        <!-- コラムコンテンツ3 -->
        <div class="col-md-4">
          <img class="img-responsive img-circle" src="assets/images/source/japanese-umbrellas.jpg" alt="Greece-1173 - Temple of Athena by Dennis Jarvis, on Flickr">
        </div>

        <!-- ランキング -->
        <!-- タイトル -->
        <img class="rank-title" src="assets/images/source/rank_title_2.png">

        <!-- 歌人 -->
        <div class="row">
          <div> 
            <!-- 歌人タイトル -->
            <img class="genre-title" src="assets/images/source/kajin.png">
          </div>

          <!-- よしランキング -->
          <div class="col-md-6">

            <!-- よしタイトル -->
            <div class="title-ranking">
              <img src="assets/images/source/yoshi.png">
            </div>

            <!-- 歌人よし1位 -->
            <div class="ranking ranking-1">
              <img class="media-object" src="assets/images/users/<?php echo $members_info[0]['user_picture_path']; ?>">
              <a href="user.php?user_id=<?php echo $members_info[0]['member_id'] ?>" style="color: black;"><h1><?php echo $members_info[0]['nick_name']; ?></h1></a>
              <p><?php echo $member_rank[0][1] ?> よし</p>
            </div>
              
            <!-- 歌人よし2位 -->
            <div class="ranking ranking-2">
              <img class="media-object" src="assets/images/users/<?php echo $members_info[1]['user_picture_path']; ?>">
              <a href="user.php?user_id=<?php echo $members_info[1]['member_id'] ?>" style="color: black;"><h4><?php echo $members_info[1]['nick_name']; ?></h4></a>
              <p><?php echo $member_rank[1][1] ?> よし</p>
            </div>

            <!-- 歌人よし3位 -->
            <div class="ranking ranking-3">
              <img class="media-object" src="assets/images/users/<?php echo $members_info[2]['user_picture_path']; ?>">
              <a href="user.php?user_id=<?php echo $members_info[2]['member_id'] ?>" style="color: black;"><h4><?php echo $members_info[2]['nick_name']; ?></h4></a>
              <p><?php echo $member_rank[2][1] ?> よし</p>
            </div>

          </div> <!-- よしランキング終了 -->

          <!-- あしランキング -->
          <div class="col-md-6">
              
            <!-- あしタイトル -->
            <div class="title-ranking">
              <img src="assets/images/source/ashi.png">
            </div>

            <!-- あし歌人1位 -->
            <div class="ranking ranking-1">
              <img class="media-object" src="assets/images/users/<?php echo $bad_members_info[0]['user_picture_path']; ?>">
              <a href="user.php?user_id=<?php echo $bad_members_info[0]['member_id'] ?>" style="color: black;"><h1><?php echo $bad_members_info[0]['nick_name']; ?></h1></a>
              <p><?php echo $bad_member_rank[0][1]; ?> あし</p>
            </div>

            <!-- あし歌人2位 -->
            <div class="ranking ranking-2">
              <img src="assets/images/users/<?php echo $bad_members_info[1]['user_picture_path']; ?>">
              <a href="user.php?user_id=<?php echo $bad_members_info[1]['member_id'] ?>" style="color: black;"><h4><?php echo $bad_members_info[1]['nick_name']; ?></h4></a>
              <p><?php echo $bad_member_rank[1][1]; ?> あし</p>
            </div>

            <!-- あし歌人3位 -->
            <div class="ranking ranking-3">
              <img src="assets/images/users/<?php echo $bad_members_info[2]['user_picture_path']; ?>">
              <a href="user.php?user_id=<?php echo $bad_members_info[2]['member_id'] ?>" style="color: black;"><h4><?php echo $bad_members_info[2]['nick_name']; ?></h4></a>
              <p><?php echo $bad_member_rank[2][1] ?> あし</p>
            </div>

          </div> <!-- あしランキング終了 -->

        </div> <!-- 歌人終了 -->


        <!-- 句 -->
        <div class="row">
          <div>
            <!-- 句タイトル -->
            <img class="genre-title" src="assets/images/source/ku.png">
          </div>

          <!-- よしランキング -->
          <div class="col-md-6">

            <!-- よしタイトル -->
            <div class="title-ranking">
              <img src="assets/images/source/yoshi.png">
            </div>

            <!-- 句よし1位 -->
            <div class="ranking">
              <div class="ku-rank-wrap-1">
                <!-- 句の内容 -->
                <div class="ku-ranking ku-ranking-1">
                  <p class="haiku-text-1"><?php echo tateGaki($haikus_info[0]['haiku_3']); ?></p>
                  <p class="haiku-text-2"><?php echo tateGaki($haikus_info[0]['haiku_2']); ?></p>
                  <p class="haiku-text-3"><?php echo tateGaki($haikus_info[0]['haiku_1']); ?></p>
                </div> <!-- 句の内容終了 -->

                <!-- 作者情報 -->
                <div class="auth-ranking auth-ranking-1">
                  <a href="user.php?user_id=<?php echo $haikus_info[0]['member_id'] ?>">
                    <img src="assets/images/users/<?php echo $haikus_info[0]['user_picture_path']; ?>">
                  </a>
                  <span class="media-heading"><?php echo $haikus_info[0]['nick_name']; ?></span>
                  <span style="font-size: 14px;"><?php echo $haiku_rank[0][1] ?> よし</span>
                </div>
              </div>
            </div>

            <!-- 句よし2位 -->
            <div class="ranking">
              <div class="ku-rank-wrap-2">
              <!-- 句の内容 -->
                <div class="ku-ranking ku-ranking-2">
                  <p class="haiku-text-1"><?php echo tateGaki($haikus_info[1]['haiku_3']); ?></p>
                  <p class="haiku-text-2"><?php echo tateGaki($haikus_info[1]['haiku_2']); ?></p>
                  <p class="haiku-text-3"><?php echo tateGaki($haikus_info[1]['haiku_1']); ?></p>
                </div> <!-- 句の内容終了 -->

                <!-- 作者情報 -->
                <div class="auth-ranking auth-ranking-2">
                  <a href="user.php?user_id=<?php echo $haikus_info[1]['member_id'] ?>">
                    <img src="assets/images/users/<?php echo $haikus_info[1]['user_picture_path']; ?>">
                  </a>
                  <span class="media-heading"><?php echo $haikus_info[1]['nick_name']; ?></span>
                  <span style="font-size: 12px;"><?php echo $haiku_rank[1][1] ?> よし</span>
                </div>
              </div>
            </div>

            <!-- 句よし3位 -->
            <div class="ranking">
              <div class="ku-rank-wrap-3">
                <!-- 句の内容 -->
                <div class="ku-ranking ku-ranking-3">
                  <p class="haiku-text-1"><?php echo tateGaki($haikus_info[2]['haiku_3']); ?></p>
                  <p class="haiku-text-2"><?php echo tateGaki($haikus_info[2]['haiku_2']); ?></p>
                  <p class="haiku-text-3"><?php echo tateGaki($haikus_info[2]['haiku_1']); ?></p>
                </div> <!-- 句の内容終了 -->

                <!-- 作者情報 -->
                <div class="auth-ranking auth-ranking-3">
                  <a href="user.php?user_id=<?php echo $haikus_info[2]['member_id'] ?>">
                    <img src="assets/images/users/<?php echo $haikus_info[2]['user_picture_path']; ?>">
                  </a>
                  <span class="media-heading"><?php echo $haikus_info[2]['nick_name']; ?></span>
                  <span style="font-size: 11px;"><?php echo $haiku_rank[2][1] ?> よし</span>
                </div>
              </div>
            </div>

          </div> <!-- よしランキング終了 -->
            
          <!-- あしランキング -->
          <div class="col-md-6">

            <!-- あしタイトル -->
            <div class="title-ranking">
              <img src="assets/images/source/ashi.png">
            </div>

            <!-- 句あし1位 -->
            <div class="ranking">
              <div class="ku-rank-wrap-1">
                <!-- 句の内容 -->
                <div class="ku-ranking ku-ranking-1">
                  <p class="haiku-text-1"><?php echo tateGaki($bad_haikus_info[0]['haiku_3']); ?></p>
                  <p class="haiku-text-2"><?php echo tateGaki($bad_haikus_info[0]['haiku_2']); ?></p>
                  <p class="haiku-text-3"><?php echo tateGaki($bad_haikus_info[0]['haiku_1']); ?></p>
                </div> <!-- 句の内容終了 -->

                <!-- 作者情報 -->
                <div class="auth-ranking auth-ranking-1">
                  <a href="user.php?user_id=<?php echo $bad_haikus_info[0]['member_id'] ?>">
                    <img src="assets/images/users/<?php echo $bad_haikus_info[0]['user_picture_path']; ?>">
                  </a>
                  <span class="media-heading"><?php echo $bad_haikus_info[0]['nick_name']; ?></span>
                  <span style="font-size: 14px;"><?php echo $bad_haiku_rank[0][1] ?> あし</span>
                </div>
              </div>
            </div>

            <!-- 句あし2位 -->
            <div class="ranking">
              <div class="ku-rank-wrap-2">
                <!-- 句の内容 -->
                <div class="ku-ranking ku-ranking-2">
                  <p class="haiku-text-1"><?php echo tateGaki($bad_haikus_info[1]['haiku_3']); ?></p>
                  <p class="haiku-text-2"><?php echo tateGaki($bad_haikus_info[1]['haiku_2']); ?></p>
                  <p class="haiku-text-3"><?php echo tateGaki($bad_haikus_info[1]['haiku_1']); ?></p>
                </div> <!-- 句の内容終了 -->

                <!-- 作者情報 -->
                <div class="auth-ranking auth-ranking-2">
                  <a href="user.php?user_id=<?php echo $bad_haikus_info[1]['member_id'] ?>">
                    <img src="assets/images/users/<?php echo $bad_haikus_info[1]['user_picture_path']; ?>">
                  </a>
                  <span class="media-heading"><?php echo $bad_haikus_info[1]['nick_name']; ?></span>
                  <span style="font-size: 12px;"><?php echo $bad_haiku_rank[1][1] ?> あし</span>
                </div>
              </div>
            </div>

            <!-- 句あし3位 -->
            <div class="ranking">
              <div class="ku-rank-wrap-3">
                <!-- 句の内容 -->
                <div class="ku-ranking ku-ranking-3">
                  <p class="haiku-text-1"><?php echo tateGaki($bad_haikus_info[2]['haiku_3']); ?></p>
                  <p class="haiku-text-2"><?php echo tateGaki($bad_haikus_info[2]['haiku_2']); ?></p>
                  <p class="haiku-text-3"><?php echo tateGaki($bad_haikus_info[2]['haiku_1']); ?></p>
                </div> <!-- 句の内容終了 -->

                <!-- 作者情報 -->
                <div class="auth-ranking auth-ranking-3">
                  <a href="user.php?user_id=<?php echo $bad_haikus_info[2]['member_id'] ?>">
                    <img src="assets/images/users/<?php echo $bad_haikus_info[2]['user_picture_path']; ?>">
                  </a>
                  <span class="media-heading"><?php echo $bad_haikus_info[2]['nick_name']; ?></span>
                  <span style="font-size: 11px;"><?php echo $bad_haiku_rank[2][1] ?> あし</span>
                </div>
              </div>
            </div>

          </div> <!-- あしランキング終了 -->

        </div> <!-- 句終了 -->
      </div><!-- 本コンテンツ終了 -->
    </div>
  </div>

  <!-- フッター -->
  <?php require('footer.php') ?>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/friend.js"></script>
  <script src="assets/js/likes.js"></script>
  <script src="assets/js/dislikes.js"></script>
  <script src="assets/js/comment.js"></script>
  <script src="assets/js/scroll_fix.js"></script>

</body>
</html>

<!-- 順位のバックグラウンドをプロフィール画像に(順位を画像内に表示) -->
<!-- 各ランキングの画像のサイズ調節 -->
<!-- bootstrapで左右スクロール出来る物を探す(コラム/ニュース) -->
