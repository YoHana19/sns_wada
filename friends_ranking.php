<?php
require('dbconnect.php');

// 友達内ランキングよし(歌人)用sql文
// friendsテーブルのlogin_member_idがログインしているユーザーのidと一致する場合
$sql = 'SELECT * FROM `likes` AS l LEFT JOIN `friends` AS f ON l.haiku_member_id=f.friend_member_id WHERE f.login_member_id=? AND f.state=1';
$data = array($_SESSION['login_member_id']); //$dataには ? に入れる値を書く
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$like_haiku_ids = array();
while($like_haiku_1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $like_haiku_ids[] = $like_haiku_1['haiku_member_id'];
}

// friendsテーブルのfriend_member_idがログインしているユーザーのidと一致する場合
$sql = 'SELECT * FROM `likes` AS l LEFT JOIN `friends` AS f ON l.haiku_member_id=f.login_member_id WHERE f.friend_member_id=? AND f.state=1';
$data = array($_SESSION['login_member_id']); //$dataには ? に入れる値を書く
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while($like_haiku_2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $like_haiku_ids[] = $like_haiku_2['haiku_member_id'];
}

$like_haiku_rank = rankGet($like_haiku_ids);

// プロフ画像、名前取得
$like_haikus_info = array();
foreach ($like_haiku_rank as $like_haiku) {
  $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $data = array($like_haiku[0]);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  $like_haikus_info[] = $record;
}

// 友達内ランキングあし(歌人)用sql文
// friendsテーブルのlogin_member_idがログインしているユーザーのidと一致する場合
$sql = 'SELECT * FROM `dislikes` AS d LEFT JOIN `friends` AS f ON d.haiku_member_id=f.friend_member_id WHERE f.login_member_id=? AND f.state=1';
$data = array($_SESSION['login_member_id']); //$dataには ? に入れる値を書く
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$dislike_haiku_ids = array();
while($dislike_haiku_1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $dislike_haiku_ids[] = $dislike_haiku_1['haiku_member_id'];
}

// friendsテーブルのfriend_member_idがログインしているユーザーのidと一致する場合
$sql = 'SELECT * FROM `dislikes` AS d LEFT JOIN `friends` AS f ON d.haiku_member_id=f.login_member_id WHERE f.friend_member_id=? AND f.state=1';
$data = array($_SESSION['login_member_id']); //$dataには ? に入れる値を書く
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while($dislike_haiku_2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $dislike_haiku_ids[] = $dislike_haiku_2['haiku_member_id'];
}

$dislike_haiku_rank = rankGet($dislike_haiku_ids);

// プロフ画像、名前取得
$dislike_haikus_info = array();
foreach ($dislike_haiku_rank as $dislike_haiku) {
  $sql = 'SELECT * FROM `members` WHERE `member_id`=?';
  $data = array($dislike_haiku[0]);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  $dislike_haikus_info[] = $record;
}

// ランキング上位3名のユーザー名、プロフィール画像取得

?>

<!-- ** -->
<!-- htmlコンテンツ -->
<!-- ** -->

<!-- ランキングタイトル -->
<div class="f-rank-title-wrap">
  <img class="f-rank-title-1" src="assets/images/source/rank_title_1.png" alt="">
  <img class="f-rank-title-2" src="assets/images/source/rank_title_2.png" alt="">
  <img class="f-rank-img" src="assets/images/source/rank.png" alt="">
</div>

<div class="row">

  <!-- よし ランキング -->
  <div class="col-md-6">

    <!-- よしタイトル -->
    <div class="title-ranking">
      <img src="assets/images/source/yoshi.png" alt="">
    </div>

    <!-- よしランキング1位 -->
    <?php if(isset($like_haikus_info[0])): ?>
      <div class="ranking ranking-1">
        <img class="media-object" src="assets/images/users/<?php echo $like_haikus_info[0]['user_picture_path'] ?>">
        <a href="user.php?user_id=<?php echo $like_haikus_info[0]['member_id'] ?>" style="color: black;"><h1><?php echo $like_haikus_info[0]['nick_name'] ?></h1></a>
        <p><?php echo $like_haiku_rank[0][1] ?> よし</p>
      </div>
    <?php endif; ?>

    <!-- よしランキング2位 -->
    <?php if(isset($like_haikus_info[1])): ?>
      <div class="ranking ranking-2">
        <img class="media-object" src="assets/images/users/<?php echo $like_haikus_info[1]['user_picture_path'] ?>">
        <a href="user.php?user_id=<?php echo $like_haikus_info[1]['member_id'] ?>" style="color: black;"><h4><?php echo $like_haikus_info[1]['nick_name'] ?></h4></a>
        <p><?php echo $like_haiku_rank[1][1] ?> よし</p>
      </div>
    <?php endif; ?>

    <!-- よしランキング2位 -->
    <?php if(isset($like_haikus_info[2])): ?>
      <div class="ranking ranking-3">
        <img class="media-object" src="assets/images/users/<?php echo $like_haikus_info[2]['user_picture_path'] ?>">
        <a href="user.php?user_id=<?php echo $like_haikus_info[2]['member_id'] ?>" style="color: black;"><h4><?php echo $like_haikus_info[2]['nick_name'] ?></h4></a>
        <p><?php echo $like_haiku_rank[2][1] ?> よし</p>
      </div>
    <?php endif; ?>

  </div>


  <!--あし ランキング -->
  <div class="col-md-6">

    <!-- あしタイトル -->
    <div class="title-ranking">
      <img src="assets/images/source/ashi.png" alt="">
    </div>

    <!--あしランキング1位 -->
    <?php if(isset($dislike_haikus_info[0])): ?>
      <div class="ranking ranking-1">
        <img class="media-object" src="assets/images/users/<?php echo $dislike_haikus_info[0]['user_picture_path'] ?>">
        <a href="user.php?user_id=<?php echo $dislike_haikus_info[0]['member_id'] ?>" style="color: black;"><h1><?php echo $dislike_haikus_info[0]['nick_name'] ?></h1></a>
        <p><?php echo $dislike_haiku_rank[0][1] ?> あし</p>
      </div>
    <?php endif; ?>

    <!--あしランキング2位 -->
    <?php if(isset($dislike_haikus_info[1])): ?>
      <div class="ranking ranking-2">
        <img class="media-object" src="assets/images/users/<?php echo $dislike_haikus_info[1]['user_picture_path'] ?>">
        <a href="user.php?user_id=<?php echo $dislike_haikus_info[1]['member_id'] ?>" style="color: black;"><h4><?php echo $dislike_haikus_info[1]['nick_name'] ?></h4></a>
        <p><?php echo $dislike_haiku_rank[1][1] ?> あし</p>
      </div>
    <?php endif; ?>
    
    <!--あしランキング3位 -->
    <?php if(isset($dislike_haikus_info[2])): ?>
      <div class="ranking ranking-3">
        <img class="media-object" src="assets/images/users/<?php echo $dislike_haikus_info[2]['user_picture_path'] ?>">      
        <a href="user.php?user_id=<?php echo $dislike_haikus_info[2]['member_id'] ?>" style="color: black;"><h4><?php echo $dislike_haikus_info[2]['nick_name'] ?></h4></a>
        <p><?php echo $dislike_haiku_rank[2][1] ?> あし</p>
      </div>
    <?php endif; ?>

  </div>

</div>

