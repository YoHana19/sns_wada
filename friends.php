<?php
session_start();
require('dbconnect.php');
$_SESSION['id'] = 1;

$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
$data = array($_SESSION['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login = $stmt->fetch(PDO::FETCH_ASSOC);

// ログインユーザーの友達のid取得
$sql = 'SELECT * FROM `friends` WHERE `login_member_id`=?';
$data = array($_SESSION['id']);
$stmt2 = $dbh->prepare($sql);
$stmt2->execute($data);

$friends = array();
while ($friend_member_ids = $stmt2->fetch(PDO::FETCH_ASSOC)){
	$friends[] = $friend_member_ids;
}


// memberテーブルからログインユーザーフレンドのid取得
$all_friend = array();
foreach ($friends as $friend_member_id) {
	$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
	$data = array($friend_member_id['friend_member_id']);
	$stmt = $dbh->prepare($sql);
	$stmt->execute($data);
	$friend_member = $stmt->fetch(PDO::FETCH_ASSOC);
  $all_friend[] = $friend_member;
}

// sort($all_friend);

// 友達検索結果表示
$search_word = '';
if (isset($_GET['search_word']) && !empty($_GET['search_word'])) {
    // 検索の場合の処理
    $sql = 'SELECT m.*, f.friend_member_id FROM `members` AS m LEFT JOIN `friends` AS f ON m.member_id=f.friend_member_id WHERE m.nick_name LIKE ? ORDER BY m.nick_name';
    $w = '%' . $_GET['search_word'] . '%';
    $data = array($w);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $search_word = $_GET['search_word'];
    
    $friends = array();
    while ($search_friend = $stmt->fetch(PDO::FETCH_ASSOC)){
      $friends[] = $search_friend;

    }
} else {
      // 通常の処理
    $sql = 'SELECT m.*, f.friend_member_id FROM `members` AS m LEFT JOIN `friends` AS f ON m.member_id=f.friend_member_id ORDER BY m.nick_name';
    $data = array();
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $friends = array();
    while ($search_friend = $stmt->fetch(PDO::FETCH_ASSOC)){
      $friends[] = $search_friend;
    }

}

// ログインフレンド数カウント
// var_dump(count($friends));
$search_friend_count = count($friends);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <!-- 後々統一する -->
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
  <!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->
  <link rel="stylesheet" type="text/css" href="assets/css/friends_design.css">
</head>

<body>

<div class="container">
  <div class="row">
    <div class="col-md-3">

        <form method="GET" action="" role="form">
          <input type="text" name="search_word" value="<?php echo $search_word; ?>">
          <input type="submit" value="検索" class="btn btn-success btn-xs">
        </form>

      <h4><b>自分情報</b></h4>
      <div class="well_2">
        <div class="media">
          <a class="pull-left" href="profile.php">
            <img class="media-object" src="assets/images/<?php echo $login['user_picture_path']; ?>">
          </a>
            <div class="media-body">
              <h4 class="media-heading">・<?php echo $login['nick_name']; ?></h4>
              <p class="text-right"></p>
              <p>・<?php echo $login['self_intro']; ?></p>
            </div>
        </div>
      </div>

      <h4>友達一覧 (<?php echo $search_friend_count; ?>人)</h4>

      <?php if ($search_friend_count == 0) {
        echo '検索結果なし';
      } ?>
 
      <?php foreach ($friends as $friend): ?>
        <div class="well_3">
          <div class="media">
            <a class="pull-left" href="chat.php">
              <img class="media-object" src="assets/images/<?php echo $friend['user_picture_path']; ?>">
            </a>
              <div class="media-body">
                <h4 class="media-heading">・<?php echo $friend['nick_name']; ?></h4>
                  <p class="text-right"></p>
                  <p>・<?php echo $friend['self_intro']; ?></p>
              </div>
          </div>
        </div>
      <?php endforeach; ?>

    
          
    </div><!-- ランキングのrow -->

  </div><!-- でかいrow1 -->

</div>  <!-- コンテイナー -->
</body>
</html>

<!-- col-md-9 の範囲内でサイズの変更 -->
<!-- ランキングの後ろにバックグラウンドの指定 -->