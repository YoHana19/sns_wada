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

echo '<pre>';
var_dump($haikus_info);
echo '</pre>';

foreach ($haikus_info as $haiku_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  echo $haiku_info['nick_name'];
  echo '<br>';
  echo $haiku_info['haiku_1'];
  echo '<br>';
  echo $haiku_info['haiku_2'];
  echo '<br>';
  echo $haiku_info['haiku_3'];
  echo "<br>" . "<br>";
}

foreach ($haiku_rank as $haiku) { //(良し数)
  echo $haiku[1] . '<br>';
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

echo "<pre>";
var_dump($members_info);
echo "</pre>";

foreach ($members_info as $member_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  echo $member_info['nick_name'];
  echo '<br>' . '<br>';
}

foreach ($member_rank as $member) { //(良し数)
  echo $member[1];
  echo '<br>';
}

var_dump($member);



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

foreach ($bad_haikus_info as $bad_haiku_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  echo $bad_haiku_info['nick_name'];
  echo '<br>';
  echo $bad_haiku_info['haiku_1'];
  echo '<br>';
  echo $bad_haiku_info['haiku_2'];
  echo '<br>';
  echo $bad_haiku_info['haiku_3'];
  echo "<br>" . "<br>";
}

foreach ($bad_haiku_rank as $bad_haiku) { //(悪し数)
  echo $bad_haiku[1] . '<br>';
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

foreach ($bad_members_info as $bad_member_info) { // foreachで取り出した$haikus_infoの要素名を$haiku_infoとし、echoで出力(ユーザー名, 句)
  echo $bad_member_info['nick_name'];
  echo '<br>' . '<br>';
}

foreach ($bad_member_rank as $bad_member) { //(良し数)
  echo $bad_member[1];
  echo '<br>';

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

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/ranking.css">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="assets/css/timeline.css">
</head>
<body class="background">
<!-- <body> -->
  <?php foreach ($haikus_info as $haiku_info) : ?>
    <a href="profile.php"><?php echo $haiku_info['nick_name']; ?></a><br>
    <a href="profile.php"><?php echo $member_info['nick_name']; ?></a><br>
    <a href="profile.php"><?php echo $bad_haiku_info['nick_name']; ?></a><br>
    <a href="profile.php"><?php echo $bad_member_info['nick_name']; ?></a><br>
  <?php endforeach; ?>
  <?php echo '<br>'; ?>
  <?php foreach ($haikus_info as $haiku_info): ?>
    <img src="assets/images/<?php echo $haiku_info['user_picture_path']; ?>" width="100" height="100">
    <img src="assets/images/<?php echo $member_info['user_picture_path']; ?>" width="100" height="100">
    <img src="assets/images/<?php echo $bad_haiku_info['user_picture_path']; ?>" width="100" height="100">
    <img src="assets/images/<?php echo $bad_member_info['user_picture_path']; ?>" width="100" height="100">
  <?php endforeach; ?>
  <!--  背景 -->

<!-- 自分情報(左上のやつ) -->
<div class="container">
  <div class="row">
    <div class="col-md-3"><br><br>
  </div>

  <div class="col-md-9">

    <div class="ranking-column">
    <h4><img src="../assets/images/column.png" width="200" height="60">
    </h4>
    </div>

  <!-- コラム/ランキング -->
    <div class="col-md-4 col-md-push-4">
      <img class="img-responsive img-circle" src="https://farm1.staticflickr.com/1/2759520_6dea8b9007.jpg" alt="Greece-1173 - Temple of Athena by Dennis Jarvis, on Flickr">
    </div>

    <div class="col-md-4 col-md-pull-4 ">
      <img class="img-responsive img-circle" src="https://farm2.staticflickr.com/1109/809710325_4289dc484e.jpg" alt="Greece-1173 - Temple of Athena by Dennis Jarvis, on Flickr">
    </div>

    <div class="col-md-4">
      <img class="img-responsive img-circle" src="https://farm3.staticflickr.com/2353/2216602404_679d01cd4b.jpg" alt="Greece-1173 - Temple of Athena by Dennis Jarvis, on Flickr"><br><br>
    </div>
  </div>
  <div class="row">
    <div class="col-md-offset-3 col-md-9">
      <div class="runking-title">
        <img src="assets/images/rank-title.png" width="500" height="80">
    </div>
    </div>
  </div>

<!-- ランキング -->
<div class="col-md-offset-3 col-md-9 yosi-ranking"> 
  <!-- 歌人 -->
  <h5><img src="../assets/images/kajin.png" width="120" height="70"></h5>
  <!-- よし ランキング -->
      <div class="col-md-6">
        <!-- 歌人よしランキング1位 -->
        <div class="title-ranking">
          <img src="assets/images/yoshi.png" width="80" height="45">
        </div>
          <div class="ranking-1">
            <div class="photo"><img class="media-object picuture-position" src="assets/images/<?php echo $haiku_info['user_picture_path']; ?>"></div>
            <h1><?php echo $haiku_info['nick_name'][0]; ?></h1>
            <div class="point"><?php echo $haiku[0] ?>よし</div>
          </div>
        
        <!-- 俳人よしランキング2位以下 -->
        <div class="ranking-less2">
          <div class="ranking-2">
            <div class="media">
              <img class="media-object" src="assets/images/<?php echo $haiku_info['user_picture_path']; ?>">
              <div class="media-body">
                <h4 class="media-heading"><?php echo $haiku_info['nick_name']; ?></h4>
                <p><?php echo $haiku[1] ?>よし</p>
              </div>
            </div>
          </div>
  
          <div class="ranking-3">
            <div class="media">
              <img class="media-object" src="assets/images/<?php echo $haiku_info['user_picture_path']; ?>">
              <div class="media-body">
                <h4 class="media-heading"><?php echo $haiku_info['nick_name']; ?></h4>
                <p><?php echo $haiku[2] ?>よし</p>
              </div>
            </div>
          </div>
        </div>
              <!-- 句 -->
        <div class="ku-name"><h5><img src="assets/images/ku.png" width="80" height="60"></h5></div>
        <h3></h3>

<!-- 俳人よしランキング1位 -->
        <div class="title-ranking">
          <img src="../assets/images/yoshi.png" width="80" height="45" >
        </div>
        <div class="kuranking-1">
            <!-- 句の詳細 -->
          <div class="haiku">
            <div class="carousel-info">
              <div class="pull-left">
                <div class="active item">
                  <blockquote style="background: #d69090">
                    <div class="haiku-text">
                      <h2 class="haiku-text-1">桜<br>か<br>な</h2>
                      <h2 class="haiku-text-2">事<br>思<br>ひ<br>出<br>す</h2>
                      <h2 class="haiku-text-3">さ<br>ま<br>ざ<br>ま<br>な</h2>
                    </div>
                  </blockquote>
                </div>
              </div>
            </div>
          </div>
             <!-- 区の詳細ここまで -->
          <a class="pull-left" href="#">
          <div class="photo"><img class="media-object picuture-position" src="../assets/images/wada.jpg" style="border-radius: 50px;"></div>
          </a>
          <div class="name"><h1>たかさん</h1></div>
            <h3>30 よし</h3>
          </div>
  
        <!-- 俳人よしランキング2位以下 -->
          <div class="ranking-less2">
            <div class="kuranking-2">
          
            <!-- 句の詳細 -->
              <div class="haiku">
                <div class="carousel-info">
                  <div class="pull-left">
                    <div class="active item">
                      <blockquote style="background: #d69090">
                        <div class="haiku-text">
                          <h2 class="haiku-text-1">桜<br>か<br>な</h2>
                          <h2 class="haiku-text-2">事<br>思<br>ひ<br>出<br>す</h2>
                          <h2 class="haiku-text-3">さ<br>ま<br>ざ<br>ま<br>な</h2>
                        </div>
                      </blockquote>
                    </div>
                  </div>
                </div>
              </div>
             <!-- 区の詳細ここまで -->
            
              <div class="media2">
                <a class="pull-left" href="#">
                <img class="media-object" src="http://placekitten.com/110/110" style="border-radius: 50px;">
                </a>
                <div class="media-body2">
                  <h4 class="media-heading">ユーザー名</h4>
                  <h4>15 よし</h4>
                </div>
              </div>
            </div>
  
          <div class="kuranking-3">
            
            <!-- 句の詳細 -->
            <div class="haiku">
              <div class="carousel-info">
                <div class="pull-left">
                  <div class="active item">
                    <blockquote style="background: #d69090">
                      <div class="haiku-text">
                        <h2 class="haiku-text-1">桜<br>か<br>な</h2>
                        <h2 class="haiku-text-2">事<br>思<br>ひ<br>出<br>す</h2>
                        <h2 class="haiku-text-3">さ<br>ま<br>ざ<br>ま<br>な</h2>
                      </div>
                    </blockquote>
                  </div>
                </div>
              </div>
            </div>
             <!-- 区の詳細ここまで -->

            <div class="media2">
              <a class="pull-left" href="#">
                <img class="media-object" src="http://placekitten.com/110/110" style="border-radius: 50px;">
              </a>
              <div class="media-body2">
                <h4 class="media-heading">ユーザー名</h4>
                <h5>3 よし</h5>
              </div>
            </div>
          </div>
        </div>
      </div><!--col-md-6-->






    <!--あし ランキング -->
      <div class="col-md-6">
        <!-- あしランキングトップ画像 -->
        <div class="title-ranking">
          <img src="../assets/images/ashi.png" width="100" height="45">
        </div>
        <div class="ranking-1">
          <img class="media-object picuture-position" src="http://placekitten.com/255/255">
          <h1>さいとうさん</h1>
          <h3>30 あし</h3>
        </div>
  
        <!--あし ランキング2位以下 -->
        <div class="ranking-less2">
          <div class="ranking-2">
            <div class="media">
              <img class="media-object" src="http://placekitten.com/110/110">
              <div class="media-body">
                <h4>ユーザー名</h4>
                <h4>15 あし</h4>
              </div>
            </div>
          </div>

          <div class="ranking-3">
            <div class="media">
              <img class="media-object" src="http://placekitten.com/110/110">
              <div class="media-body">
                <h4>ユーザー名</h4>
                <h5>3 あし</h5>
              </div>
            </div>
          </div>
        </div>
      <!-- 句 -->
        <div class="title-ranking2">
          <h5> </h5>
          <img src="../assets/images/ashi.png" width="100" height="45">
        </div>
          <!-- あしランキングトップ画像 -->
        <div class="title-ranking"></div>
          <div class="kuranking-1">
           
          <!-- 句の詳細 -->
            <div class="haiku">
              <div class="carousel-info">
                <div class="pull-left">
                  <div class="active item">
                    <blockquote style="background: #d69090">
                      <div class="haiku-text">
                        <h2 class="haiku-text-1">桜<br>か<br>な</h2>
                        <h2 class="haiku-text-2">事<br>思<br>ひ<br>出<br>す</h2>
                        <h2 class="haiku-text-3">さ<br>ま<br>ざ<br>ま<br>な</h2>
                      </div>
                    </blockquote>
                  </div>
                </div>
              </div>
            </div>
             <!-- 区の詳細ここまで -->

            <a class="pull-left" href="#"> 
              <img class="media-object picuture-position" src="http://placekitten.com/255/255" style="border-radius: 50px;">
            </a>
            <h1 >さいとうさん</h1>
            <h3>30 あし</h3>


        <!-- 俳人あし
        ランキング2位以下 -->
          <div class="ranking-less2">
            <div class="kuranking-2">
          
            <!-- 句の詳細 -->
              <div class="haiku">
                <div class="carousel-info">
                  <div class="pull-left">
                    <div class="active item">
                      <blockquote style="background: #d69090">
                        <div class="haiku-text">
                          <h2 class="haiku-text-1">桜<br>か<br>な</h2>
                          <h2 class="haiku-text-2">事<br>思<br>ひ<br>出<br>す</h2>
                          <h2 class="haiku-text-3">さ<br>ま<br>ざ<br>ま<br>な</h2>
                        </div>
                      </blockquote>
                    </div>
                  </div>
                </div>
              </div>
             <!-- 区の詳細ここまで -->
            
              <div class="media2">
                <a class="pull-left" href="#">
                <img class="media-object" src="http://placekitten.com/110/110" style="border-radius: 50px;">
                </a>
                <div class="media-body2">
                  <h4 class="media-heading">ユーザー名</h4>
                  <h4>15 あし</h4>
                </div>
              </div>
            </div>
  
          <div class="kuranking-3">
            
            <!-- 句の詳細 -->
            <div class="haiku">
              <div class="carousel-info">
                <div class="pull-left">
                  <div class="active item">
                    <blockquote style="background: #d69090">
                      <div class="haiku-text">
                        <h2 class="haiku-text-1">桜<br>か<br>な</h2>
                        <h2 class="haiku-text-2">事<br>思<br>ひ<br>出<br>す</h2>
                        <h2 class="haiku-text-3">さ<br>ま<br>ざ<br>ま<br>な</h2>
                      </div>
                    </blockquote>
                  </div>
                </div>
              </div>
            </div>
             <!-- 区の詳細ここまで -->

            <div class="media2">
              <a class="pull-left" href="#">
                <img class="media-object" src="http://placekitten.com/110/110" style="border-radius: 50px;" >
              </a>
              <div class="media-body2">
                <h4 class="media-heading">ユーザー名</h4>
                <h5>3 あし</h5>
              </div>
            </div>
          </div>
        </div>
      </div><!--col-md-6-->
    </div>
  </div><!--col-md-6-->
</div>



</body>
</html>

<!-- 順位のバックグラウンドをプロフィール画像に(順位を画像内に表示) -->
<!-- 各ランキングの画像のサイズ調節 -->
<!-- bootstrapで左右スクロール出来る物を探す(コラム/ニュース) -->