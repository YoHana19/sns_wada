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

            <!-- 投稿 -->
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

  <!-- 自動スクロール -->
  <script type="text/javascript">
    $(document).ready(function() {
      var win = $(window);

      // Each time the user scrolls
      win.scroll(function() {
        // End of the document reached?
        if ($(document).height() - win.height() == win.scrollTop()) {
          $('#loading').show();

          var data = {max_page : <?php echo $max_page; ?>};

          $.ajax({
            type: "POST",
            url: 'get_post.php',
            data: data,

          }).done(function(data) {
            var task_data = JSON.parse(data);
            var posts = task_data['posts'];
            var page = task_data['last_page'];
            
            if (page == 0) { // 最後の投稿ではない

              // 繰り返し文
              posts.forEach(function(post) {

                // パラメータ設定
                var member_id = post['member_id'];
                var haiku_id = post['haiku_id'];
                var nick_name = post['nick_name'];
                var user_picture_path = post['user_picture_path'];
                var haiku_1 = post['haiku_1'];
                var haiku_2 = post['haiku_2'];
                var haiku_3 = post['haiku_3'];
                var created = post['created'];
                var num_like = 'num_like_' + haiku_id;
                var comment_id = 'com_id_' + haiku_id;

                console.log(comment_id);
                console.log(post);

                // htmlへの追加

                $('#posts').append('<div class="haiku"><div class="carousel-info"><img alt="" src="assets/images/' + user_picture_path + '" class="pull-left"><div class="pull-left"><span class="haiku-name">' + nick_name + '</span><span calss="haiku-comment">' + post['short_comment'] + '</span></div><p>' + created + '</p></div><div class="active item"><blockquote style="background:#fff0f5"><div class="haiku-text"><h2 class="haiku-text-1">' + tateGaki(haiku_3) + '<h2 class="haiku-text-2">' + tateGaki(haiku_2); + '</h2><h2 class="haiku-text-3">' + tateGaki(haiku_3); + '</h2></div></blockquote></div><div style="text-align: right;"><div style="float: left"><i id="' + num_like + ' class="glyphicon glyphicon-thumbs-up icon-margin">&thinsp;' + post['like_total'] + '人</i><i class="glyphicon glyphicon-thumbs-down icon-margin">&thinsp;5人</i><i class="fa fa-commenting-o icon-margin" aria-hidden="true">&thinsp;3件</i></div><i class="fa fa-facebook-official fa-2x" aria-hidden="true" style="color: #3b5998"></i><i class="fa fa-twitter-square fa-2x" aria-hidden="true" style="color: #00a1e9"></i></div>');

                console.log('hoge1');

                // // 削除ボタンの設置
                // var login_flag = post['login_flag'];
                // console.log('login_flag' + login_flag);
                // if (login_flag == 1) {
                //   $('#posts').append('[<a href="delete.php?haiku_id=' + haiku_id + '" style="color: #F33;">削除</a>]');
                // }


                // よし・あし処理
                var state = post['state'];

                if (state == 'unlike') {
                  $('#posts')
                  .append('<button type="button" id="' + haiku_id + '" class="like btn icon-btn btn-primary btn-color-like"><span id="' + haiku_id + '_icon" class="glyphicon btn-glyphicon glyphicon-thumbs-up img-circle text-color-like"></span>よし</button>')
                  .on('click', '#' + haiku_id, function() { // よし機能
                    var haiku_id = $(this).attr('id'); // クリックされたタグのhaiku_idの値を取得
                    var data = {haiku_id : haiku_id}; 
                    
                    $.ajax({
                        type: "POST",
                        url: "send_like.php",
                        data: data,
                    
                    }).done(function(data) {
                      
                      var task_data = JSON.parse(data);
                      var input_tag = document.getElementById(task_data['id']);
                      var input_icon = document.getElementById(task_data['id'] + '_icon');
                      console.log(task_data['state']);
                      if (task_data['state'] == 'unlike') {
                        // いいねボタンの表示
                        console.log('ok');
                        input_tag.className = "like btn icon-btn btn-primary btn-color-un";
                        input_icon.className = "glyphicon btn-glyphicon glyphicon-thumbs-up img-circle text-color-un";
                      } else {
                        // いいね取り消しボタンの表示
                        console.log('unok');
                        input_tag.className = "like btn icon-btn btn-primary btn-color-like";
                        input_icon.className = "glyphicon btn-glyphicon glyphicon-thumbs-up img-circle text-color-like";
                      }
                      
                      // いいね数の表示
                      var num_like = 'num_like_' + task_data['id'];
                      console.log(num_like)
                      document.getElementById(num_like).innerHTML = '&thinsp;' + task_data['like_cnt'] + '人';
                    
                    }).fail(function(data) {
                      alert('error!!!' + data);
                    });
                  });
                } else {
                  $('#posts')
                  .append('<div><input type="submit" value="いいね！" id="' + haiku_id + '" class="like btn btn-primary btn-xs"></div>')
                  .on('click', '#' + haiku_id, function() { // よし機能
                  var haiku_id = $(this).attr('id'); // クリックされたタグのtweet_idの値を取得
                  var data = {haiku_id : haiku_id}; 
                  
                  $.ajax({
                      type: "POST",
                      url: "send_like.php",
                      data: data,
                  
                  }).done(function(data) {
                    
                    var task_data = JSON.parse(data);
                    var input_tag = document.getElementById(task_data['id']);
                    console.log(task_data['state']);
                    if (task_data['state'] == 'unlike') {
                      // いいねボタンの表示
                      console.log('ok');
                      input_tag.className = "btn btn-primary btn-xs";
                      input_tag.value = "いいね！"
                    } else {
                      // いいね取り消しボタンの表示
                      console.log('unok');
                      input_tag.className = "btn btn-danger btn-xs";
                      input_tag.value = "いいね！取り消し";
                    }
                    
                    // いいね数の表示
                    var num_like = 'num_like_' + task_data['id'];
                    console.log(num_like)
                    document.getElementById(num_like).textContent = 'いいね数：' + task_data['like_cnt'];
                  
                  }).fail(function(data) {
                    alert('error!!!' + data);
                  });
                });              
                }

                // コメント欄
                var comments = post['comments'];
                var login_user_picture = task_data['login_user_picture'];
                 
                $('#posts')
                .append('<div class="preview"><button id="' + comment_id + '" class="comment_button">コメント</button><div id="' + comment_id + '_content" style="text-align: center; color: white; background-color: rgb(0, 153,255); display: none;"><img src="assets/images/' + login_user_picture + '" width="48" height="48"><br><input type="text" class="comment_content" id="' + comment_id + '_input" name="hoge" class="form-control" placeholder="例： comment" style="color: black;"><div id="' + haiku_id + '_cont"></div></div></div><div style="text-align: right;"><div style="float: left"><i id="' + num_like + '" class="glyphicon glyphicon-thumbs-up icon-margin">&thinsp;' + count)
                
                // .on('click', '#' + comment_id, function() { // コメント欄の表示
                //   console.log('hoge11')
                //   var haiku_id = $(this).attr('id'); // クリックされたコメントボタンidの取得
                //   var com_id = haiku_id + '_content'
                //   console.log(com_id)
                //   $("#" + com_id).slideToggle();
                //   console.log('hoge12')
                // })

                .on('keypress' , '#' + comment_id + '_input', function (e) {  // コメントの送信
                  if (e.which == 13) {
                    // ここに処理を記述
                    var haiku_id = $(this).attr('id');
                    console.log(haiku_id)
                    var array = haiku_id.match(/[0-9]+\.?[0-9]*/g);
                    var h_id = array[0];
                    console.log(h_id)
                    var comment = $(this).attr('value');
                    console.log(comment);
                    var data = {comment : comment,
                                haiku_id: h_id};

                    $.ajax({
                      type: "POST",
                      url: "send_comment.php",
                      data: data,
                    /**
                     * Ajax通信が成功した場合に呼び出されるメソッド
                     */
                    }).done(function(data) {
                      // Ajax通信が成功した場合に呼び出される
                      // PHPから返ってきたデータの表示
                      // var task_data = JSON.parse(data);
                      // alert(data);
                      // jsonデータをJSの配列にパース（変換）する
                      var task_data = JSON.parse(data);
                      haiku_id = task_data['id'] + '_cont'
                      console.log(haiku_id)

                      // 新規コメントの追加
                      $('#' + haiku_id).prepend('<p>' + task_data['nick_name'] + '</p><img src="assets/images/' + task_data['user_picture_path'] + '" width="48" height="48"><p>' + task_data['comment'] + '</p><p>' + task_data['created'] + '</p>');

                    /**
                     * Ajax通信が失敗した場合に呼び出されるメソッド
                     */
                    }).fail(function(data) {
                        alert('error!!!' + data);
                    });
                  }
                });

                console.log('hoge3');
                console.log(comments);

                // コメントがあるかチェック
                if (comments.length > 0) {
                  // 繰り返し文
                  comments.forEach(function(comment) {
                    $('#' + haiku_id + '_cont')
                    .append('<p><a>' + comment['nick_name'] + '</a></p><img src="assets/images/' + comment['user_picture_path'] + '" width="48" height="48"><p>' + comment['comment'] + '</p><p>' + comment['created'] + '</p>')
                    .on('click', 'a', function() {
                      location.href = 'user.php?user_id=' + comment['member_id'];
                    });
                  });
                };


                console.log('hoge5');
                
              }); // foreachの終了

            } else { // 最後の投稿が済んだら
              $('#posts').append('');
            }

            $('#loading').hide();
            
          }).fail(function(data) {
            alert('error!!!' + data);
          });
        }
      });
    });

    // 縦書きにする関数
    function tateGaki(haiku) {
      var letters = haiku.split('');
      var v_haiku = '';
      letters.forEach(function(letter) {
        v_haiku += letter + "<br>";
      });
      return v_haiku.substr(0, v_haiku.length-4);
    };
  </script>

</body>
</html>