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