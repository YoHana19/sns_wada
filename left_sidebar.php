<?php 

require 'dbconnect.php';
session_start();
$_SESSION['id'] = 1;
// $sql = 'SELECT * FROM `friends` f, `chats` c WHERE f.login_member_id = c.sender_id OR f.login_member_id = c.reciever_id AND f.login_member_id =?';
// $stmt = $dbh->prepare($sql);
// $stmt->execute(); //
// executeで取得したデータはobject型である
// このままではPHPで扱いづらい
// echo'<pre>';
// var_dump($stmt);
// echo'</pre>';
$sql = 'SELECT * FROM `chats` WHERE `sender_id` = ? ORDER BY `created` DESC';
$data = array($_SESSION['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data); //
$friends =array();
// $chat = $stmt->fetch(PDO::FETCH_ASSOC);
while ($chat = $stmt->fetch(PDO::FETCH_ASSOC)){
    $sql = 'SELECT * FROM `members` WHERE `member_id` = ?';
    $data1 = array($chat['reciever_id']);
    $stmt1 = $dbh->prepare($sql);
    $stmt1->execute($data1);
    $member = $stmt1->fetch(PDO::FETCH_ASSOC);

    $friends[] =array('member_id'=>$member['member_id'],
                    'nick_name'=>$member['nick_name']);

}
// var_dump($chat);
var_dump($friends);
echo '<br>';

$c = count($friends);
if ($c >= 10) {
    for ($i=0; $i < 10; $i++) { 
      $ii = $i + 1;
        echo '友達'. $ii .'name;' . $friends[$i]['nick_name'] .'<br>';
    }
}else{
    for ($i=0; $i < $c; $i++) {
    $ii = $i + 1; 
        echo '友達'. $ii .'name;' . $friends[$i]['nick_name'] .'<br>';
    }
}
 ?>
 <!DOCTYPE html>
<html lang="ja">
<head>
<title>左サイドバー</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../assets/css/left_sidebar.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css"> <!-- bootsnippを使うためには必要 -->
</head>
<body>
<!-- 簡易個人プロフ作成 -->
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <img src="assets/images/saito.jpeg" class="img-responsive img-circle" />
        <h1>齋藤 由佳</h1>
        <p>おねぇさん トレンディだね 齋藤さん</p>
        <div class="clearfix"></div>

        <div class="panel panel-default">  <!-- 「Friends」の一番上の枠 -->
          <div class="panel-heading c-list">  <!-- 「Friends」の一番上の枠のパネル -->
            <span class="title">Friend's</span>
          </div>

          <!-- 直近連絡とった友達順に10件表示 -->
          <li class="list-group-item">
            <div class="col-xs-12 col-sm-6">
              <img src="assets/images/wada.jpg" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-10">
              <span class="name">和田 隆宏</span>
              <p>わだわだや<br> あぁわだわだや<br> わだわだや</p>
            </div>
            <div class="clearfix"></div>
          </li>
          <li class="list-group-item">
            <div class="col-xs-12 col-sm-6">
              <img src="assets/images/wada.jpg" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-10">
              <span class="name">和田 隆宏</span>
              <p>わだわだや<br> あぁわだわだや<br> わだわだや</p>
            </div>
            <div class="clearfix"></div>
          </li>
          <li class="list-group-item">
            <div class="col-xs-12 col-sm-6">
              <img src="assets/images/wada.jpg" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-10">
              <span class="name">和田 隆宏</span>
              <p>わだわだや<br> あぁわだわだや<br> わだわだや</p>
            </div>
            <div class="clearfix"></div>
          </li>
          <li class="list-group-item">
            <div class="col-xs-12 col-sm-6">
            <img src="assets/images/wada.jpg" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-10">
              <span class="name">和田 隆宏</span>
              <p>わだわだや<br> あぁわだわだや<br> わだわだや</p>
            </div>
            <div class="clearfix"></div>
          </li>
          <li class="list-group-item">
            <div class="col-xs-12 col-sm-6">
              <img src="assets/images/wada.jpg" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-10">
              <span class="name">和田 隆宏</span><br/>
              <p>わだわだや<br> あぁわだわだや<br> わだわだや</p>
            </div>
            <div class="clearfix"></div>
          </li>
          <li class="list-group-item">
            <div class="col-xs-12 col-sm-6">
              <img src="assets/images/wada.jpg" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-10">
              <span class="name">和田 隆宏</span>
              <p>わだわだや<br> あぁわだわだや<br> わだわだや</p>
            </div>
            <div class="clearfix"></div>
          </li>
            <li class="list-group-item">
            <div class="col-xs-12 col-sm-6">
              <img src="assets/images/wada.jpg" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-10">
              <span class="name">和田 隆宏</span>
              <p>わだわだや<br> あぁわだわだや<br> わだわだや</p>
            </div>
            <div class="clearfix"></div>
          </li>
            <li class="list-group-item">
            <div class="col-xs-12 col-sm-6">
              <img src="assets/images/wada.jpg" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-10">
              <span class="name">和田 隆宏</span>
              <p>わだわだや<br> あぁわだわだや<br> わだわだや</p>
            </div>
            <div class="clearfix"></div>
          </li>
            <li class="list-group-item">
            <div class="col-xs-12 col-sm-6">
              <img src="../assets/images/wada.jpg" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-10">
              <span class="name">和田 隆宏</span>
              <p>わだわだや<br> あぁわだわだや<br> わだわだや</p>
            </div>
            <div class="clearfix"></div>
          </li>
            <li class="list-group-item">
            <div class="col-xs-12 col-sm-6">
              <img src="../assets/images/wada.jpg" class="img-responsive img-circle" />
            </div>
            <div class="col-xs-12 col-sm-10">
              <span class="name">和田 隆宏</span>
              <p>わだわだや<br> あぁわだわだや<br> わだわだや</p>
            </div>
            <div class="clearfix"></div>
          </li>
        </div>
      </div>
    </div>
  </div>
</body>
</html>