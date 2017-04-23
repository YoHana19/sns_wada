<?php
session_start();
require('dbconnect.php');

// ログインユーザーの写真
$sql = 'SELECT * FROM `members` WHERE `member_id`=?';
$data = array($_SESSION['login_member_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$login_user = $stmt->fetch(PDO::FETCH_ASSOC);
$login_user_picture = $login_user['user_picture_path'];

// ページング機能
// ページ番号を取得
$_SESSION['page'] += 1;
$page = $_SESSION['page'];

// 最後のページ判定のフラグを立てる
$last_page = 0;
if ($page > $_POST['max_page']) {
  $last_page = 1;
}

// パラメータのベージ番号が最大ページ数を超えていれば、最後のページ数とする
$page = min($page, $_POST['max_page']);

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

// 句の表示に必要な情報を取得し、各$postに連結
// 繰り返し処理 
$num = 0;
foreach ($posts as $post) {

  // 削除ボタン用のフラグ
  $login_flag = 0;
  if ($_SESSION['login_member_id'] == $post['member_id']) {
    $login_flag =1;
  }

  // コメントの取得
  $sql = 'SELECT c.*, m.nick_name, m.user_picture_path FROM `comments` AS c LEFT JOIN `members` AS m ON c.member_id=m.member_id WHERE `haiku_id`=? ORDER BY c.created DESC';
  $data = array($post['haiku_id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $comments = array();
  while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $comments[] = $record;
  }

  // よし！済みかどうかの判定フラグ
  $sql = 'SELECT * FROM `likes` WHERE `member_id`=? AND `haiku_id`=?';
  $data = array($_SESSION['login_member_id'],$post['haiku_id']);
  $is_like_stmt = $dbh->prepare($sql);
  $is_like_stmt->execute($data);

  if ($is_like = $is_like_stmt->fetch(PDO::FETCH_ASSOC)) {
    $state = 'unlike';
  } else {
    $state = 'like';
  }

  // よし数のカウント
  $sql = 'SELECT count(*) AS total FROM `likes` WHERE `haiku_id`=?';
  $data = array($post['haiku_id']);
  $count_stmt = $dbh->prepare($sql);
  $count_stmt->execute($data);
  $count = $count_stmt->fetch(PDO::FETCH_ASSOC);

  // $postに各情報を連結
  $post += array('login_flag' => $login_flag,
                 'comments' => $comments,
                 'state' => $state,
                 'like_total' => $count['total']
                 );

  // $postsの更新
  $posts["$num"] = $post;

  // posts更新用
  $num += 1;

}; // foreach文の終了

$data = array('login_user_picture' => $login_user_picture,
              'last_page' => $last_page,
              'posts' => $posts
             );

header("Content-type: text/plain; charset=UTF-8");
//ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）
echo json_encode($data); // PHPとJS間でデータのやり取りを行うためにjson形式（{"hoge":"hoge","hoge":"hoge",....}）でデータを送る
?>