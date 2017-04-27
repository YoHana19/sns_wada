<?php
session_start();
require('dbconnect.php');
$_SESSION['id'] = 1;
$_REQUEST['user_id'] = 3;

$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
$data = array($_REQUEST['user_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$another_user = $stmt->fetch(PDO::FETCH_ASSOC);

// 自分の作った全句を時系列で表示

$user_id = $_REQUEST['user_id'];
$sql = 'SELECT h.*, m.nick_name, m.user_picture_path FROM `haikus` AS h LEFT JOIN `members` AS m ON h.member_id=m.member_id WHERE h.member_id =? ORDER BY h.created';
$data = array($_REQUEST['user_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$user_ku1 = array();
while ($user_ku = $stmt->fetch(PDO::FETCH_ASSOC)){
  $user_ku1[] = $user_ku;
}

// echo '<pre>';
// var_dump($user_ku1);
// echo '</pre>';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/timeline.css">
  <link rel="stylesheet" type="text/css" href="assets/css/user.css">
</head>
<body>

<!--プロフィール写真/ 一言-->
  <img align="left" class="fb-image-lg" src="assets/images/<?php echo $another_user['back_picture_path']; ?>" alt="Profile image example"/>
  <img align="left" class="fb-image-profile thumbnail" src="assets/images/<?php echo $another_user['user_picture_path']; ?>" alt="Profile imexample"/>
  
  <div class="container">
   <h1><?php echo $another_user['nick_name']; ?></h1>
    <p><?php echo $another_user['self_intro']; ?></p>
  </div>

  </div>
   <?php foreach ($user_ku1 as $user_ku2): ?>
    <div class="well_3">
          <div class="media">
            <a class="pull-left" href="chat.php">
              <img class="media-object" src="assets/images/<?php echo $user_ku2['user_picture_path']; ?>">
            </a>
              <div class="media-body">
                  <p class="text-right"></p>
                  <p>・<?php echo $user_ku2['haiku_1']; ?></p>
                  <p>・<?php echo $user_ku2['haiku_2']; ?></p>
                  <p>・<?php echo $user_ku2['haiku_3']; ?></p>
                  <p><?php echo $user_ku2['created']; ?></p>
              </div>
          </div>
    </div>
  <?php endforeach; ?>
  

</body>
</html>