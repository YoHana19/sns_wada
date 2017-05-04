<?php
session_start();
require('dbconnect.php');
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

// $haiku_rank[0][0]

// $haiku_rank[0][1] 
// $haiku_rank[1][1]

// echo '<pre>';
// var_dump($haikus_info);
// echo '</pre>';

// foreach ($haikus_info as $haiku_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  // echo tateGaki($haiku_info['nick_name']);
  // echo '<br>';
  // echo $haiku_info['haiku_1'];
  // echo '<br>';
  // echo $haiku_info['haiku_2'];
  // echo '<br>';
  // echo $haiku_info['haiku_3'];
  // echo "<br>" . "<br>";
// }

// echo '<pre>';
// var_dump($haiku_info);
// echo '</pre>';

foreach ($haiku_rank as $haiku) { //(良し数)
  // echo $haiku[1] . '<br>';
}

// var_dump($haiku_rank);


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

// echo "<pre>";
// var_dump($members_info);
// echo "</pre>";

// foreach ($members_info as $member_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  // var_dump($member_info['nick_name']) ;
  // echo '<br>' . '<br>';
// }

// foreach ($member_rank as $member) { //(良し数)
  // echo $member[1];
  // echo '<br>';
// }

// var_dump($member);



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

// echo '<pre>';
// var_dump($bad_haikus_info);
// echo '</pre>';

// foreach ($bad_haikus_info as $bad_haiku_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  // echo $bad_haiku_info['nick_name'];
  // echo '<br>';
  // echo $bad_haiku_info['haiku_1'];
  // echo '<br>';
  // echo $bad_haiku_info['haiku_2'];
  // echo '<br>';
  // echo $bad_haiku_info['haiku_3'];
  // echo "<br>" . "<br>";
// }

foreach ($bad_haiku_rank as $bad_haiku) { //(悪し数)
  // echo $bad_haiku[1] . '<br>';
}

// var_dump($bad_haiku[1]);

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

foreach ($bad_members_info as $bad_member_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)

  // echo $bad_member_info['nick_name'];
  // echo '<br>' . '<br>';
}

