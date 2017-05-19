// 俳句入力フォームの文字数チェック
// 上の句
$(function(){
  $('#up_haiku')
    .mouseup(function(){
      $(this).mouseout(function(){
        var input_id = $(this).attr('id');
        var valid_id = input_id + '_valid';
        $.when(
          checkNumLetters('#' + input_id)
        ).done(function(check) {
          if (check == 1) {
            // 文字数OK
            $('#' + valid_id).css('display','none');
          } else {
            // 文字数ダメ
            $('#' + valid_id).css('display','');
          }
        })
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
        $.when(
          checkNumLettersMd('#' + input_id)
        ).done(function(check) {
          if (check == 1) {
            // 文字数OK
            $('#' + valid_id).css('display','none');
          } else {
            // 文字数ダメ
            $('#' + valid_id).css('display','');
          }
        })
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
        $.when(
          checkNumLetters('#' + input_id)
        ).done(function(check) {
          if (check == 1) {
            // 文字数OK
            $('#' + valid_id).css('display','none');
          } else {
            // 文字数ダメ
            $('#' + valid_id).css('display','');
          }
        })
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
        if (num_letters < 21) {
          // 文字数OK
          $('#' + valid_id).css('display','none');
        } else {
          // 文字数ダメ
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

// 詠むボタン（タイムライン）
$(function(){
  $('#yomu')
    .mouseover(function(){
      // 俳句、一言説明の文字数チェック
      $.when(
          checkNumLetters('#up_haiku'),
          checkNumLetters('#md_haiku'),
          checkNumLetters('#lw_haiku')
      ).done(function(check_up, check_md, check_lw) {
        if (check_up == 1 && check_md == 1 && check_lw == 1 && countNumLetters('#short_comment') < 21) {
          // 画像のチェック
          var file_name = getFileName('photo_file');
          if (file_name == '') { // 画像選択されてない
            // バリデーションクリア
            $('#yomu_pre').css('display','none');
            $('#yomu_ready').css('display','');
          } else { // 画像選択されてる→画像形式のチェック
            if (checkPhotoFile(file_name)) {
              // バリデーションクリア
              $('#yomu_pre').css('display','none');
              $('#yomu_ready').css('display','');
            } else {
              // バリデーションアウト
              $('#yomu_pre').css('display','');
              $('#yomu_ready').css('display','none');
            }
          }
        } else {
          // バリデーションアウト
          $('#yomu_pre').css('display','');
          $('#yomu_ready').css('display','none');
        }
      })
    })
});

// 詠むボタン（チャット）
$(function(){
  $('#yomu-chat')
    .mouseover(function(){
      // 俳句、一言説明の文字数チェック
      $.when(
          checkNumLetters('#up_haiku'),
          checkNumLetters('#md_haiku'),
          checkNumLetters('#lw_haiku')
      ).done(function(check_up, check_md, check_lw) {
        if (check_up == 1 && check_md == 1 && check_lw == 1) {
          // 画像のチェック
          var file_name = getFileName('photo_file');
          if (file_name == '') { // 画像選択されてない
            // バリデーションクリア
            $('#yomu_pre').css('display','none');
            $('#yomu_ready').css('display','');
          } else { // 画像選択されてる→画像形式のチェック
            if (checkPhotoFile(file_name)) {
              // バリデーションクリア
              $('#yomu_pre').css('display','none');
              $('#yomu_ready').css('display','');
            } else {
              // バリデーションアウト
              $('#yomu_pre').css('display','');
              $('#yomu_ready').css('display','none');
            }
          }
        } else {
          // バリデーションアウト
          $('#yomu_pre').css('display','');
          $('#yomu_ready').css('display','none');
        }
      })
    })
});

// 
// 関数定義
// 

// 文字数カウント
function countNumLetters(obj) {

  var letters = $(obj).val();
  var num_letters = letters.length;
  return num_letters;
}

// ひらがな化
function kanaKa(obj) {
  var defer = $.Deferred();

  // 入力された文字列の取得
  var letters = $(obj).val();

  // 漢字をひらがな化するためapiの利用処理
  var data = {sentence : letters};

  $.ajax({
    type: "POST",
    url: "send/hiragana_ka.php",
    data: data,

  }).done(function(data) {
    var task_data = JSON.parse(data);
    var kana = task_data['sentence'];
    
    // 文字数取得
    var num_letters = kana.length;

    defer.resolve(num_letters);

  }).fail(function(data) {
    alert('error!!!' + data);
  });

  return defer.promise(this);
}


// 文字数チェック（上の句・下の句）
function checkNumLetters(obj) {
  var defer = $.Deferred();

  $.when(
    kanaKa(obj)
  ).done(function(num_letters) {

    if (num_letters > 3 && num_letters < 7) {
      var check = 1;
    } else {
      var check = 0;
    }

    defer.resolve(check);
  });

  return defer.promise(this);
}

// 文字数チェック（中の句）
function checkNumLettersMd(obj) {
  var defer = $.Deferred();

  $.when(
    kanaKa(obj)
  ).done(function(num_letters) {

    if (num_letters > 5 && num_letters < 9) {
      var check = 1;
    } else {
      var check = 0;
    }

    defer.resolve(check);
  });

  return defer.promise(this);
}

// 画像名の表示
function changePhotoFile() {
  var file_name = getFileName('photo_file');
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