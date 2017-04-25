<?php
session_start();
require('dbconnect.php');

$_SESSION['login_member_id'] = 1;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
    <!-- For Modal Window -->
    <link rel="stylesheet" type="text/css" href="assets/css/modal_window.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
</head>
<body>

  <!-- 詠むボタン（MWの呼び出し） -->
  <input type="submit" id="modal-open" class="btn btn-info" value="詠む" style="background-color: #00a381;">

  <!-- 句入力フォーム -->
  <div id="modal-content_1" class="content">
    <form action="send_haiku.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
      <!-- 句入力 -->
      <input type="text" class="form-control haiku" id="up_haiku" name="up_haiku" placeholder="１行目（四〜六文字）"><br>
      <p id="up_haiku_valid" style="display: none">四から六文字で入力してください</p>
      
      <input type="text" class="form-control haiku" id="md_haiku" name="md_haiku" placeholder="２行目（四〜六文字）"><br>
      <p id="md_haiku_valid" style="display: none">六から八文字で入力してください</p>
      
      <input type="text" class="form-control haiku" id="lw_haiku" name="lw_haiku" placeholder="３行目（四〜六文字）"><br>
      <p id="lw_haiku_valid" style="display: none">四から六文字で入力してください</p>

      <!-- 一言説明 -->
      <input type="text" class="form-control" id="short_comment" name="short_comment" placeholder="一言説明（二十文字以下）"><br>
      <p id="short_comment_valid" style="display: none">二十文字以内で入力してください</p>

      <!-- 写真挿入 -->
      <div>
        <input type="file" id="photo_file" name="photo_file" style="display:none;" onchange="changePhotoFile();">
        <img id="photo_img" src="assets/images/photo_submit.png" alt="参照" width="30px" height="30px">
        <input id="photo_display" type="text" name="photo_display" value="" size="50">
      </div>

      <!-- 詠むボタン -->
      <div id="yomu">
        <button type="button" id="yomu_pre" class="btn btn-info" style="background-color: #c8c2c6; border-color: #c8c2c6;">詠む</button>
        <input id="yomu_ready" type="submit" class="btn btn-info" value="詠む" style="background-color: #00a381; display: none;">
      </div>
    </form>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <!-- jQuery (necessary for Modal Window) -->
  <script src="assets/js/modal_window.js"></script>

  <script>
    // 1番最初のモーダルウィンドウ呼び出し
    modalWindowOnFirst('modal-open');

    // 2番目のモーダルウィンドウ呼び出し
    // modalWindowOn('modal-check', 'modal-content_1', 'modal-content_2');

    // モーダルウィンドウの終了
    // modalWindowOff('modal-close', 'modal-content_2');

    //リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
    $(window).resize(centeringModalSyncer);
  </script>

  <script type="text/javascript">
    // 俳句入力フォームの文字数チェック
    // 上の句
    $(function(){
      $('#up_haiku')
        .mouseup(function(){
          $(this).mouseout(function(){
            var input_id = $(this).attr('id');
            var valid_id = input_id + '_valid';
            if (checkNumLetters(this)) {
              // 文字数OK
              console.log('hoge21');
              $('#' + valid_id).css('display','none');
            } else {
              // 文字数ダメ
              console.log('hoge22');
              $('#' + valid_id).css('display','');
            }
            
          })
        })  
    });

    // 中の句
    $(function(){
      $('#md_haiku')
        .mouseup(function(){
          $(this).mouseout(function(){
            var input_id = $(this).attr('id');
            var valid_id = input_id + '_valid';
            if (checkNumLettersMd(this)) {
              // 文字数OK
              console.log('hoge21');
              $('#' + valid_id).css('display','none');
            } else {
              // 文字数ダメ
              console.log('hoge22');
              $('#' + valid_id).css('display','');
            }
            
          })
        })
    });

    // 下の句
    $(function(){
      $('#lw_haiku')
        .mouseup(function(){
          $(this).mouseout(function(){
            var input_id = $(this).attr('id');
            var valid_id = input_id + '_valid';
            if (checkNumLetters(this)) {
              // 文字数OK
              console.log('hoge21');
              $('#' + valid_id).css('display','none');
            } else {
              // 文字数ダメ
              console.log('hoge22');
              $('#' + valid_id).css('display','');
            }
            
          })
        })
    });

    // 一言説明
    $(function(){
      $('#short_comment')
        .mouseup(function(){
          $(this).mouseout(function(){
            var input_id = $(this).attr('id');
            var valid_id = input_id + '_valid';
            var num_letters = countNumLetters(this);
            if (num_letters < 31) {
              // 文字数OK
              console.log('hoge21');
              $('#' + valid_id).css('display','none');
            } else {
              // 文字数ダメ
              console.log('hoge22');
              $('#' + valid_id).css('display','');
            }
          })
        })
    });

    // 写真バリデーション
    $(function() {
      $("#photo_img").click(function() {
      var photo_file = document.getElementById("photo_file");
      photo_file.click();
      });
    });

    // 詠むボタン
    $(function(){
      $('#yomu')
        .mouseover(function(){
          // 俳句、一言説明の文字数チェック
          if (checkNumLetters('#up_haiku') && checkNumLettersMd('#md_haiku') && checkNumLetters('#lw_haiku') && countNumLetters('#short_comment') < 31) {
            console.log('hoge100');
            // 画像のチェック
            var file_name = getFileName('photo_file');
            if (file_name == '') { // 画像選択されてない
              console.log('hoge101');
              // バリデーションクリア
              $('#yomu_pre').css('display','none');
              $('#yomu_ready').css('display','');
            } else { // 画像選択されてる→画像形式のチェック
              console.log('hoge102');
              if (checkPhotoFile(file_name)) {
                console.log('hoge103');
                // バリデーションクリア
                $('#yomu_pre').css('display','none');
                $('#yomu_ready').css('display','');
              } else {
                console.log('hoge104');
                // バリデーションアウト
                $('#yomu_pre').css('display','');
                $('#yomu_ready').css('display','none');
              }
            }
          } else {
            console.log('hoge105');
            // バリデーションアウト
            $('#yomu_pre').css('display','');
            $('#yomu_ready').css('display','none');
          }
        })
    });

    // 
    // 関数定義
    // 

    // 文字数カウント
    function countNumLetters(obj) {
      console.log('hoge10');
      var letters = $(obj).val();
      var num_letters = letters.length;
      console.log(num_letters);
      return num_letters;
    }

    // 文字数チェック（上の句・下の句）
    function checkNumLetters(obj) {
      var num_letters = countNumLetters(obj);
      if (num_letters > 3 && num_letters < 7) {
        console.log('hoge11');
        return true;
      } else {
        console.log('hoge12');
        return false;
      }
    }

    // 文字数チェック（中の句）
    function checkNumLettersMd(obj) {
      var num_letters = countNumLetters(obj);
      if (num_letters > 5 && num_letters < 9) {
        console.log('hoge13');
        return true;
      } else {
        console.log('hoge14');
        return false;
      }
    }
    
    // 画像の表示
    function changePhotoFile() {
      var file_name = getFileName('photo_file');
      console.log(file_name);
      if (checkPhotoFile(file_name)) { 
        document.getElementById("photo_display").value = file_name;
      } else if (file_name == '') {
        document.getElementById("photo_display").value = '';
      } else {
        document.getElementById("photo_display").value = 'jpg, png, gif形式の画像を選択してください。';
      }
    }

    // 画像形式のチェック
    function checkPhotoFile(file_name) {
      var type = file_name.slice(-3);
      type = type.toLowerCase();
      if (type == 'jpg' || type == 'png' || type == 'gif') { 
        return true;
      } else {
        return false;
      }
    }

    // ファイル名の取得
    function getFileName(id) {
      var photo_file = document.getElementById(id).value;
      var regex = /\\|\\/;
      var array = photo_file.split(regex);
      var file_name = array[array.length - 1];
      return file_name;
    }

  </script>
</body>
</html>