foreach ($bad_member_rank as $bad_member) { //(悪し数)
  // echo $bad_member[1];
  // echo '<br>';

  // var_dump($bad_member[1]);
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

  <link rel="stylesheet" type="text/css" href="assets/css/ranking.css">
  <link rel="stylesheet" type="text/css" href="assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
  <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
  <link rel="stylesheet" type="text/css" href="assets/css/left_sideber.css">
  <link rel="stylesheet" type="text/css" href="assets/css/mw_haiku_input.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- For Modal Window -->
  <link rel="stylesheet" type="text/css" href="assets/css/modal_window.css">
  <link rel="stylesheet" type="text/css" href="assets/css/header.css">
</head>
<body>

  <!-- ヘッダー -->
  <?php require('header.php'); ?>




<!-- 自分情報(左上のやつ) -->
  <div class="container">
    <div class="row whole_content">

      <!-- 左サイドバー -->
      <div class="col-md-3 left-content">
        <?php require('left_sidebar.php'); ?>
      </div>

      <!-- 本コンテンツ -->
      <div class="col-md-8 right-content">

        <!-- コラム/ランキング -->
        <div class="ranking-column">
          <h4><img src="assets/images/column.png" width="200" height="60"></h4>
        </div>

        <!-- コラムコンテンツ1 -->
        <div class="col-md-4 col-md-push-4">
          <img class="img-responsive img-circle" src="assets/images/japanese-umbrellas.jpg" alt="Greece-1173 - Temple of Athena by Dennis Jarvis, on Flickr">
        </div>

        <!-- コラムコンテンツ2 -->
        <div class="col-md-4 col-md-pull-4 ">
          <img class="img-responsive img-circle" src="assets/images/japanese-umbrellas.jpg" alt="Greece-1173 - Temple of Athena by Dennis Jarvis, on Flickr">
        </div>

        <!-- コラムコンテンツ3 -->
        <div class="col-md-4">
          <img class="img-responsive img-circle" src="assets/images/japanese-umbrellas.jpg" alt="Greece-1173 - Temple of Athena by Dennis Jarvis, on Flickr">
        </div>

        <!-- ランキング -->
        <!-- タイトル -->
        <img src="assets/images/rank-title.png" style="width: 500px; height:80px; margin-top: 50px; margin-left: 290px;">
   

        <!-- ランキングコンテンツスタート -->
        <div class="yosi-ranking"> 
          <!-- 歌人タイトル -->
          <h5><img src="assets/images/kajin.png" width="120" height="70"></h5>
          <!-- よし ランキング -->
          <div class="col-md-6">

            <!-- 歌人 -->

            <!-- 歌人よし1位 -->
            <div class="title-ranking">
              <img src="assets/images/yoshi_rank.png" width="80" height="45">
            </div>
            <div class="ranking-1">
              <div class="photo">
                <img class="media-object picuture-position" src="assets/images/<?php echo $members_info[0]['user_picture_path']; ?>">
              </div>
              <h1><?php echo $members_info[0]['nick_name']; ?></h1>
              <h3><?php echo $member_rank[0][1] ?> よし</h3>
            </div>
              
            <!-- 歌人よし2位以下 -->
            <div class="ranking-less2">
              <!-- 歌人よし2位 -->
              <div class="ranking-2">
                <div class="media">
                  <img class="media-object" src="assets/images/<?php echo $members_info[1]['user_picture_path']; ?>">
                  <div class="media-body">
                    <h4 class="media-heading"><?php echo $members_info[1]['nick_name']; ?></h4>
                    <h4><?php echo $member_rank[1][1] ?> よし</h4>
                  </div>
                </div>
              </div>

              <!-- 歌人よし3位 -->
              <div class="ranking-3">
                <div class="media">
                  <img class="media-object" src="assets/images/<?php echo $members_info[2]['user_picture_path']; ?>">
                  <div class="media-body">
                    <h4 class="media-heading"><?php echo $members_info[2]['nick_name']; ?></h4>
                    <h5><?php echo $member_rank[2][1] ?> よし</h5>
                  </div>
                </div>
              </div>
            </div><!-- 歌人よし2位以下終了 -->

            <!-- 句 -->

            <!-- 句タイトル -->
            <div class="ku-name"><h5><img src="assets/images/ku.png" width="80" height="60"></h5></div>

            <!-- 句よしタイトル -->
            <div class="title-ranking">
              <img src="assets/images/yoshi_rank.png" width="80" height="45" >
            </div>
            <!-- 句よし1位 -->
            <div class="kuranking-1">
              <!-- 句の内容 -->
              <div class="haiku">
                <div class="carousel-info">
                  <div class="pull-left">
                    <div class="active item">
                      <blockquote style="background: #d69090">
                        <div class="haiku-text">
                          <h2 class="haiku-text-1"><?php echo tateGaki($haikus_info[0]['haiku_1']); ?></h2>
                          <h2 class="haiku-text-2"><?php echo tateGaki($haikus_info[0]['haiku_2']); ?></h2>
                          <h2 class="haiku-text-3"><?php echo tateGaki($haikus_info[0]['haiku_3']); ?></h2>
                        </div>
                      </blockquote>
                    </div>
                  </div>
                </div>
              </div><!-- 句の内容終了 -->

              <a class="pull-left" href="#">
                <div class="photo"><img class="media-object picuture-position" src="assets/images/<?php echo $haikus_info[0]['user_picture_path']; ?>" style="border-radius: 50px;"></div>
              </a>
              <div class="name"><h1><?php echo $haikus_info[0]['nick_name']; ?></h1></div>
              <h3><?php echo $haiku_rank[0][1] ?> よし</h3>
            </div><!-- 句よし1位終了 -->
          
            <!-- 句よしランキング2位以下 -->
            <div class="ranking-less2">

              <!-- 句よし2位 -->
              <div class="kuranking-2">
              
                <!-- 句の詳細 -->
                <div class="haiku">
                  <div class="carousel-info">
                    <div class="pull-left">
                      <div class="active item">
                        <blockquote style="background: #d69090">
                          <div class="haiku-text">
                            <h2 class="haiku-text-1"><?php echo tateGaki($haikus_info[1]['haiku_1']); ?></h2>
                            <h2 class="haiku-text-2"><?php echo tateGaki($haikus_info[1]['haiku_2']); ?></h2>
                            <h2 class="haiku-text-3"><?php echo tateGaki($haikus_info[1]['haiku_3']); ?></h2>
                          </div>
                        </blockquote>
                      </div>
                    </div>
                  </div>
                </div><!-- 句の詳細ここまで -->
                
                <div class="media2">
                  <a class="pull-left" href="#">
                    <img class="media-object" src="assets/images/<?php echo $haikus_info[1]['user_picture_path']; ?>" style="border-radius: 50px;">
                  </a>
                  <div class="media-body2">
                    <h4 class="media-heading"><?php echo $haikus_info[1]['nick_name']; ?></h4>
                    <h4><?php echo $haiku_rank[1][1] ?> よし</h4>
                  </div>
                </div>
              </div><!-- 句よし2位終了 -->

              <!-- 句よし3位 -->
              <div class="kuranking-3">
                
                <!-- 句の詳細 -->
                <div class="haiku">
                  <div class="carousel-info">
                    <div class="pull-left">
                      <div class="active item">
                        <blockquote style="background: #d69090">
                          <div class="haiku-text">
                           <h2 class="haiku-text-1"><?php echo tateGaki($haikus_info[2]['haiku_1']); ?></h2>
                           <h2 class="haiku-text-2"><?php echo tateGaki($haikus_info[2]['haiku_2']); ?></h2>
                           <h2 class="haiku-text-3"><?php echo tateGaki($haikus_info[2]['haiku_3']); ?></h2>
                          </div>
                        </blockquote>
                      </div>
                    </div>
                  </div>
                </div><!-- 句の詳細ここまで -->

                <div class="media2">
                  <a class="pull-left" href="#">
                    <img class="media-object" src="assets/images/<?php echo $haikus_info[2]['user_picture_path']; ?>" style="border-radius: 50px;">
                  </a>
                  <div class="media-body2">
                    <h4 class="media-heading"><?php echo $haikus_info[2]['nick_name']; ?></h4>
                    <h5><?php echo $haiku_rank[2][1] ?> よし</h5>
                  </div>
                </div>
              </div><!-- 句よし3位終了 -->
              
            </div><!-- 句よしランキング2位以下 -->
          </div><!-- よし ランキング終了 -->

          <!--あし ランキング -->
          <div class="col-md-6">

            <!-- あし歌人1位 -->
            <div class="title-ranking">
              <img src="assets/images/ashi_rank.png" width="100" height="45">
            </div>
            <div class="ranking-1">
              <img class="media-object picuture-position" src="assets/images/<?php echo $bad_members_info[0]['user_picture_path']; ?>">
              <h1><?php echo $bad_members_info[0]['nick_name']; ?></h1>
              <h3><?php echo $bad_member_rank[0][1]; ?> あし</h3>
            </div>
          
            <!-- あし歌人2位以下 -->
            <div class="ranking-less2">

              <!-- あし歌人2位 -->
              <div class="ranking-2">
                <div class="media">
                  <img class="media-object" src="assets/images/<?php echo $bad_members_info[1]['user_picture_path']; ?>">
                  <div class="media-body">
                    <h4><?php echo $bad_members_info[1]['nick_name']; ?></h4>
                    <h4><?php echo $bad_member_rank[1][1]; ?> あし</h4>
                  </div>
                </div>
              </div>

              <!-- あし歌人3位 -->
              <div class="ranking-3">
                <div class="media">
                  <img class="media-object" src="assets/images/<?php echo $bad_members_info[2]['user_picture_path']; ?>">
                  <div class="media-body">
                    <h4><?php echo $bad_members_info[2]['nick_name']; ?></h4>
                    <h5><?php echo $bad_member_rank[2][1] ?> あし</h5>
                  </div>
                </div>
              </div>

            </div><!-- あし歌人2位以下終了 -->

            <!-- 句あしタイトル -->
            <div class="title-ranking2">
              <h5> </h5>
              <img src="assets/images/ashi_rank.png" width="100" height="45">
            </div>

            <!-- 句あし -->
            <div class="title-ranking"></div>
            <!-- 句あし1位 -->
            <div class="kuranking-1">
             
              <!-- 句の詳細 -->
              <div class="haiku">
                <div class="carousel-info">
                  <div class="pull-left">
                    <div class="active item">
                      <blockquote style="background: #d69090">
                        <div class="haiku-text">
                          <h2 class="haiku-text-1"><?php echo tateGaki($bad_haikus_info[0]['haiku_1']); ?></h2>
                          <h2 class="haiku-text-2"><?php echo tateGaki($bad_haikus_info[0]['haiku_2']); ?></h2>
                          <h2 class="haiku-text-3"><?php echo tateGaki($bad_haikus_info[0]['haiku_3']); ?></h2>
                        </div>
                      </blockquote>
                    </div>
                  </div>
                </div>
              </div><!-- 区の詳細ここまで -->

              <a class="pull-left" href="#"> 
                <img class="media-object picuture-position" src="assets/images/<?php echo $bad_haikus_info[0]['user_picture_path']; ?>" style="border-radius: 50px;">
              </a>
              <h1 ><?php echo $bad_haikus_info[0]['nick_name']; ?></h1>
              <h3><?php echo $bad_haiku_rank[0][1] ?> あし</h3>
            </div><!-- 句あし1位終了 -->

            <!-- 句あし2位以下 -->
            <div class="ranking-less2">
              <!-- 句あし2位 -->
              <div class="kuranking-2">
              
                <!-- 句の詳細 -->
                <div class="haiku">
                  <div class="carousel-info">
                    <div class="pull-left">
                      <div class="active item">
                          <blockquote style="background: #d69090">
                            <div class="haiku-text">
                              <h2 class="haiku-text-1"><?php echo tateGaki($bad_haikus_info[1]['haiku_1']); ?></h2>
                              <h2 class="haiku-text-2"><?php echo tateGaki($bad_haikus_info[1]['haiku_2']); ?></h2>
                              <h2 class="haiku-text-3"><?php echo tateGaki($bad_haikus_info[1]['haiku_3']); ?></h2>
                            </div>
                          </blockquote>
                        </div>
                      </div>
                    </div>
                  </div><!-- 句の詳細ここまで -->
                
                  <div class="media2">
                    <a class="pull-left" href="#">
                    <img class="media-object" src="assets/images/<?php echo $bad_haikus_info[1]['user_picture_path']; ?>" style="border-radius: 50px;">
                    </a>
                    <div class="media-body2">
                      <h4 class="media-heading"><?php echo $bad_haikus_info[1]['nick_name']; ?></h4>
                      <h4><?php echo $bad_haiku_rank[1][1] ?> あし</h4>
                    </div>
                  </div>
              </div><!-- 句あし2位終了 -->

              <!-- 句あし3位 -->
              <div class="kuranking-3">
                
                <!-- 句の詳細 -->
                <div class="haiku">
                  <div class="carousel-info">
                    <div class="pull-left">
                      <div class="active item">
                        <blockquote style="background: #d69090">
                          <div class="haiku-text">
                            <h2 class="haiku-text-1"><?php echo tateGaki($bad_haikus_info[2]['haiku_1']); ?></h2>
                            <h2 class="haiku-text-2"><?php echo tateGaki($bad_haikus_info[2]['haiku_2']); ?></h2>
                            <h2 class="haiku-text-3"><?php echo tateGaki($bad_haikus_info[2]['haiku_3']); ?></h2>
                          </div>
                        </blockquote>
                      </div>
                    </div>
                  </div>
                </div><!-- 句の詳細ここまで -->

                <div class="media2">
                  <a class="pull-left" href="#">
                    <img class="media-object" src="assets/images/<?php echo $bad_haikus_info[2]['user_picture_path']; ?>" style="border-radius: 50px;" >
                  </a>
                  <div class="media-body2">
                    <h4 class="media-heading"><?php echo $bad_haikus_info[2]['nick_name']; ?></h4>
                    <h5><?php echo $bad_haiku_rank[2][1] ?> あし</h5>
                  </div>
                </div>
              </div><!-- 句あし3位終了 -->
            </div><!-- 句あし2位以下終了 -->
          </div><!-- あしランキング終了 -->
        </div><!-- ランキングコンテンツ終了 -->
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

</body>
</html>

<!-- 順位のバックグラウンドをプロフィール画像に(順位を画像内に表示) -->
<!-- 各ランキングの画像のサイズ調節 -->
<!-- bootstrapで左右スクロール出来る物を探す(コラム/ニュース) -->
